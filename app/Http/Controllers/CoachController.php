<?php

namespace App\Http\Controllers;

use App\Http\Requests\School\Coach\CreateCoachRequest;
use App\Http\Requests\School\Coach\UpdateCoachRequest;
use App\Http\Resources\Coach\CoachResource;
use App\Services\CoachService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CoachController extends ApiController
{
    public function __construct(private CoachService $coachService)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCoachRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateCoachRequest $request): JsonResponse
    {
        $team = $this->coachService->createCoach($request->validated());

        return $this->respondCreated(CoachResource::make($team));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCoachRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateCoachRequest $request, $id): JsonResponse
    {
        $coach = $this->coachService->updateCoach($id, $request->validated());

        return $this->respondSuccess(CoachResource::make($coach));
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
        $this->coachService->removeCoach($id);

        return $this->respondSuccess();
    }
}
