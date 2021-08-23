<?php

namespace App\Http\Requests\InternalUser;

use Illuminate\Foundation\Http\FormRequest;

class PaginateInternalUserRequest extends FormRequest
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
            'login' => 'sometimes|string|nullable',
            'types' => 'sometimes|array',
            'created_at_start' => 'sometimes|date',
            'created_at_end' => 'sometimes|date',
        ];
    }
}
