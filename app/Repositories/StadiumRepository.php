<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stadium;

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
     * @param int $limit
     * @param array $data
     *
     * @return LengthAwarePaginator
     */
    public function paginateStadiums(int $limit=10, array $data=[]): LengthAwarePaginator
    {
        return Stadium::query()
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
