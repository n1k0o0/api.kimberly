<?php

namespace App\Http\Requests\Api\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'patronymic' => 'sometimes|nullable|string',
            'phone' => 'sometimes|nullable|string',
            'email' => 'sometimes|string|email',
            'password' => 'sometimes|string|min:6',
        ];
    }
}
