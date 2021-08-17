<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * Class ApiController
 *
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{
    /**
     * @param  mixed  $data
     *
     * @return JsonResponse
     */
    public function respondSuccess($data = []): JsonResponse
    {
        return response()->json($data, JsonResponse::HTTP_OK);
    }

    /**
     * @param  mixed  $data
     *
     * @return JsonResponse
     */
    public function respondCreated($data = []): JsonResponse
    {
        return response()->json($data, JsonResponse::HTTP_CREATED);
    }

    /**
     * @param  mixed  $data
     *
     * @return JsonResponse
     */
    public function respondAccepted($data = []): JsonResponse
    {
        return response()->json($data, JsonResponse::HTTP_ACCEPTED);
    }

    /**
     * @param mixed $data
     *
     * @return JsonResponse
     */
    public function respondUnprocessableEntity($data=null): JsonResponse
    {
        return response()->json($data, JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param mixed $data
     *
     * @return JsonResponse
     */
    public function respondUnauthorized($data=null): JsonResponse
    {
        return response()->json($data, JsonResponse::HTTP_UNAUTHORIZED);
    }
}
