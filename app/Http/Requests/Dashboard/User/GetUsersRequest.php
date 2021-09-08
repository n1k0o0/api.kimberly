<?php

namespace App\Http\Requests\Dashboard\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetUsersRequest extends FormRequest
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
            'login' => 'sometimes|string',
            'created_at.start' => 'sometimes|datetime',
            'created_at.end' => 'sometimes|datetime',
            'type' => [
                'sometimes',
                Rule::in(User::TYPES),
            ],
        ];
    }
}
