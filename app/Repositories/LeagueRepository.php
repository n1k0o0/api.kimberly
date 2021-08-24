<?php

namespace App\Repositories;

use App\Models\League;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LeagueRepository
{
    /**
     * @param int $leagueId
     *
     * @return Model|League|null
     */
    public function getById(int $leagueId): Model|League|null
    {
        return League::query()
            ->with('city', 'country')
            ->find($leagueId);
    }

    /**
     * @param int $limit
     * @param array $data
     *
     * @return LengthAwarePaginator
     */
    public function paginateStadiums(int $limit, array $data): LengthAwarePaginator
    {
        return League::query()
            ->when(isset($data['country_ids']),
                fn (Builder $query) =>  $query->whereHas(
                    'country',
                    fn(Builder $builder) => $builder->whereIn('countries.id', $data['country_ids'])
                )
            )
            ->when(isset($data['city_ids']), fn (Builder $query) => $query->whereIn('city_id', $data['city_ids']))
            ->with('city', 'country')
            ->paginate($limit);
    }
}
