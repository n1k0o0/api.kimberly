<?php

namespace App\Http\Requests\Dashboard\School\Team;

use App\Models\Division;
use App\Models\School;
use App\Models\TeamColor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTeamRequest extends FormRequest
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
            'school_id' => ['required', 'integer', Rule::exists(School::class, 'id')],
            'color_id' => ['required', 'integer', Rule::exists(TeamColor::class, 'id')],
            'division_id' => ['required', 'integer', Rule::exists(Division::class, 'id')],
        ];
    }
}
