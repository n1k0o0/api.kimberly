<?php

namespace App\Http\Controllers\Dashboard;

use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Dashboard\Game\CreateGameRequest;
use App\Http\Requests\Dashboard\Game\GetGamesRequest;
use App\Http\Requests\Dashboard\Game\UpdateGameRequest;
use App\Http\Requests\Dashboard\Game\UpdateGameStatusRequest;
use App\Http\Resources\Dashboard\Game\GameResource;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GameController extends ApiController
{
    public function __construct(private GameService $gameService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param GetGamesRequest $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(GetGamesRequest $request): AnonymousResourceCollection
    {
        //Todo $request->all() change to$request->validated()
        $games = $this->gameService->getGames(
            $request->all(),
            $request->input('limit'),
        );

        return GameResource::collection($games);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateGameRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateGameRequest $request): JsonResponse
    {
        $game = $this->gameService->createGame($request->validated());

        return $this->respondCreated(GameResource::make($game));
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
        $game = $this->gameService->getGameById($id);

        return $this->respondSuccess(GameResource::make($game));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGameRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateGameRequest $request, int $id): JsonResponse
    {
        $game = $this->gameService->updateGame(
            $id,
            $request->validated()
        );

        return $this->respondSuccess(GameResource::make($game));
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
        $this->gameService->removeGame($id);

        return $this->respondSuccess();
    }

    public function updateStatus(UpdateGameStatusRequest $request, int $id): JsonResponse
    {
        $this->gameService->updateStatus($id, $request->input('status'));

        return $this->respondSuccess();
    }

    public function startPause(int $id)
    {
        $this->gameService->startGamePause($id);

        return $this->respondSuccess();
    }

    public function finishPause(int $id)
    {
        $this->gameService->finishGamePause($id);

        return $this->respondSuccess();
    }
}
