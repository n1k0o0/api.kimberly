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
            'avatar' => 'sometimes|nullable',
            'teams' => 'sometimes|array',
            'coaches' => 'sometimes|array',
            'user_id' => 'required|integer',
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'user_id' => 1,
        ]);
    }
}
