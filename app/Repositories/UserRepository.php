<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
            ->with('avatar', 'school')
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

    /**
     * @param array $data
     * @param int|null $limit
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getUsers(array $data, ?int $limit = null): Collection|LengthAwarePaginator
    {
        $query = User::query()
            ->when(isset($data['login']), fn (Builder $query) =>  $query->where('email', 'LIKE', '%' . $data['login'] . '%'))
            ->when(isset($data['types']), fn (Builder $query) =>  $query->whereIn('type', $data['types']))
            ->when(isset($data['statuses']), fn (Builder $query) =>  $query->whereIn('status', $data['statuses']))
            ->when(isset($data['created_at_start']), fn (Builder $query) =>  $query->whereDate('created_at', '>=', $data['created_at_start']))
            ->when(isset($data['created_at_end']), fn (Builder $query) =>  $query->where('created_at', '<=', $data['created_at_end']));;

        if ($limit) {
            return $query->latest()->paginate($limit);
        }
        return $query->get();
    }
}
