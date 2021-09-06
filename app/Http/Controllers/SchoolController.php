<?php

namespace App\Http\Controllers;

use App\Http\Requests\School\CreateSchoolRequest;
use App\Http\Requests\School\PaginateSchoolsRequest;
use App\Http\Requests\School\UpdateSchoolRequest;
use App\Http\Requests\School\UpdateSchoolStatusRequest;
use App\Http\Resources\School\SchoolResource;
use App\Http\Resources\School\SchoolResourceCollection;
use App\Services\SchoolService;
use Illuminate\Http\JsonResponse;

class SchoolController extends ApiController
{
    /**
     * @param SchoolService $schoolService
     */
    public function __construct(private SchoolService $schoolService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param PaginateSchoolsRequest $request
     *
     * @return SchoolResourceCollection
     */
    public function index(PaginateSchoolsRequest $request): SchoolResourceCollection
    {
        $schools = $this->schoolService->getSchools(
            $request->validated(),
            $request->input('limit'),
        );

        return SchoolResourceCollection::make($schools);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateSchoolRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateSchoolRequest $request): JsonResponse
    {
        $school = $this->schoolService->createSchool($request->validated());

        return $this->respondCreated(SchoolResource::make($school));
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
        $school = $this->schoolService->getSchoolById($id);

        return $this->respondSuccess(SchoolResource::make($school));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSchoolRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateSchoolRequest $request, $id): JsonResponse
    {
        $school = $this->schoolService->updateSchool($id, $request->validated());

        return $this->respondSuccess(SchoolResource::make($school));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws \App\Exceptions\BusinessLogicException
     */
    public function destroy(int $id): JsonResponse
    {
        $this->schoolService->removeSchool($id);

        return $this->respondSuccess();
    }

    /**
     * @param UpdateSchoolStatusRequest $request
     *
     * @return JsonResponse
     */
    public function setStatus(UpdateSchoolStatusRequest $request): JsonResponse
    {
        $school = $this->schoolService->setStatus(
            $request->input('school_id'),
            $request->input('status')
        );

        return $this->respondSuccess(SchoolResource::make($school));
    }
}
