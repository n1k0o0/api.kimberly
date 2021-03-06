<?php

namespace App\Repositories;

use App\Models\School;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SchoolRepository
{
    /**
     * @param int $tournamentId
     *
     * @return Model|School|null
     */
    public function getById(int $tournamentId): Model|School|null
    {
        return School::query()
            ->with(
                'city',
                'country',
                'coaches.avatar',
                'teams.division',
                'teams.league.city',
                'teams.color',
                'social_links',
                'media_avatar'
            )
            ->findOrFail($tournamentId);
    }

    /**
     * @param array $data
     *
     * @param int|null $limit
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getSchools(array $data = [], int $limit = null): Collection|LengthAwarePaginator
    {
        $query = School::query()
            ->when(isset($data['country_ids']),
                fn(Builder $query) => $query->whereHas(
                    'country',
                    fn(Builder $builder) => $builder->whereIn('countries.id', $data['country_ids'])
                )
            )
            ->when(isset($data['country_id']), fn(Builder $query) => $query->whereHas(
                'country',
                fn(Builder $builder) => $builder->where('countries.id', $data['country_id'])
            ))
            ->when(isset($data['city_ids']), fn(Builder $query) => $query->whereIn('city_id', $data['city_ids']))
            ->when(isset($data['city_id']), fn(Builder $query) => $query->where('city_id', $data['city_id']))
            ->when(isset($data['name']), fn(Builder $query) => $query->where('name', 'like', '%' . $data['name'] . '%'))
            ->when(
                isset($data['league_id']),
                fn(Builder $query) => $query->whereHas('teams.division', function ($q) use ($data) {
                    $q->where('league_id', $data['league_id']);
                })
            )
            ->when(
                isset($data['division_id']),
                fn(Builder $query) => $query->whereHas('teams', function ($q) use ($data) {
                    $q->where('division_id', $data['division_id']);
                })
            )
            ->when(
                isset($data['league_ids']),
                fn(Builder $query) => $query->whereHas('teams.division', function ($q) use ($data) {
                    $q->whereIn('league_id', $data['league_ids']);
                })
            )
            ->when(
                isset($data['division_ids']),
                fn(Builder $query) => $query->whereHas('teams', function ($q) use ($data) {
                    $q->whereIn('division_id', $data['division_ids']);
                })
            )
            ->with('city', 'country');

        if ($limit) {
            return $query->latest()->paginate($limit);
        }
        return $query->get();
    }
}
