<?php

namespace App\Services;

use App\Exceptions\BusinessLogicException;
use App\Models\InternalUser;
use App\Repositories\InternalUserRepository;
use Illuminate\Database\Eloquent\Model;

class InternalUserService
{
    private InternalUserRepository $internalUserRepository;

    public function __construct(InternalUserRepository $internalUserRepository)
    {
        $this->internalUserRepository = $internalUserRepository;
    }

    public function getUserByLogin(string $login): ?Model
    {
        return $this->internalUserRepository->getByLogin($login);
    }

    public function updateInternalUser(int $internalUserId, array $data)
    {
        $internalUser = $this->internalUserRepository->getById($internalUserId);
        if ($internalUser) {
            throw new BusinessLogicException();
        }

        $internalUser->update($data);
    }

    public function createInternalUser(array $data)
    {
        $internalUser = InternalUser::query()->create($data);

        return $internalUser;
    }
}
