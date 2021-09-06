<?php

namespace App\Http\Controllers;

use App\Http\Requests\School\SocialLink\CreateSocialLinkRequest;
use App\Http\Requests\School\SocialLink\UpdateSocialLinkRequest;
use App\Http\Resources\SocialLink\SocialLinkResource;
use App\Services\SocialLinkService;
use Illuminate\Http\JsonResponse;

class SocialLinkController extends ApiController
{
    public function __construct(private SocialLinkService $socialLinkService)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSocialLinkRequest  $request
     *
     * @return JsonResponse
     */
    public function store(CreateSocialLinkRequest $request): JsonResponse
    {
        $socialLink = $this->socialLinkService->createSocialLink($request->validated());

        return $this->respondCreated(SocialLinkResource::make($socialLink));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSocialLinkRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateSocialLinkRequest $request, int $id): JsonResponse
    {
        $socialLink = $this->socialLinkService->updateSocialLink($id, $request->validated());

        return $this->respondSuccess(SocialLinkResource::make($socialLink));
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
        $this->socialLinkService->removeSocialLink($id);

        return $this->respondSuccess();
    }
}
