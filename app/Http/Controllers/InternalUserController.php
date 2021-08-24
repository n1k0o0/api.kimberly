<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessLogicException;
use App\Http\Requests\InternalUser\CreateInternalUserRequest;
use App\Http\Requests\InternalUser\LoginInternalUserRequest;
use App\Http\Requests\InternalUser\PaginateInternalUserRequest;
use App\Http\Requests\InternalUser\UpdateInternalUserRequest;
use App\Http\Resources\InternalUser\InternalUserResource;
use App\Models\InternalUser;
use App\Services\InternalUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Hash;

class InternalUserController extends ApiController
{
    public function __construct(
        private InternalUserService $internalUserService
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @param PaginateInternalUserRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(PaginateInternalUserRequest $request): AnonymousResourceCollection
    {
        $internalUsers = $this->internalUserService->paginateInternalUsers(
            $request->input('limit'),
            $request->validated()
        );

        return InternalUserResource::collection($internalUsers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateInternalUserRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateInternalUserRequest $request): JsonResponse
    {
        $internalUser = $this->internalUserService->createInternalUser($request->validated());

        return $this->respondCreated(InternalUserResource::make($internalUser));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $internalUser = $this->internalUserService->getUserById($id);

        return $this->respondSuccess(InternalUserResource::make($internalUser));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInternalUserRequest $request
     * @param int $id
     *
     * @return JsonResponse
     * @throws BusinessLogicException
     */
    public function update(UpdateInternalUserRequest $request, $id): JsonResponse
    {
        $this->internalUserService->updateInternalUser($id, $request->validated());

        return $this->respondSuccess();
    }

    /**
     * @param LoginInternalUserRequest $request
     *
     * @return JsonResponse
     */
    public function createToken(LoginInternalUserRequest $request): JsonResponse
    {
        /** @var InternalUser $internalUser */
        $internalUser = $this->internalUserService->getUserByLogin($request->input('login'));
        if (!$internalUser || !Hash::check($request->input('password'), $internalUser->password)) {
            return $this->respondUnauthorized();
        }
        $tokenKey = $request->input('token_key') ?? 'device';
        $token = $internalUser->createToken($tokenKey)->plainTextToken;

        return $this->respondSuccess(['token' => $token, 'user_id' => $internalUser->id, 'token_key' => $tokenKey]);
    }

    /**
     * @return JsonResponse
     */
    public function getMe(): JsonResponse
    {
        return $this->respondSuccess(InternalUserResource::make(auth('internal-users')->user()));
    }

    /**
     * @return JsonResponse
     */
    public function revokeToken(): JsonResponse
    {
        /** @var InternalUser $internalUser */
        $internalUser = auth('internal-users')->user();
        $internalUser->tokens()->delete();

        return $this->respondSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->internalUserService->removeInternalUser($id);

        return $this->respondSuccess();
    }
}
