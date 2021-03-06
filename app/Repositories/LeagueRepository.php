<?php

namespace App\Repositories;

use App\Models\League;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
            ->with('city', 'country', 'divisions')
            ->find($leagueId);
    }

    /**
     * @param array $data
     *
     * @param int|null $limit
     *
     * @return LengthAwarePaginator|Collection
     */
    public function getLeagues(array $data=[], int $limit=null): LengthAwarePaginator|Collection
    {
        $query = League::query()
            ->when(isset($data['country_ids']),
                fn (Builder $query) =>  $query->whereHas(
                    'country',
                    fn(Builder $builder) => $builder->whereIn('countries.id', $data['country_ids'])
                )
            )
            ->when(isset($data['country_id']), fn (Builder $query) => $query->whereHas(
                'country',
                fn(Builder $builder) => $builder->where('countries.id', $data['country_id'])
            ))
            ->when(isset($data['city_ids']), fn (Builder $query) => $query->whereIn('city_id', $data['city_ids']))
            ->when(isset($data['city_id']), fn (Builder $query) => $query->where('city_id', $data['city_id']))
            ->with('city', 'country', 'divisions');

        if ($limit) {
            return $query->latest()->paginate($limit);
        }
        return $query->get();
    }
}
