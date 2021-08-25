<?php

namespace App\Http\Resources\League;

use App\Http\Resources\City\CityResource;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Division\DivisionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LeagueResource extends JsonResource
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
            'city_id' => $this->city_id,
            'country_id' => $this->when($this->country, $this->country->id),
            'city' => CityResource::make($this->whenLoaded('city')),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'divisions' => DivisionResource::collection($this->whenLoaded('divisions')),
        ];
    }
}
