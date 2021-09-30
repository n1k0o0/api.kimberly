<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Dashboard\School\Team\CreateTeamRequest;
use App\Http\Requests\Dashboard\School\Team\GetTeamsRequest;
use App\Http\Requests\Dashboard\School\Team\UpdateTeamRequest;
use App\Http\Resources\Dashboard\Team\TeamResource;
use App\Services\TeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TeamController extends ApiController
{
    public function __construct(private TeamService $teamService)
    {
    }

    public function index(GetTeamsRequest $request): AnonymousResourceCollection
    {
        $teams = $this->teamService->getTeams(
            $request->validated(),
            $request->input('limit'),
        );

        return TeamResource::collection($teams);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateTeamRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateTeamRequest $request): JsonResponse
    {
        $team = $this->teamService->createTeam($request->validated());

        return $this->respondCreated(TeamResource::make($team));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTeamRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateTeamRequest $request, $id): JsonResponse
    {
        $team = $this->teamService->updateTeam($id, $request->validated());

        return $this->respondSuccess(TeamResource::make($team));
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
        $this->teamService->removeTeam($id);

        return $this->respondSuccess();
    }
}
