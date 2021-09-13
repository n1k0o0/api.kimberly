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
            ->when(isset($data['login']), fn (Builder $query) =>  $query->where('email', 'LIKE', '%' . $data['login'] . '%'))
            ->when(isset($data['types']), fn (Builder $query) =>  $query->whereIn('type', $data['types']))
            ->when(isset($data['statuses']), fn (Builder $query) =>  $query->whereIn('status', $data['statuses']))
            ->when(isset($data['created_at_start']), fn (Builder $query) =>  $query->whereDate('created_at', '>=', $data['created_at_start']))
            ->when(isset($data['created_at_end']), fn (Builder $query) =>  $query->where('created_at', '<=', $data['created_at_end']));;

        if ($limit) {
            return $query->latest()->paginate($limit);
        }
        return $query->get();
    }
}
