<?php

namespace App\Http\Requests\Dashboard\School\Team;

use App\Models\Division;
use App\Models\TeamColor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeamRequest extends FormRequest
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
            'color_id' => ['nullable', 'integer', Rule::exists(TeamColor::class, 'id')],
            'division_id' => ['required', 'integer', Rule::exists(Division::class, 'id')],
        ];
    }
}
