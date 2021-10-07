<?php

namespace App\Services;

use App\Models\Team;
use App\Repositories\TeamRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class TeamService
{

    public function __construct(private TeamRepository $teamRepository)
    {
    }

    /**
     * @param array $data
     * @param int|null $limit
     * @return Collection|LengthAwarePaginator
     */
    public function getTeams(array $data = [], int $limit = null): Collection|LengthAwarePaginator
    {
        return $this->teamRepository->getTeams($data, $limit);
    }

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
        $team = Team::query()->without('color')->find($teamId);
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
