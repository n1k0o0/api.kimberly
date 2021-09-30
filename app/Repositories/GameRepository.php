<?php

namespace App\Repositories;

use App\Models\Game;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GameRepository
{
    /**
     * @param int $gameId
     *
     * @return Game
     */
    public function getGameById(int $gameId): Game
    {
        /** @var Game $game */
        $game = Game::query()
            ->with(['firstTeam', 'secondTeam', 'division', 'league', 'tournament', 'stadium', 'pauses'])
            ->findOrFail($gameId);

        return $game;
    }

    /**
     * @param array $data
     * @param int|null $limit
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getGames(array $data = [], int $limit = null): Collection|LengthAwarePaginator
    {
        $query = Game::query()
            ->when(isset($data['divisions']), fn(Builder $query) => $query->whereIn('division_id', $data['divisions']))
            ->when(isset($data['leagues']), fn(Builder $query) => $query->whereHas(
                'division.league',
                fn(Builder $builder) => $builder->whereIn('divisions.league_id', $data['leagues'])
            ))
            ->when(isset($data['city_id']), fn(Builder $query) => $query->whereHas(
                'stadium',
                fn(Builder $builder) => $builder->where('stadiums.city_id', $data['city_id'])
            ))
            ->when(isset($data['stadiums']), fn(Builder $query) => $query->whereIn('stadium_id', $data['stadiums']))
            ->when(
                isset($data['tournaments']),
                fn(Builder $query) => $query->whereIn('tournament_id', $data['tournaments'])
            )
            ->when(isset($data['teams']), fn(Builder $query) => $query->where(function ($query) use ($data) {
                $query->whereIn('team_1_id', $data['teams'])->orWhereIn('team_2_id', $data['teams']);
            }))
            ->with('firstTeam', 'secondTeam', 'division', 'stadium', 'tournament', 'league',);
        if ($limit) {
            return $query->latest()->paginate($limit);
        }
        return $query->get();
    }
}
