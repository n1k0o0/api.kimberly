<?php

namespace App\Http\Controllers;

use App\Http\Requests\City\IndexCitiesRequest;
use App\Http\Resources\City\CityResource;
use App\Services\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends ApiController
{
    private CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexCitiesRequest $request
     *
     * @return JsonResponse
     */
    public function index(IndexCitiesRequest $request): JsonResponse
    {
        $cities = $this->cityService->getCities($request->input('country_id'));

        return $this->respondSuccess(CityResource::collection($cities));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
