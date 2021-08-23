<?php

namespace App\Services;

use App\Exceptions\BusinessLogicException;
use App\Models\InternalUser;
use App\Repositories\InternalUserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class InternalUserService
{
    /**
     * @param InternalUserRepository $internalUserRepository
     */
    public function __construct(
        private InternalUserRepository $internalUserRepository
    ) {}

    /**
     * @param string $login
     *
     * @return Model|null
     */
    public function getUserByLogin(string $login): ?Model
    {
        return $this->internalUserRepository->getByLogin($login);
    }

    /**
     * @param int $internalUserId
     * @param array $data
     *
     * @throws BusinessLogicException
     */
    public function updateInternalUser(int $internalUserId, array $data)
    {
        $internalUser = $this->internalUserRepository->getById($internalUserId);
        if (!$internalUser) {
            throw new BusinessLogicException();
        }
        if (isset($data['password']) && $data['password']) {
            $data['password'] = Hash::make($data['password']);
        }
        $internalUser->update($data);
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public function createInternalUser(array $data): Model
    {
        $data['password'] = Hash::make($data['password']);
        $internalUser = InternalUser::query()->create($data);

        return $internalUser;
    }

    /**
     * @param int $limit
     * @param array $data
     *
     * @return LengthAwarePaginator
     */
    public function paginateInternalUsers(int $limit = 10, array $data = []): LengthAwarePaginator
    {
        return $this->internalUserRepository->paginateInternalUsers($limit, $data);
    }

    /**
     * @param int $id
     *
     * @return Model|null
     */
    public function getUserById(int $id): ?Model
    {
        return $this->internalUserRepository->getById($id);
    }

    /**
     * @param int $internalUserId
     */
    public function removeInternalUser(int $internalUserId)
    {
        InternalUser::query()->where('id', $internalUserId)
            ->delete();
    }
}
