<?php

namespace App\Http\Requests\Dashboard\School\Coach;

use Illuminate\Foundation\Http\FormRequest;

class CreateCoachRequest extends FormRequest
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
            'school_id' => 'required|integer|exists:schools,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'patronymic' => 'sometimes|nullable|string',
        ];
    }
}
