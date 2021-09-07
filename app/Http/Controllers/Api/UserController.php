<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\User\ConfirmEmailRequest;
use App\Http\Requests\Api\User\LoginUserRequest;
use App\Http\Requests\Api\User\RegisterUserRequest;
use App\Http\Requests\Api\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends ApiController
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     *
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $this->userService->updateUser(
            auth('users')->id(),
            $request->validated()
        );

        return $this->respondSuccess();
    }

    /**
     * @param LoginUserRequest $request
     *
     * @return JsonResponse
     */
    public function issueToken(LoginUserRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (! $token = auth('users')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function refreshToken(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * @return JsonResponse
     */
    public function revokeToken(): JsonResponse
    {
        auth()->logout();

        return $this->respondSuccess();
    }

    /**
     * @param RegisterUserRequest $request
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $this->userService->registerUser($request->validated());

        return $this->respondCreated();
    }

    /**
     * @return JsonResponse
     */
    public function getMe(): JsonResponse
    {
        return $this->respondSuccess(UserResource::make(auth('users')->user()));
    }

    /**
     * @param ConfirmEmailRequest $request
     *
     * @return JsonResponse
     */
    public function confirmEmail(ConfirmEmailRequest $request): JsonResponse
    {
        $this->userService->confirmEmail($request->input('email'), $request->input('code'));

        return $this->respondSuccess();
    }
}
