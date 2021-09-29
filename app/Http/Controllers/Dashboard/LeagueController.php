<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Dashboard\League\CreateLeagueRequest;
use App\Http\Requests\Dashboard\League\GetLeaguesRequest;
use App\Http\Requests\Dashboard\League\UpdateLeagueRequest;
use App\Http\Resources\League\LeagueResource;
use App\Services\LeagueService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LeagueController extends ApiController
{
    public function __construct
    (
        private LeagueService $leagueService
    )
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param GetLeaguesRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(GetLeaguesRequest $request): AnonymousResourceCollection
    {
        $leagues = $this->leagueService->getLeagues(
            $request->validated(),
            $request->input('limit'),
        );

        return LeagueResource::collection($leagues);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateLeagueRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateLeagueRequest $request): JsonResponse
    {
        $league = $this->leagueService->createLeague($request->validated());

        return $this->respondCreated(LeagueResource::make($league));
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
        $league = $this->leagueService->getLeagueById($id);

        return $this->respondSuccess(LeagueResource::make($league));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLeagueRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateLeagueRequest $request, int $id): JsonResponse
    {
        $league = $this->leagueService->updateLeague($id, $request->validated());

        return $this->respondSuccess(LeagueResource::make($league));
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
        $this->leagueService->removeLeague($id);

        return $this->respondSuccess();
    }
}
