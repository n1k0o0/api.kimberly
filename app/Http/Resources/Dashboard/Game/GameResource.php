<?php

namespace App\Http\Resources\Dashboard\Game;

use App\Http\Resources\Dashboard\Division\DivisionResource;
use App\Http\Resources\Dashboard\League\LeagueResource;
use App\Http\Resources\Dashboard\Stadium\StadiumResource;
use App\Http\Resources\Dashboard\Team\TeamResource;
use App\Http\Resources\Dashboard\Tournament\TournamentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'team_1' => TeamResource::make($this->whenLoaded('firstTeam')),
            'team_2' => TeamResource::make($this->whenLoaded('secondTeam')),
            'division_id' => $this->division_id,
            'division' => DivisionResource::make($this->whenLoaded('division')),
            'league_id' => $this->league_id,
            'status' => $this->status,
            'league' => LeagueResource::make($this->whenLoaded('league')),
            'tournament_id' => $this->tournament_id,
            'tournament' => TournamentResource::make($this->whenLoaded('tournament')),
            'stadium_id' => $this->stadium_id,
            'stadium' => StadiumResource::make($this->whenLoaded('stadium')),
            'pauses' => GamePauseResource::collection($this->whenLoaded('pauses')),
        ];
    }
}
