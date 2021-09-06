<?php

namespace App\Services;

use App\Events\School\SchoolCreated;
use App\Exceptions\BusinessLogicException;
use App\Models\School;
use App\Repositories\SchoolRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SchoolService
{
    /**
     */
    public function __construct
    (
        private SchoolRepository $schoolRepository
    )
    {
    }

    /**
     * @param array $data
     * @param int $limit
     *
     * @return LengthAwarePaginator
     */
    public function getSchools(array $data = [], int $limit = null): LengthAwarePaginator
    {
        $schools = $this->schoolRepository->getSchools($data, $limit);

        return $schools;
    }

    /**
     * @throws \Exception
     */
    public function createSchool(array $data): Model
    {
        $data['status'] = School::STATUS_MODERATION;
        try {
            DB::beginTransaction();
            /** @var School $school */
            $school = School::query()->create($data);
            if (isset($data['avatar'])) {
                $school->addMedia($data['avatar'])->toMediaCollection(School::AVATAR_MEDIA_COLLECTION);
                $school->loadMissing('media_avatar');
            }
            if (isset($data['teams'])) {
                $school->teams()->createMany($data['teams']);
            }
            if (isset($data['coaches'])) {
                $school->coaches()->createMany($data['coaches']);
            }
            DB::commit();
            event(new SchoolCreated($school));
        } catch (\Exception $exception) {
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
        $school = $this->schoolRepository->getById($schoolId);

        return $school;
    }

    /**
     * @param int $schoolId
     * @param array $data
     *
     * @return Model|School|null
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function updateSchool(int $schoolId, array $data): Model|School|null
    {
        $school = $this->schoolRepository->getById($schoolId);
        try {
            DB::beginTransaction();
            $school->update($data);
            if (isset($data['avatar'])) {
                $school->replaceMedia($data['avatar'],School::AVATAR_MEDIA_COLLECTION);
                $school->loadMissing('media_avatar');
            }
            DB::commit();
        } catch (\Exception $exception) {
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
        $school->update([
            'status' => $status,
        ]);

        return $school;
    }
}
