<?php

namespace App\Services;

use App\Events\Tournament\TournamentCreated;
use App\Exceptions\BusinessLogicException;
use App\Models\Tournament;
use App\Repositories\TournamentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TournamentService
{
    /**
     * @param TournamentRepository $tournamentRepository
     */
    public function __construct
    (
        private TournamentRepository $tournamentRepository
    )
    {
    }

    /**
     * @param array $data
     * @param int $limit
     *
     * @return LengthAwarePaginator
     */
    public function paginateTournaments(array $data = [], int $limit = 10): LengthAwarePaginator
    {
        $tournaments = $this->tournamentRepository->paginateTournaments($limit, $data);

        return $tournaments;
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
        $tournament = $this->tournamentRepository->getById($tournamentId);

        return $tournament;
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
            throw new BusinessLogicException('Нельзя удалить завершенный турнир');
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
        $tournament = $this->tournamentRepository->getCurrentTournament($cityId);

        return $tournament;
    }

    /**
     * @param int $tournamentId
     * @param string $status
     *
     * @return Model|Tournament
     */
    public function updateTournamentStatus(int $tournamentId, string $status): Model|Tournament
    {
        $tournament = $this->tournamentRepository->getById($tournamentId);
        if (in_array($status, [Tournament::STATUS_NOT_STARTED, Tournament::STATUS_CURRENT])) {
            $tournament->update([
                'status' => $status,
            ]);
        }
        if ($tournament->status === Tournament::STATUS_ARCHIVED) {
            try {
                DB::beginTransaction();
                // TODO Добавить обработку матчей
                DB::commit();
            } catch (\Exception) {
                DB::rollBack();
            }
        }

        return $tournament;
    }
}
