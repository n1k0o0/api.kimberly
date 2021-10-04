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

            'country_id' => ['required_without:country_ids', 'integer', Rule::exists(Country::class, 'id')],
            'country_ids' => ['required_without:country_id', 'array'],
            'country_ids.*' => ['required', 'integer', Rule::exists(Country::class, 'id')],

            'city_id' => ['required_without:city_ids', 'integer', Rule::exists(City::class, 'id')],
            'city_ids' => ['required_without:city_id', 'array'],
            'city_ids.*' => ['required', 'integer', Rule::exists(City::class, 'id')],

            'league_ids' => ['nullable', 'array'],
            'league_ids.*' => ['nullable', 'integer', Rule::exists(League::class, 'id')],
            'league_id' => ['nullable', 'integer', Rule::exists(League::class, 'id')],

            'division_ids' => ['nullable', 'array'],
            'division_ids.*' => ['nullable', 'integer', Rule::exists(Division::class, 'id')],
            'division_id' => ['nullable', 'integer', Rule::exists(Division::class, 'id')],

            'team_ids' => ['nullable', 'array'],
            'team_ids.*' => ['nullable', 'integer', Rule::exists(Team::class, 'id')],
            'team_id' => ['nullable', 'integer', Rule::exists(Team::class, 'id')],

            'tournament_ids' => ['nullable', 'array'],
            'tournament_ids.*' => ['nullable', 'integer', Rule::exists(Tournament::class, 'id')],
            'tournament_id' => ['nullable', 'integer', Rule::exists(Tournament::class, 'id')],

            'stadium_ids' => ['nullable', 'array'],
            'stadium_ids.*' => ['nullable', 'integer', Rule::exists(Stadium::class, 'id')],
            'stadium_id' => ['nullable', 'integer', Rule::exists(Stadium::class, 'id')],

            'school_ids' => ['nullable', 'array'],
            'school_ids.*' => ['nullable', 'integer', Rule::exists(School::class, 'id')],
            'school_id' => ['nullable', 'integer', Rule::exists(School::class, 'id')],

            'dates' => ['nullable', 'array'],
            'dates.*' => ['nullable', 'date'],
            'date' => ['nullable', 'date'],
        ];
    }

    public function attributes(): array
    {
        return [
            'limit' => 'Лимит',
            'team_1_id' => 'Команда 1',
            'page' => 'Страница',
            'team_2_id' => 'Команда 2',
            'league_id' => 'Лига',
            'division_id' => 'Дивизион',
            'tournament_id' => 'Турнир',
            'stadium_id' => 'Стадион',
            'started_at' => 'Дата и время начала',
        ];
    }
}
