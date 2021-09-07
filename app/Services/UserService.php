<?php

namespace App\Services;

use App\Events\User\Registered;
use App\Exceptions\BusinessLogicException;
use App\Models\EmailVerification;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    /**
     * @param array $data
     *
     * @return User
     * @throws \Exception
     */
    public function registerUser(array $data): User
    {
        try {
            DB::beginTransaction();
            $user = $this->createUser($data);
            event(new Registered($user));
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            throw $exception;
        }

        return $user;
    }

    /**
     * @param string $email
     * @param string $code
     */
    public function confirmEmail(string $email, string $code)
    {
        /** @var EmailVerification $verification */
        $verification = EmailVerification::query()
            ->where('email', $email)
            ->whereNotNull('sent_at')
            ->whereNull('verified_at')
            ->orderBy('sent_at', 'desc')
            ->first();

        if ($verification && $verification->verification_code === $code) {
            $verification->markAsVerified();

            /** @var User $user */
            $user = $verification->user;
            $user->markEmailAsVerified();

            if ($user->email !== $verification->email) {
                $user->email = $verification->email;
            }

            if ($user->status === User::STATUS_EMAIL_VERIFICATION) {
                $user->status = User::STATUS_NOT_APPROVED;
            }

            if ($user->isDirty()) {
                $user->save();
            }
        }
    }
}
