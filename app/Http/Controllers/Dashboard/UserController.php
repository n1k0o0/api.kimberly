<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Dashboard\User\GetUsersRequest;
use App\Http\Requests\Dashboard\User\UpdateUserRequest;
use App\Http\Resources\Dashboard\User\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends ApiController
{
    public function __construct(
        private UserService $userService
    )
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param GetUsersRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(GetUsersRequest $request): AnonymousResourceCollection
    {
        $users = $this->userService->getUsers($request->validated(), $request->input('limit'));

        return UserResource::collection($users);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->userService->getUserById($id);

        return $this->respondSuccess(UserResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     *
     * @return JsonResponse
     * @throws \App\Exceptions\BusinessLogicException
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->validated());

        return $this->respondSuccess(UserResource::make($user));
    }
}
