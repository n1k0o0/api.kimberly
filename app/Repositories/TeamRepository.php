<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TeamRepository
{
    public function getTeams(array $data = [], int $limit = null): Collection|LengthAwarePaginator
    {
        $query = Team::query()
            ->when(
                isset($data['division_ids']),
                fn(Builder $query) => $query->whereIn('division_id', $data['division_ids'])
            )
            ->when(isset($data['division_id']), fn(Builder $query) => $query->where('division_id', $data['division_id'])
            );
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
            ->with('division', 'league')
            ->findOrFail($teamId);
    }
}
