<?php

namespace App\Http\Controllers\Dashboard;

use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Dashboard\InternalUser\CreateInternalUserRequest;
use App\Http\Requests\Dashboard\InternalUser\PaginateInternalUserRequest;
use App\Http\Requests\Dashboard\InternalUser\UpdateInternalUserRequest;
use App\Http\Resources\InternalUser\InternalUserResource;
use App\Services\InternalUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InternalUserController extends ApiController
{
    /**
     * @param InternalUserService $internalUserService
     */
    public function __construct(
        private InternalUserService $internalUserService
    ) {
    }

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
     * @return JsonResponse
     */
    public function getMe(): JsonResponse
    {
        return $this->respondSuccess(InternalUserResource::make(auth('internal-users')->user()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws BusinessLogicException
     */
    public function destroy(int $id): JsonResponse
    {
        $this->internalUserService->removeInternalUser($id);

        return $this->respondSuccess();
    }
}
