<?php

namespace App\Repositories;

use App\Models\Tournament;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
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
     * @param int $limit
     * @param array $data
     *
     * @return LengthAwarePaginator
     */
    public function paginateTournaments(int $limit=10, array $data=[]): LengthAwarePaginator
    {
        return Tournament::query()
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
