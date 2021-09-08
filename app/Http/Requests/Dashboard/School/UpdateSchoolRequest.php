<?php

namespace App\Http\Requests\Dashboard\School;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolRequest extends FormRequest
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
            'name' => 'sometimes|string|',
            'description' => 'sometimes|string',
            'city_id' => 'sometimes|integer|exists:cities,id',
            'branch_count' => 'sometimes|integer|min:0',
            'email' => 'sometimes|string|email',
            'phone' => 'sometimes|string',
            'avatar' => 'sometimes|file|image',
        ];
    }
}
