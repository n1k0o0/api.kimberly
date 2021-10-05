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
            'country_id' => ['required', 'integer', Rule::exists(Country::class, 'id')],
            'city_id' => ['required', 'integer', Rule::exists(City::class, 'id')],
            'team_1_id' => ['required', 'integer', Rule::exists(Team::class, 'id')],
            'team_2_id' => ['required', 'integer', Rule::exists(Team::class, 'id')],
            'league_id' => ['required', 'integer', Rule::exists(League::class, 'id')],
            'division_id' => ['required', 'integer', Rule::exists(Division::class, 'id')],
            'tournament_id' => ['required', 'integer', Rule::exists(Tournament::class, 'id')],
            'stadium_id' => ['required', 'integer', Rule::exists(Stadium::class, 'id')],
            'started_at' => ['required', 'date'],
            'finished_at' => ['nullable', 'date'],
        ];
    }

    public function attributes(): array
    {
        return [
            'country_id' => 'Страна',
            'city_id' => 'Город',
            'team_1_id' => 'Команда 1',
            'team_2_id' => 'Команда 2',
            'league_id' => 'Лига',
            'division_id' => 'Дивизион',
            'tournament_id' => 'Турнир',
            'stadium_id' => 'Стадион',
            'started_at' => 'Дата и время начала игры',
            'finished_at' => 'Дата и время завершения игры',
        ];
    }
}
