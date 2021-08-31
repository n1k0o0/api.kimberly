<?php

namespace App\Http\Resources\School;

use App\Http\Resources\City\CityResource;
use App\Http\Resources\Coach\CoachResource;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\SocialLink\SocialLinkResource;
use App\Http\Resources\Team\TeamResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'city_id' => $this->city_id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'name' => $this->name,
            'description' => $this->description,
            'email' => $this->email,
            'phone' => $this->phone,
            'branch_count' => $this->branch_count,
            'city' => CityResource::make($this->whenLoaded('city')),
            'country_id' => $this->when($this->country, $this->country->id),
            'user' => UserResource::make($this->whenLoaded('user')),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'teams' => TeamResource::collection($this->whenLoaded('teams')),
            'coaches' => CoachResource::collection($this->whenLoaded('coaches')),
            'social_links' => SocialLinkResource::collection($this->whenLoaded('social_links')),
        ];
    }
}
