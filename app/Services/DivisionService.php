<?php

namespace App\Services;

use App\Models\Division;
use App\Repositories\DivisionRepository;
use Illuminate\Database\Eloquent\Model;

class DivisionService
{
    /**
     * @param DivisionRepository $divisionRepository
     */
    public function __construct(
        private DivisionRepository $divisionRepository
    ) { }

    /**
     * @param array $data
     *
     * @return Division|Model
     */
    public function createDivision(array $data): Division|Model
    {
        $division = Division::query()->create($data);

        return $division;
    }

    /**
     * @param int $divisionId
     * @param array $data
     *
     * @return Division|Model|null
     */
    public function updateDivision(int $divisionId, array $data): Model|Division|null
    {
        $division = $this->divisionRepository->getById($divisionId);
        $division->update($data);

        return $division;
    }

    /**
     * @param int $divisionId
     *
     * @return int
     */
    public function removeDivision(int $divisionId): int
    {
        return Division::query()->where('id', $divisionId)->delete();
    }
}
