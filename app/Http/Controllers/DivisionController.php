<?php

namespace App\Http\Controllers;

use App\Http\Requests\Division\CreateDivisionRequest;
use App\Http\Requests\Division\UpdateDivisionRequest;
use App\Http\Resources\Division\DivisionResource;
use App\Services\DivisionService;
use Illuminate\Http\JsonResponse;

class DivisionController extends ApiController
{
    public function __construct(private DivisionService $divisionService)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateDivisionRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateDivisionRequest $request): JsonResponse
    {
        $division = $this->divisionService->createDivision($request->validated());

        return $this->respondCreated(DivisionResource::make($division));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateDivisionRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateDivisionRequest $request, int $id): JsonResponse
    {
        $division = $this->divisionService->updateDivision($id, $request->validated());

        return $this->respondSuccess(DivisionResource::make($division));
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
        $this->divisionService->removeDivision($id);

        return $this->respondSuccess();
    }
}
