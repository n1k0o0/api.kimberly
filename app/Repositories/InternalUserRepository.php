<?php

namespace App\Repositories;

use App\Models\InternalUser;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
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

    /**
     * @param int $limit
     * @param array|null $data
     *
     * @return LengthAwarePaginator
     */
    public function paginateInternalUsers(int $limit=10, array $data=null): LengthAwarePaginator
    {
        $query = InternalUser::query()
            ->when(isset($data['login']), fn (Builder $query) =>  $query->where('login', 'LIKE', '%' . $data['login'] . '%'))
            ->when(isset($data['types']), fn (Builder $query) =>  $query->whereIn('type', $data['types']))
            ->when(isset($data['created_at_start']), fn (Builder $query) =>  $query->whereDate('created_at', '>=', $data['created_at_start']))
            ->when(isset($data['created_at_end']), fn (Builder $query) =>  $query->where('created_at', '<=', $data['created_at_end']));

        return $query->paginate($limit);
    }
}
