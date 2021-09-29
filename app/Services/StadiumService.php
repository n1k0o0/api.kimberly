<?php

namespace App\Services;

use App\Models\Stadium;
use App\Repositories\StadiumRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
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
     * @param int|null $limit
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getStadiums(array $data=[], int $limit=null): Collection|LengthAwarePaginator
    {
        return $this->stadiumRepository->getStadiums( $data,$limit);
    }

    /**
     * @param array $data
     *
     * @return Stadium|Model
     */
    public function createStadium(array $data): Stadium|Model
    {
        return Stadium::query()->create($data);
    }

    /**
     * @param int $stadiumId
     *
     * @return Stadium|Model|null
     */
    public function getStadiumById(int $stadiumId): Model|Stadium|null
    {
        return $this->stadiumRepository->getById($stadiumId);
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
