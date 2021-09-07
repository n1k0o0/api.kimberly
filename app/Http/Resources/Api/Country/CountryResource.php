<?php

namespace App\Http\Resources\Api\Country;

use App\Http\Resources\City\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'cities' => CityResource::collection($this->whenLoaded('cities')),
        ];
    }
}
