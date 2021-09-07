<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\InternalUser\LoginInternalUserRequest;
use App\Models\InternalUser;
use App\Services\InternalUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthInternalUserController extends ApiController
{
    /**
     * @param InternalUserService $internalUserService
     */
    public function __construct(
        private InternalUserService $internalUserService
    ) {}

    /**
     * @param LoginInternalUserRequest $request
     *
     * @return JsonResponse
     */
    public function issueToken(LoginInternalUserRequest $request): JsonResponse
    {
        /** @var InternalUser $internalUser */
        $internalUser = $this->internalUserService->getUserByLogin($request->login);
        if (!$internalUser || !Hash::check($request->input('password'), $internalUser->password)) {
            return $this->respondUnauthorized();
        }
        $token = auth('internal-users')->login($internalUser);

        return $this->respondWithToken($token);
    }

    /**
     * @return JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        $token = auth('internal-users')->refresh();

        return $this->respondWithToken($token);
    }

    /**
     * @return JsonResponse
     */
    public function revokeToken(): JsonResponse
    {
        auth('internal-users')->logout();

        return $this->respondSuccess();
    }
}
