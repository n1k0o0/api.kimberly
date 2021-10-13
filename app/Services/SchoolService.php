<?php

namespace App\Services;

use App\Events\School\SchoolCreated;
use App\Exceptions\BusinessLogicException;
use App\Models\Coach;
use App\Models\School;
use App\Models\Team;
use App\Models\User;
use App\Repositories\SchoolRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SchoolService
{
    public function __construct
    (
        private SchoolRepository $schoolRepository,
        private UserRepository $userRepository
    ) {
    }

    /**
     * @param array $data
     * @param int|null $limit
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getSchools(array $data = [], int $limit = null): Collection|LengthAwarePaginator
    {
        return $this->schoolRepository->getSchools($data, $limit);
    }

    /**
     * @throws Exception
     */
    public function createSchool(int $userId, array $data): Model
    {
        /** @var User $user */
        $user = $this->userRepository->getById($userId);
        if ($user->school()->exists()) {
            throw new BusinessLogicException('Школа уже создана');
        }

        $data['status'] = School::STATUS_MODERATION;
        try {
            DB::beginTransaction();
            /** @var School $school */
            $school = $user->school()->create($data);
            if (isset($data['avatar'])) {
                $school->addMedia($data['avatar'])->toMediaCollection(School::AVATAR_MEDIA_COLLECTION);
                $school->loadMissing('media_avatar');
            }
            if (isset($data['teams'])) {
                $this->checkTeamsForDuplicateColor($data['teams']);

                $school->teams()->createMany($data['teams']);
            }
            if (isset($data['coaches'])) {
                $coaches = $school->coaches()->createMany($data['coaches']);
                $coaches->each(function ($item, $key) use ($data) {
                    if (data_get($data['coaches'][$key], 'avatar')) {
                        $item->addMedia($data['coaches'][$key]['avatar'])->toMediaCollection(
                            Coach::AVATAR_MEDIA_COLLECTION
                        );
                    }
                });
            }
            if (isset($data['social_links'])) {
                $school->coaches()->createMany($data['social_links']);
            }

            DB::commit();
            event(new SchoolCreated($school));
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $school;
    }

    /**
     * @param int $schoolId
     *
     * @return School|Model|null
     */
    public function getSchoolById(int $schoolId): Model|School|null
    {
        return $this->schoolRepository->getById($schoolId);
    }

    /**
     * @param int $schoolId
     * @param array $data
     *
     * @return Model|School|null
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updateSchool(int $schoolId, array $data): Model|School|null
    {
        $school = $this->schoolRepository->getById($schoolId);
        try {
            DB::beginTransaction();
            $school->update($data);
            if (isset($data['avatar'])) {
                $school->replaceMedia($data['avatar'], School::AVATAR_MEDIA_COLLECTION);
                $school->loadMissing('media_avatar');
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $school;
    }

    /**
     * @param int $schoolId
     *
     * @return bool|null
     * @throws BusinessLogicException
     */
    public function removeSchool(int $schoolId): ?bool
    {
        $school = $this->schoolRepository->getById($schoolId);
        if ($school->status !== School::STATUS_MODERATION) {
            throw new BusinessLogicException("Школа не в статусе модерации");
        }

        return $school->delete();
    }

    /**
     * @param int $schoolId
     * @param string $status
     *
     * @return Model|School|null
     */
    public function setStatus(int $schoolId, string $status): Model|School|null
    {
        $school = $this->schoolRepository->getById($schoolId);
        if ($school->status === School::STATUS_MODERATION && $status === School::STATUS_PUBLISHED) {
            $school->update([
                'status' => $status,
            ]);
        }

        return $school;
    }

    /**
     * @param int $userId
     * @param array $data
     *
     * @return School|Model
     * @throws BusinessLogicException
     * @throws Exception
     */
    public function updateSchoolByUserId(int $userId, array $data): School|Model
    {
        /** @var User $user */
        $user = $this->userRepository->getById($userId);
        /** @var School $school */
        if (!$school = $user->school()->first()) {
            throw new BusinessLogicException('Школа еще не создана');
        }
        try {
            DB::beginTransaction();

            $requestTeamsIds = array_column((data_get($data, 'teams') ?? []), 'id');
            if (isset($data['teams_del_id'])) {
                if (array_intersect($data['teams_del_id'], $requestTeamsIds)) {
                    throw new BusinessLogicException("Нельзя редактировать и удалять одновременно команду!");
                }
                Team::destroy($data['teams_del_id']);
            }
            if (isset($data['coaches_del_id'])) {
                if (array_intersect($data['coaches_del_id'], array_column((data_get($data, 'coaches') ?? []), 'id'))) {
                    throw new BusinessLogicException("Нельзя редактировать и удалять одновременно тренера!");
                }
                Coach::destroy($data['coaches_del_id']);
            }
            if (isset($data['teams'])) {
                $existsTeams = $school->teams()->without('color', 'school')->get(['id', 'color_id', 'division_id']
                )->toArray();
                $dbTeamsMinusRequestTeams = array_filter($existsTeams, static fn($value) => !in_array($value['id'], $requestTeamsIds, false)
                );
                $allTeams = [...$data['teams'], ...$dbTeamsMinusRequestTeams];

                $this->checkTeamsForDuplicateColor($allTeams);
                array_walk($data['teams'], static function ($el, $key) use (&$data, $school) {
                    $data['teams'][$key]['school_id'] = $school->id;
                });

                Team::query()->upsert([...$data['teams']], ['id'], ['color_id']);
            }
            if (isset($data['coaches'])) {
                foreach ($data['coaches'] as $coach) {
                    $newCoach = $school->coaches()->updateOrCreate(
                        ['id' => data_get($coach, 'id')],
                        array_diff_key($coach, array('avatar' => 0))
                    );
                    if ($coach['avatar']) {
                        if (!empty($newCoach->avatar)) {
                            $newCoach->replaceMedia($coach['avatar'], Coach::AVATAR_MEDIA_COLLECTION);
                        } else {
                            $newCoach->addMedia($coach['avatar'])->toMediaCollection(Coach::AVATAR_MEDIA_COLLECTION);
                        }
                    }
                }
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $school;
    }

    /**
     * @param $teams
     * @return mixed
     * @throws BusinessLogicException
     */
    public function checkTeamsForDuplicateColor($teams): void
    {
        $teamsGroupedByDivision = [];
        foreach ($teams as $team) {
            $teamsGroupedByDivision[$team['division_id']][] = $team;
        }

        foreach ($teamsGroupedByDivision as $teamsByDivision) {
            if (count($teamsByDivision) > 1) {
                $colorIds = array_map(static fn($value) => data_get($value, 'color_id'), $teamsByDivision);

                if (in_array(null, $colorIds, true)) {
                    throw new BusinessLogicException(
                        "Обязательно выберите цвет при создании 2-х одинаковых команд"
                    );
                }
                if ((count($colorIds) !== count(array_unique($colorIds)))) {
                    throw new BusinessLogicException("Выберите разные цвета");
                }
            }
        }
    }
}
