<?php

namespace App\Http\Requests\Dashboard\Game;

use App\Models\City;
use App\Models\Country;
use App\Models\Division;
use App\Models\League;
use App\Models\School;
use App\Models\Stadium;
use App\Models\Team;
use App\Models\Tournament;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetGamesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'limit' => ['nullable', 'integer', 'max:250'],
            'page' => ['nullable', 'integer', 'min:1'],
            'country_id' => ['required', 'integer', Rule::exists(Country::class, 'id')],
            'city_id' => ['required', 'integer', Rule::exists(City::class, 'id')],
            'leagues' => ['nullable', 'array'],
            'leagues.*' => ['nullable', 'integer', Rule::exists(League::class, 'id')],
            'divisions' => ['nullable', 'array'],
            'divisions.*' => ['required', 'integer', Rule::exists(Division::class, 'id')],
            'teams' => ['nullable', 'array'],
            'teams.*' => ['nullable', 'integer', Rule::exists(Team::class, 'id')],
            'tournaments' => ['nullable', 'array'],
            'tournaments.*' => ['nullable', 'integer', Rule::exists(Tournament::class, 'id')],
            'stadiums' => ['nullable', 'array'],
            'stadiums.*' => ['nullable', 'integer', Rule::exists(Stadium::class, 'id')],
            'schools' => ['nullable', 'array'],
            'schools.*' => ['nullable', 'integer', Rule::exists(School::class, 'id')],
            'dates' => ['nullable', 'array'],
            'dates.*' => ['nullable', 'date'],
        ];
    }
}
