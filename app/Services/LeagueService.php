<?php

namespace App\Services;

use App\Models\Division;
use App\Models\League;
use App\Repositories\LeagueRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
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
     * @param int|null $limit
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getLeagues(array $data = [], int $limit = null): Collection|LengthAwarePaginator
    {
        $leagues = $this->leagueRepository->getLeagues($data, $limit);

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
        if (isset($data['divisions'])) {
            $divisions = $league->divisions()->createMany($data['divisions']);
        }

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
