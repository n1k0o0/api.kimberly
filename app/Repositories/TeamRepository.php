<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;

class TeamRepository
{
    /**
     * @param int $teamId
     *
     * @return Model|Team|null
     */
    public function getById(int $teamId): Model|Team|null
    {
        return Team::query()
            ->with('division', 'league', 'color')
            ->find($teamId);
    }
}
