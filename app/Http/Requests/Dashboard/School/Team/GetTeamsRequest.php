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
            'country_id' => ['required', 'integer', Rule::exists(Country::class, 'id')],
            'city_id' => ['required', 'integer', Rule::exists(City::class, 'id')],
            'leagues' => ['nullable', 'array'],
            'leagues.*' => ['nullable', 'integer', Rule::exists(League::class, 'id')],
            'divisions' => ['nullable', 'array'],
            'divisions.*' => ['required', 'integer', Rule::exists(Division::class, 'id')],
        ];
    }
}
