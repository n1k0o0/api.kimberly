<?php

namespace App\Repositories;

use App\Models\Tournament;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TournamentRepository
{
    /**
     * @param int $tournamentId
     *
     * @return Model|Tournament|null
     */
    public function getById(int $tournamentId): Model|Tournament|null
    {
        return Tournament::query()
            ->with('city', 'country')
            ->find($tournamentId);
    }

    /**
     * @param array $data
     *
     * @param int|null $limit
     * @return Collection|LengthAwarePaginator
     */
    public function getTournaments( array $data=[] ,int $limit=null): Collection|LengthAwarePaginator
    {
        $query = Tournament::query()
            ->when(isset($data['country_ids']),
                fn (Builder $query) =>  $query->whereHas(
                    'country',
                    fn(Builder $builder) => $builder->whereIn('countries.id', $data['country_ids'])
                )
            )
            ->when(isset($data['city_ids']), fn (Builder $query) => $query->whereIn('city_id', $data['city_ids']))
            ->when(isset($data['city_id']), fn (Builder $query) => $query->where('city_id', $data['city_id']))
            ->with('city', 'country');

            if ($limit) {
                return $query->latest()->paginate($limit);
            }
        return $query->get();
    }

    /**
     * @param int $cityId
     *
     * @return Tournament|Model
     */
    public function getCurrentTournament(int $cityId): Tournament|Model
    {
        return Tournament::query()
            ->where('city_id', $cityId)
            ->where('status', Tournament::STATUS_CURRENT)
            ->firstOrFail();
    }
}
