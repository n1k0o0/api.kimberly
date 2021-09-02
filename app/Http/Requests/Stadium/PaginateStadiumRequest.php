<?php

namespace App\Http\Requests\Stadium;

use Illuminate\Foundation\Http\FormRequest;

class PaginateStadiumRequest extends FormRequest
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
            'limit' => 'required|integer',
            'country_ids' => 'sometimes|array',
            'city_id' => 'sometimes|integer',
        ];
    }
}
