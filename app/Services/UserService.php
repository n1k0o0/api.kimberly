<?php

namespace App\Services;

use App\Exceptions\BusinessLogicException;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $email
     *
     * @return Model|null
     */
    public function getUserByEmail(string $email): ?Model
    {
        return $this->userRepository->getByEmail($email);
    }

    /**
     * @param int $id
     *
     * @return Model|null
     */
    public function getUserById(int $id): ?Model
    {
        return $this->userRepository->getById($id);
    }

    /**
     * @param array $data
     *
     * @return User
     */
    public function createUser(array $data): User
    {
        /** @var User $user */
        $user = User::query()->create($data);

        return $user;
    }

    /**
     * @param int $id
     * @param array $data
     *
     * @return Model
     * @throws BusinessLogicException
     */
    public function updateUser(int $id, array $data): Model
    {
        $user = $this->userRepository->getById($id);
        if (!$user) {
            throw new BusinessLogicException();
        }
        $user->update($data);

        return $user;
    }

    public function registerUser(array $data)
    {
        $user = $this->createUser($data);
    }
}
