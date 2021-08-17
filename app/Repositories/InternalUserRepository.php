<?php

namespace App\Repositories;

use App\Models\InternalUser;
use Illuminate\Database\Eloquent\Model;

class InternalUserRepository
{
    /**
     * @param string $login
     *
     * @return Model|null
     */
    public function getByLogin(string $login): ?Model
    {
        return InternalUser::query()->where('login', $login)->first();
    }

    /**
     * @param int $internalUserId
     *
     * @return Model|null
     */
    public function getById(int $internalUserId): ?Model
    {
        return InternalUser::query()->find($internalUserId);
    }
}
