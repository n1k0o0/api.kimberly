<?php

namespace App\Services;

use App\Exceptions\BusinessLogicException;
use App\Models\Game;
use App\Models\GamePause;
use App\Repositories\GameRepository;
use App\Repositories\TeamRepository;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GameService
{
    /**
     * @param GameRepository $gameRepository
     * @param TeamRepository $teamRepository
     */
    public function __construct(
        private GameRepository $gameRepository,
        private TeamRepository $teamRepository,
    ) {
    }

    /**
     * @param array $data
     * @param int|null $limit
     *
     * @return LengthAwarePaginator|Collection
     */
    public function getGames(array $data = [], int $limit = null): Collection|LengthAwarePaginator
    {
        return $this->gameRepository->getGames($data, $limit);
    }

    /**
     * @param array $data
     *
     * @return Game
     * @throws BusinessLogicException
     */
    public function createGame(array $data): Game
    {
        $firstTeam = $this->teamRepository->getTeamById($data['team_1_id']);
        $secondTeam = $this->teamRepository->getTeamById($data['team_2_id']);
        if ($firstTeam->division_id !== $data['division_id']) {
            throw new BusinessLogicException('Первая команда не принадлежит указанному дивизиону');
        }
        if ($secondTeam->division_id !== $data['division_id']) {
            throw new BusinessLogicException('Вторая команда не принадлежит указанному дивизиону');
        }
        try {
            DB::beginTransaction();
            /** @var Game $game */
            $game = Game::query()->create($data);
            DB::commit();
        } catch (Exception) {
            DB::rollback();
        }

        return $game;
    }

    /**
     * @param array $data
     *
     * @return bool
     * @throws Exception
     */
    public function createGames(array $data): bool
    {
        try {
            DB::beginTransaction();
            $games = Game::query()->insert($data);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }

        return $games;
    }

    /**
     * @param int $gameId
     *
     * @return Game
     */
    public function getGameById(int $gameId): Game
    {
        return $this->gameRepository->getGameById($gameId);
    }

    /**
     * @param int $gameId
     * @param array $data
     *
     * @return Game
     */
    public function updateGame(int $gameId, array $data): Game
    {
        /** @var Game $game */
        $game = Game::query()->findOrFail($gameId);
        try {
            DB::beginTransaction();
            $game->update($data);
            DB::commit();
        } catch (Exception) {
            DB::rollback();
        }

        return $game;
    }

    /**
     * @param int $gameId
     *
     * @throws BusinessLogicException
     */
    public function removeGame(int $gameId): void
    {
        /** @var Game $game */
        $game = Game::query()->findOrFail($gameId);

        if ($game->status !== Game::STATUS_NOT_STARTED) {
            throw new BusinessLogicException('Удаление матча невозможно');
        }
        $status = $game->delete();
    }

    /**
     * @param int $gameId
     *
     * @return GamePause
     * @throws BusinessLogicException
     */
    public function startGamePause(int $gameId): GamePause
    {
        $game = Game::query()->findOrFail($gameId);
        if (!$game->is_active) {
            throw new BusinessLogicException('Уже есть активная пауза');
        }
    }

    /**
     * @param int $gameId
     *
     * @return GamePause
     * @throws BusinessLogicException
     */
    public function finishGamePause(int $gameId): GamePause
    {
        $game = Game::query()->findOrFail($gameId);
        if ($game->is_active) {
            throw new BusinessLogicException('Пауза не была начата');
        }
    }

    /**
     * @param int $gameId
     * @param CarbonImmutable $startedAt
     * @param CarbonImmutable $finishedAt
     *
     * @return GamePause
     */
    public function createGamePause(int $gameId, CarbonImmutable $startedAt, CarbonImmutable $finishedAt): GamePause
    {
        $game = Game::query()->findOrFail($gameId);
        /** @var GamePause $gamePause */
        $gamePause = GamePause::query()->create([
            'game_id' => $gameId,
            'started_at' => $startedAt,
            'finished_at' => $finishedAt,
        ]);

        return $gamePause;
    }

    public function updateStatus(int $gameId, string $status)
    {
        $game = Game::query()->findOrFail($gameId);
    }
}
