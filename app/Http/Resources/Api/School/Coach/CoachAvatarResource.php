<?php

namespace App\Http\Resources\Api\School\Coach;

use App\Http\Resources\ImageResource;

class CoachAvatarResource extends ImageResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
