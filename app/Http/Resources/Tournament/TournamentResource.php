<?php

namespace App\Http\Resources\Tournament;

use App\Http\Resources\City\CityResource;
use App\Http\Resources\Country\CountryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentResource extends JsonResource
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
            'name' => $this->name,
            'status' => $this->status,
            'city_id' => $this->city_id,
            'started_at' => $this->started_at,
            'ended_at' => $this->ended_at,
            'country_id' => $this->when($this->country, $this->country->id),
            'city' => CityResource::make($this->whenLoaded('city')),
            'country' => CountryResource::make($this->whenLoaded('country')),
        ];
    }
}
