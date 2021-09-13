<?php

namespace App\Services;

use App\Models\Coach;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CoachService
{
    /**
     * @param array $data
     *
     * @return Model
     */
    public function createCoach(array $data): Model
    {
        try {
            DB::beginTransaction();
            /** @var Coach $coach */
            $coach = Coach::query()->create($data);
            if (isset($data['avatar'])) {
                $coach->addMedia($data['avatar'])->toMediaCollection(Coach::AVATAR_MEDIA_COLLECTION);
                $coach->loadMissing('avatar');
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $coach;
    }

    /**
     * @param int $coachId
     * @param $data
     *
     * @return Model|Collection|null
     */
    public function updateCoach(int $coachId, $data): Model|Collection|null
    {
        /** @var Coach $coach */
        try {
            DB::beginTransaction();
            $coach = Coach::query()->find($coachId);
            $coach->update($data);
            if (isset($data['avatar'])) {
                $coach->replaceMedia($data['avatar'], Coach::AVATAR_MEDIA_COLLECTION);
                $coach->loadMissing('avatar');
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        return $coach;
    }

    /**
     * @param int $coachId
     *
     * @return mixed
     */
    public function removeCoach(int $coachId): mixed
    {
        return Coach::query()->where('id', $coachId)->delete();
    }
}
