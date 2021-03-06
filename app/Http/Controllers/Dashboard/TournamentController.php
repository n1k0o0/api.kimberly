<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Dashboard\Tournament\CreateTournamentRequest;
use App\Http\Requests\Dashboard\Tournament\GetCurrentTournamentRequest;
use App\Http\Requests\Dashboard\Tournament\GetTournamentsRequest;
use App\Http\Requests\Dashboard\Tournament\PaginateTournamentRequest;
use App\Http\Requests\Dashboard\Tournament\UpdateTournamentRequest;
use App\Http\Requests\Dashboard\Tournament\UpdateTournamentStatusRequest;
use App\Http\Resources\Tournament\TournamentResource;
use App\Services\TournamentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TournamentController extends ApiController
{
    /**
     * @param TournamentService $tournamentService
     */
    public function __construct(private TournamentService $tournamentService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param GetTournamentsRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(GetTournamentsRequest $request): AnonymousResourceCollection
    {
        $tournaments = $this->tournamentService->getTournaments(
            $request->validated(),
            $request->input('limit')
        );
        return TournamentResource::collection($tournaments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateTournamentRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateTournamentRequest $request): JsonResponse
    {
        $tournament = $this->tournamentService->createTournament($request->validated());

        return $this->respondCreated($tournament);
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
        $tournament = $this->tournamentService->getTournamentById($id);

        return $this->respondSuccess(TournamentResource::make($tournament));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTournamentRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateTournamentRequest $request, int $id): JsonResponse
    {
        $tournament = $this->tournamentService->updateTournament($id, $request->validated());

        return $this->respondSuccess(TournamentResource::make($tournament));
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
        $this->tournamentService->removeTournament($id);

        return $this->respondSuccess();
    }

    /**
     * @param GetCurrentTournamentRequest $request
     *
     * @return JsonResponse
     */
    public function getCurrent(GetCurrentTournamentRequest $request): JsonResponse
    {
        $tournament = $this->tournamentService->getCurrentTournament($request->input('city_id'));

        return $this->respondSuccess(TournamentResource::make($tournament));
    }

    /**
     * @param UpdateTournamentStatusRequest $request
     *
     * @return JsonResponse
     */
    public function setStatus(UpdateTournamentStatusRequest $request): JsonResponse
    {
        $tournament = $this->tournamentService->setStatus(
            $request->input('id'),
            $request->input('status'),
        );

        return $this->respondSuccess(TournamentResource::make($tournament));
    }
}
