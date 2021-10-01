<?php

namespace App\Http\Requests\Dashboard\School\Team;

use App\Models\City;
use App\Models\Country;
use App\Models\Division;
use App\Models\League;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetTeamsRequest extends FormRequest
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

            'league_id' => ['nullable', 'integer', Rule::exists(League::class, 'id')],
            'league_ids' => ['nullable', 'array'],
            'league_ids.*' => ['nullable', 'integer', Rule::exists(League::class, 'id')],

            'division_id' => ['nullable', 'integer', Rule::exists(Division::class, 'id')],
            'division_ids' => ['nullable', 'array'],
            'division_ids.*' => ['required', 'integer', Rule::exists(Division::class, 'id')],
        ];
    }
}
