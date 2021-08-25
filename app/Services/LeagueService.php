<?php

namespace App\Services;

use App\Models\Division;
use App\Models\League;
use App\Repositories\LeagueRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class LeagueService
{
    /**
     * @param LeagueRepository $leagueRepository
     */
    public function __construct
    (
        private LeagueRepository $leagueRepository
    )
    {
    }

    /**
     * @param array $data
     * @param int $limit
     *
     * @return LengthAwarePaginator
     */
    public function paginateLeagues(array $data = [], int $limit = 10): LengthAwarePaginator
    {
        $leagues = $this->leagueRepository->paginateStadiums($limit, $data);

        return $leagues;
    }

    /**
     * @param array $data
     *
     * @return League|Model
     */
    public function createLeague(array $data): League|Model
    {
        /** @var League $league */
        $league = League::query()->create($data);
        $divisions = $league->divisions()->createMany($data['divisions']);

        return $league;
    }

    /**
     * @param int $leagueId
     *
     * @return Model|League|null
     */
    public function getLeagueById(int $leagueId): Model|League|null
    {
        $league = $this->leagueRepository->getById($leagueId);

        return $league;
    }

    /**
     * @param int $leagueId
     * @param array $data
     *
     * @return Model|League|null
     */
    public function updateLeague(int $leagueId, array $data): Model|League|null
    {
        $league = $this->leagueRepository->getById($leagueId);
        $league->update($data);

        return $league;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function removeLeague(int $id): mixed
    {
        return League::query()->where('id')->delete();
    }
}
