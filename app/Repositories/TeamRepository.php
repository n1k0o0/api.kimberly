<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository
{
    public function getTeams(array $data = [], int $limit = null): Collection|LengthAwarePaginator
    {
        $query = Team::query()
            ->when(isset($data['divisions']), fn (Builder $query) => $query->whereIn('division_id', $data['divisions']))
            ->with('school', 'color');
        if ($limit) {
            return $query->latest()->paginate($limit);
        }
        return $query->get();
    }

    /**
     * @param int $teamId
     *
     * @return Model|Team|null
     */
    public function getTeamById(int $teamId): Model|Team|null
    {
        return Team::query()
            ->with('division', 'league', 'color')
            ->find($teamId);
    }
}
