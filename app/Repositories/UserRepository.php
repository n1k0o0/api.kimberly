<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository
{
    /**
     * @param int $userId
     *
     * @return Model|null
     */
    public function getById(int $userId): ?Model
    {
        return User::query()
            ->with('school')
            ->find($userId);
    }

    /**
     * @param string $email
     *
     * @return Model|null
     */
    public function getByEmail(string $email): ?Model
    {
        return User::query()->where('email', $email)->first();
    }
}
