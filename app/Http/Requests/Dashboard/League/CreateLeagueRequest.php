<?php

namespace App\Http\Requests\Dashboard\League;

use Illuminate\Foundation\Http\FormRequest;

class CreateLeagueRequest extends FormRequest
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
            'name' => 'required|string',
            'city_id' => 'required|integer|exists:cities,id',
            'divisions.*' => 'sometimes|array',
            'divisions.*.name' => 'required|string',
        ];
    }
}
