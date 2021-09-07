<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class CreateSchoolRequest extends FormRequest
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
            'city_id' => 'required|integer|exists:cities,id',
            'name' => 'required|string|nullable',
            'description' => 'sometimes|string|nullable',
            'email' => 'required|email|nullable',
            'phone' => 'sometimes|nullable',
            'avatar' => 'sometimes|image|nullable',
            'teams' => 'sometimes|array',
            'coaches' => 'sometimes|array',
            'user_id' => 'required|integer',
            'teams.*' => [
                'school_id' => 'required|integer',
                'division_id' => 'required|integer',
                'color_id' => 'required|integer',
            ],
            'coaches.*' => [
                'school_id' => 'required|integer|exists:schools,id',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'patronymic' => 'sometimes|nullable|string',
                'avatar' => 'sometimes|image|nullable',
            ],
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'user_id' => 1,
        ]);
    }
}
