<?php

namespace App\Http\Requests\Dashboard\Stadium;

use Illuminate\Foundation\Http\FormRequest;

class CreateStadiumRequest extends FormRequest
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
            'title' => 'required|string',
            'address' => 'required|string',
            'city_id' => 'required|integer|exists:cities,id'
        ];
    }
}
