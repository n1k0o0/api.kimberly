<?php

namespace App\Services;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class TeamService
{
    /**
     * @param array $data
     *
     * @return Model
     */
    public function createTeam(array $data): Model
    {
        $team = Team::query()->create($data);
        $team->loadMissing('division', 'league', 'color');

        return $team;
    }

    /**
     * @param int $teamId
     * @param array $data
     *
     * @return Model|Collection|null
     */
    public function updateTeam(int $teamId, array $data): Model|Collection|null
    {
        $team = Team::query()->find($teamId);
        $team->update($data);
        $team->loadMissing('division', 'league', 'color');

        return $team;
    }

    /**
     * @param int $teamId
     *
     * @return mixed
     */
    public function removeTeam(int $teamId): mixed
    {
        return Team::query()->where('id', $teamId)->delete();
    }
}
