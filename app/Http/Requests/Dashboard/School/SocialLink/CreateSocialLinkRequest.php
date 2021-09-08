<?php

namespace App\Http\Requests\Dashboard\School\SocialLink;

use Illuminate\Foundation\Http\FormRequest;

class CreateSocialLinkRequest extends FormRequest
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
            'school_id' => 'sometimes|integer',
            'service' => 'required|string',
            'link' => 'required|string|url',
        ];
    }
}
