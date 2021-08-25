<?php

namespace App\Repositories;

use App\Models\Division;
use Illuminate\Database\Eloquent\Model;

class DivisionRepository
{
    /**
     * @param int $divisionId
     *
     * @return Division|Model|null
     */
    public function getById(int $divisionId): Division|Model|null
    {
        $division = Division::query()->find($divisionId);

        return $division;
    }
}
