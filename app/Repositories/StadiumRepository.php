<?php

namespace App\Repositories;

use App\Models\Stadium;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class StadiumRepository
{
    /**
     * @param int $stadiumId
     *
     * @return Model|Stadium|null
     */
    public function getById(int $stadiumId): Model|Stadium|null
    {
        return Stadium::query()
            ->with('city', 'country')
            ->find($stadiumId);
    }

    /**
     * @param array $data
     *
     * @param int|null $limit
     * @return Collection|LengthAwarePaginator
     */
    public function getStadiums(array $data = [], int $limit = null): Collection|LengthAwarePaginator
    {
        $query = Stadium::query()
            ->when(isset($data['country_id']),
                fn(Builder $query) => $query->whereHas(
                    'country',
                    fn(Builder $builder) => $builder->where('countries.id', $data['country_id'])
                )
            )
            ->when(isset($data['country_ids']),
                fn(Builder $query) => $query->whereHas(
                    'country',
                    fn(Builder $builder) => $builder->whereIn('countries.id', $data['country_ids'])
                )
            )
            ->when(isset($data['city_id']), fn(Builder $query) => $query->where('city_id', $data['city_id']))
            ->when(isset($data['city_ids']), fn(Builder $query) => $query->whereIn('city_id', $data['city_ids']))
            ->with('city', 'country');

        if ($limit) {
            return $query->latest()->paginate($limit);
        }
        return $query->get();
    }
}
