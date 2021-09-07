<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Stadium\CreateStadiumRequest;
use App\Http\Requests\Stadium\PaginateStadiumRequest;
use App\Http\Requests\Stadium\UpdateStadiumRequest;
use App\Http\Resources\Stadium\StadiumResource;
use App\Services\StadiumService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StadiumController extends ApiController
{
    public function __construct(
        private StadiumService $stadiumService
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @param PaginateStadiumRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(PaginateStadiumRequest $request): AnonymousResourceCollection
    {
        $stadiums = $this->stadiumService->paginateStadiums(
            $request->validated(),
            $request->input('limit'),
        );

        return StadiumResource::collection($stadiums);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateStadiumRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateStadiumRequest $request): JsonResponse
    {
        $stadium = $this->stadiumService->createStadium($request->validated());

        return $this->respondCreated(StadiumResource::make($stadium));
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
        $stadium = $this->stadiumService->getStadiumById($id);

        return $this->respondSuccess(StadiumResource::make($stadium));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateStadiumRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateStadiumRequest $request, int $id): JsonResponse
    {
        $stadium = $this->stadiumService->updateStadium($id, $request->validated());

        return $this->respondSuccess(StadiumResource::make($stadium));
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
        $this->stadiumService->removeStadium($id);

        return $this->respondSuccess();
    }
}
