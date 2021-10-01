<?php

namespace App\Http\Requests\Dashboard\Game;

use App\Models\City;
use App\Models\Country;
use App\Models\Division;
use App\Models\League;
use App\Models\Stadium;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'country_id' => ['required', 'integer', Rule::exists(Country::class, 'id')],
            'city_id' => ['required', 'integer', Rule::exists(City::class, 'id')],
            'team_1_id' => ['required', 'integer', Rule::exists(Team::class, 'id')],
            'team_2_id' => ['required', 'integer', Rule::exists(Team::class, 'id')],
            'league_id' => ['nullable', 'integer', Rule::exists(League::class, 'id')],
            'division_id' => ['nullable', 'integer', Rule::exists(Division::class, 'id')],
            'tournament_id' => ['nullable', 'integer', Rule::exists(Tournament::class, 'id')],
            'stadium_id' => ['nullable', 'integer', Rule::exists(Stadium::class, 'id')],
            'started_at' => ['nullable', 'date'],
        ];
    }
}
