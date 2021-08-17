<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\GetUsersRequest;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends ApiController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(GetUsersRequest $request): JsonResponse
    {
        $users = $this->userService->getUsers($request->validated());

        return $this->respondSuccess(UserResource::collection($users));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $user = $this->userService->getUserById($id);

        return $this->respondSuccess(UserResource::make($user));
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
     * @param RegisterUserRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $this->userService->registerUser($request->validated());

        return $this->respondCreated();
    }

    /**
     * @param LoginUserRequest $request
     *
     * @return JsonResponse
     */
    public function issueToken(LoginUserRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->userService->getUserByEmail($request->email);
        if (!$user || Hash::check($request->input('password'), $user->password)) {
            return $this->respondUnauthorized();
        }
        $tokenKey = $request->input('token_key') ?? 'device';
        $token = $user->createToken($tokenKey)->plainTextToken;

        return $this->respondSuccess(['token' => $token, 'user_id' => $user->id, 'token_key' => $tokenKey]);
    }

    /**
     * @return JsonResponse
     */
    public function getMe(): JsonResponse
    {
        return $this->respondSuccess(UserResource::make(auth('users')->user()));
    }

    /**
     * @return JsonResponse
     */
    public function revokeToken(): JsonResponse
    {
        /** @var User $user */
        $user = auth('users')->user();
        $user->tokens()->delete();

        return $this->respondSuccess();
    }

    public function confirmEmail()
    {

    }
}
