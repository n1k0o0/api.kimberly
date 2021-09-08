<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Dashboard\School\CreateSchoolRequest; // TODO
use App\Http\Requests\Dashboard\School\UpdateSchoolRequest; // TODO
use App\Http\Resources\School\SchoolResource;
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
     * Store a newly created resource in storage.
     *
     * @param CreateSchoolRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateSchoolRequest $request): JsonResponse
    {
        $school = $this->schoolService->createSchool(
            auth()->id(),
            $request->validated()
        );

        return $this->respondCreated(SchoolResource::make($school));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSchoolRequest $request
     *
     * @return JsonResponse
     */
    public function updateSchool(UpdateSchoolRequest $request): JsonResponse
    {
        $school = $this->schoolService->updateSchoolByUserId(
            auth('users')->id(),
            $request->validated()
        );

        return $this->respondSuccess(SchoolResource::make($school));
    }
}
