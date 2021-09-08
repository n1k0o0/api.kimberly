<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Dashboard\InternalUser\LoginInternalUserRequest;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\InternalUser\InternalUserResource;
use App\Models\InternalUser;
use App\Services\CountryService;
use App\Services\InternalUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthInternalUserController extends ApiController
{
    /**
     * @param InternalUserService $internalUserService
     */
    public function __construct(
        private InternalUserService $internalUserService,
        private CountryService $countryService
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

    /**
     * @return JsonResponse
     */
    public function getMe(): JsonResponse
    {
        $user = $this->internalUserService->getUserById(auth('internal-users')->id());
        $countries = $this->countryService->getCountries();

        return $this->respondSuccess([
            "user" => InternalUserResource::make($user),
            'countries' => CountryResource::collection($countries),
        ]);
    }
}
