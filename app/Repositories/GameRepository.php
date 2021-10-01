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
            ->when(isset($data['division_id']), fn(Builder $query) => $query->where('division_id', $data['division_id'])
            )
            ->when(
                isset($data['division_ids']),
                fn(Builder $query) => $query->whereIn('division_id', $data['division_ids'])
            )
            ->when(isset($data['league_id']), fn(Builder $query) => $query->whereHas(
                'division.league',
                fn(Builder $builder) => $builder->where('divisions.league_id', $data['league_id'])
            ))
            ->when(isset($data['league_ids']), fn(Builder $query) => $query->whereHas(
                'division.league',
                fn(Builder $builder) => $builder->whereIn('divisions.league_id', $data['league_ids'])
            ))
            ->when(isset($data['city_id']), fn(Builder $query) => $query->whereHas(
                'stadium',
                fn(Builder $builder) => $builder->where('stadiums.city_id', $data['city_id'])
            ))
            ->when(isset($data['city_ids']), fn(Builder $query) => $query->whereHas(
                'stadium',
                fn(Builder $builder) => $builder->whereIn('stadiums.city_id', $data['city_ids'])
            ))
            ->when(isset($data['stadium_id']), fn(Builder $query) => $query->where('stadium_id', $data['stadium_id']))
            ->when(
                isset($data['stadium_ids']),
                fn(Builder $query) => $query->whereIn('stadium_id', $data['stadium_ids'])
            )
            ->when(
                isset($data['tournament_id']),
                fn(Builder $query) => $query->where('tournament_id', $data['tournament_id'])
            )
            ->when(
                isset($data['tournament_ids']),
                fn(Builder $query) => $query->whereIn('tournament_id', $data['tournament_ids'])
            )
            ->when(isset($data['team_id']), fn(Builder $query) => $query->where(function ($query) use ($data) {
                $query->where('team_1_id', $data['team_id'])->orWhere('team_2_id', $data['team_id']);
            }))
            ->when(isset($data['team_ids']), fn(Builder $query) => $query->where(function ($query) use ($data) {
                $query->whereIn('team_1_id', $data['team_ids'])->orWhereIn('team_2_id', $data['team_ids']);
            }))
            ->with('firstTeam', 'secondTeam', 'division', 'stadium', 'tournament', 'league',);
        if ($limit) {
            return $query->latest()->paginate($limit);
        }
        return $query->get();
    }
}
