<?php

namespace App\Http\Controllers;

use App\Http\Requests\InternalUser\CreateInternalUserRequest;
use App\Http\Requests\InternalUser\LoginInternalUserRequest;
use App\Http\Requests\InternalUser\UpdateInternalUserRequest;
use App\Http\Resources\InternalUser\InternalUserResource;
use App\Models\InternalUser;
use App\Services\InternalUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class InternalUserController extends ApiController
{
    private InternalUserService $internalUserService;

    public function __construct(InternalUserService $internalUserService)
    {
        $this->internalUserService = $internalUserService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateInternalUserRequest $request
     * @param int $id
     *
     * @return JsonResponse
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
        return $this->respondSuccess(InternalUserResource::make(auth('users')->user()));
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
}
