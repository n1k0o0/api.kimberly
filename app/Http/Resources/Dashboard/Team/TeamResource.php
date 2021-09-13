<?php

namespace App\Http\Resources\Dashboard\Team;

use App\Http\Resources\Dashboard\Division\DivisionResource;
use App\Http\Resources\Dashboard\League\LeagueResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
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
            'division_id' => $this->division_id,
            'division' => DivisionResource::make($this->whenLoaded('division')),
            'color_id' => $this->color_id,
            'color' => ColorResource::make($this->whenLoaded('color')),
            'league_id' => $this->when($this->relationLoaded('league'), optional($this->league)->id),
            'league' => LeagueResource::make($this->whenLoaded('league')),
        ];
    }
}
