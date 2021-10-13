<?php

namespace App\Http\Requests\Api\School;

use App\Models\City;
use App\Models\Coach;
use App\Models\Division;
use App\Models\Team;
use App\Models\TeamColor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSchoolRequest extends FormRequest
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
            'coaches_del_id' => ['sometimes', 'required', 'array'],
            'coaches_del_id.*' => ['nullable', 'integer', Rule::exists(Coach::class, 'id')],
            'teams_del_id' => ['nullable', 'array'],
            'teams_del_id.*' => ['nullable', 'integer', Rule::exists(Team::class, 'id')],

            'coaches' => ['sometimes', 'required', 'array'],
            'coaches.*.id' => ['nullable', Rule::exists(Coach::class, 'id')],
            'coaches.*.first_name' => ['required_with:coaches', 'string'],
            'coaches.*.last_name' => ['required_with:coaches', 'string'],
            'coaches.*.patronymic' => ['nullable', 'string'],
            'coaches.*.avatar' => ['nullable', 'image'],

            'teams' => ['sometimes', 'required', 'array'],
            'teams.*.id' => ['nullable', 'integer', Rule::exists(Team::class, 'id'),'not_in:'],
            'teams.*.division_id' => ['required', 'integer', Rule::exists(Division::class, 'id')],
            'teams.*.color_id' => ['required_with:teams.*.id', 'integer', Rule::exists(TeamColor::class, 'id')],

        ];
    }
}
