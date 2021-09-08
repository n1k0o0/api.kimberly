<?php

namespace App\Http\Requests\Dashboard\InternalUser;

use App\Models\InternalUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInternalUserRequest extends FormRequest
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
            'login' => 'sometimes',
            'first_name' => 'sometimes|string|nullable',
            'last_name' => 'sometimes|string|nullable',
            'patronymic' => 'sometimes|string|nullable',
            'phone' => [
                'sometimes',
                'string',
                'nullable',
                Rule::unique('internal_users', 'phone')->ignore($this->input('id')),
            ],
            'type' => [
                'sometimes',
                'string',
                Rule::in(InternalUser::TYPES),
            ],
            'password' => 'sometimes'
        ];
    }
}
