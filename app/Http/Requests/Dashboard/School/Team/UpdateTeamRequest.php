<?php

namespace App\Http\Requests\Dashboard\School\Team;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamRequest extends FormRequest
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
            'school_id' => 'sometimes|integer|exists:schools,id',
            'division_id' => 'sometimes|integer|exists:divisions,id',
            'color_id' => 'sometimes|integer|exists:team_colors,id',
        ];
    }
}
