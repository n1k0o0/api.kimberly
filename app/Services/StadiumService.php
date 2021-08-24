<?php

namespace App\Services;

use App\Models\Stadium;
use App\Repositories\StadiumRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class StadiumService
{
    /**
     * @param StadiumRepository $stadiumRepository
     */
    public function __construct(
        private StadiumRepository $stadiumRepository
    ) { }

    /**
     * @param array $data
     * @param int $limit
     *
     * @return LengthAwarePaginator
     */
    public function paginateStadiums(array $data=[], int $limit=10): LengthAwarePaginator
    {
        $stadiums = $this->stadiumRepository->paginateStadiums($limit, $data);

        return $stadiums;
    }

    /**
     * @param array $data
     *
     * @return Stadium|Model
     */
    public function createStadium(array $data): Stadium|Model
    {
        $stadium = Stadium::query()->create($data);

        return $stadium;
    }

    /**
     * @param int $stadiumId
     *
     * @return Stadium|Model|null
     */
    public function getStadiumById(int $stadiumId): Model|Stadium|null
    {
        $stadium = $this->stadiumRepository->getById($stadiumId);

        return $stadium;
    }

    /**
     * @param int $stadiumId
     * @param array $data
     *
     * @return Stadium|Model|null
     */
    public function updateStadium(int $stadiumId, array $data): Model|Stadium|null
    {
        $stadium = $this->stadiumRepository->getById($stadiumId);
        $stadium->update($data);

        return $stadium;
    }

    /**
     * @param int $stadiumId
     *
     * @return int
     */
    public function removeStadium(int $stadiumId): int
    {
        return Stadium::query()->where('id', $stadiumId)->delete();
    }
}
