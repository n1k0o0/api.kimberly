<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Dashboard\School\CreateSchoolRequest;
use App\Http\Requests\Dashboard\School\UpdateSchoolRequest;
use App\Http\Resources\School\SchoolResource;
use App\Services\SchoolService;
use Exception;
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
     * @throws Exception
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
     * @throws BusinessLogicException
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
