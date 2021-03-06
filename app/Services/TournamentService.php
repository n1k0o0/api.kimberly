<?php

namespace App\Services;

use App\Events\Tournament\TournamentCreated;
use App\Exceptions\BusinessLogicException;
use App\Models\Game;
use App\Models\Tournament;
use App\Repositories\TournamentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TournamentService
{
    /**
     * @param TournamentRepository $tournamentRepository
     */
    public function __construct
    (
        private TournamentRepository $tournamentRepository
    ) {
    }

    /**
     * @param array $data
     * @param int|null $limit
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getTournaments(array $data = [], int $limit = null): Collection|LengthAwarePaginator
    {
        return $this->tournamentRepository->getTournaments($data, $limit);
    }

    /**
     * @param array $data
     *
     * @return Tournament|Model
     */
    public function createTournament(array $data): Tournament|Model
    {
        $data['status'] = Tournament::STATUS_NOT_STARTED;
        /** @var Tournament $tournament */
        $tournament = Tournament::query()->create($data);
        event(new TournamentCreated($tournament));

        return $tournament;
    }

    /**
     * @param int $tournamentId
     *
     * @return Model|Tournament|null
     */
    public function getTournamentById(int $tournamentId): Model|Tournament|null
    {
        return $this->tournamentRepository->getById($tournamentId);
    }

    /**
     * @param int $tournamentId
     * @param array $data
     *
     * @return Model|Tournament|null
     */
    public function updateTournament(int $tournamentId, array $data): Model|Tournament|null
    {
        $tournament = Tournament::query()
            ->where('status', '<>', Tournament::STATUS_ARCHIVED)
            ->findOrFail($tournamentId);
        $tournament->update($data);

        return $tournament;
    }

    /**
     * @param int $tournamentId
     *
     * @return mixed
     * @throws BusinessLogicException
     */
    public function removeTournament(int $tournamentId): mixed
    {
        // TODO check games not exists
        $tournament = $this->tournamentRepository->getById($tournamentId);
        if ($tournament->status === Tournament::STATUS_ARCHIVED) {
            throw new BusinessLogicException('???????????? ?????????????? ?????????????????????? ????????????');
        }

        return $tournament->delete();
    }

    /**
     * @param int $cityId
     *
     * @return Model|Tournament
     */
    public function getCurrentTournament(int $cityId): Model|Tournament
    {
        return $this->tournamentRepository->getCurrentTournament($cityId);
    }

    /**
     * @param int $tournamentId
     * @param string $status
     *
     * @return Model|Tournament
     * @throws BusinessLogicException
     */
    public function setStatus(int $tournamentId, string $status): Model|Tournament
    {
        $tournament = $this->tournamentRepository->getById($tournamentId);
        if ($tournament->status === Tournament::STATUS_ARCHIVED) {
            throw new BusinessLogicException('???????????? ???? ?????????? ???????? ??????????????');
        }
        if (in_array($status, [Tournament::STATUS_NOT_STARTED, Tournament::STATUS_CURRENT], true)) {
            $tournament->update([
                'status' => $status,
            ]);
            return $tournament;
        }
        if ($status === Tournament::STATUS_ARCHIVED) {
            if (Game::query()->where('tournament_id', $tournamentId)->where(
                'status',
                '<>',
                Game::STATUS_FINISHED
            )->first()) {
                throw new BusinessLogicException('????????????. ?????? ?????????????? ???????? ???? ?????????????????????? ??????????');
            }
            $tournament->update([
                'status' => $status,
            ]);
        }

        return $tournament;
    }
}
