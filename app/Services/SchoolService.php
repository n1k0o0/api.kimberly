<?php

namespace App\Services;

use App\Events\School\SchoolCreated;
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
}
