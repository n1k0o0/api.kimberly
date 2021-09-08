<?php

namespace App\Http\Requests\Dashboard\InternalUser;

use Illuminate\Foundation\Http\FormRequest;

class CreateInternalUserRequest extends FormRequest
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
            'login' => 'required|string|min:4',
            'first_name' => 'sometimes|string|nullable',
            'last_name' => 'sometimes|string|nullable',
            'patronymic' => 'sometimes|string|nullable',
            'phone' => 'sometimes|string|nullable|unique:internal_users,id',
            'password' => 'required|string|min:6',
        ];
    }
}
