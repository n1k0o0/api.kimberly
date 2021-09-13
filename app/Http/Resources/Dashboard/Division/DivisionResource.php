<?php

namespace App\Http\Resources\Dashboard\Division;

use App\Http\Resources\League\LeagueResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DivisionResource extends JsonResource
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
            'league_id' => $this->league_id,
            'league' => LeagueResource::make($this->whenLoaded('league')),
        ];
    }
}
