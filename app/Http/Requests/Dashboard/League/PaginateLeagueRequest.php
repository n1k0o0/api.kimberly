<?php

namespace App\Http\Requests\Dashboard\League;

use Illuminate\Foundation\Http\FormRequest;

class PaginateLeagueRequest extends FormRequest
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
            'limit' => 'sometimes|integer|nullable',
            'country_ids' => 'sometimes|array',
            'country_id' => 'sometimes|integer',
            'city_ids' => 'sometimes|array',
            'city_id' => 'sometimes|integer',
        ];
    }
}
