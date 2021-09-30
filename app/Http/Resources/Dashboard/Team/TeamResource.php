<?php

namespace App\Http\Resources\Dashboard\Team;

use App\Http\Resources\Dashboard\Division\DivisionResource;
use App\Http\Resources\Dashboard\League\LeagueResource;
use App\Http\Resources\Dashboard\School\SchoolResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
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
            'school' => SchoolResource::make($this->whenLoaded('school')),
            'name' => $this->school->name . ' ' . $this->color->color
        ];
    }
}
