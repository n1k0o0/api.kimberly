<?php

namespace App\Services;

use App\Models\Coach;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class CoachService
{
    /**
     * @param array $data
     *
     * @return Model
     */
    public function createCoach(array $data): Model
    {
        $coach = Coach::query()->create($data);

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
        $coach = Coach::query()->find($coachId);
        $coach->update($data);

        return $coach;
    }

    /**
     * @param int $coachId
     *
     * @return mixed
     */
    public function removeCoach(int $coachId)
    {
        return Coach::query()->where('id', $coachId)->delete();
    }
}
