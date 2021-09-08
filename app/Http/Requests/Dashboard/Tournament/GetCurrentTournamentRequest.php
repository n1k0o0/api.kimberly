<?php

namespace App\Http\Requests\Dashboard\Tournament;

use Illuminate\Foundation\Http\FormRequest;

class GetCurrentTournamentRequest extends FormRequest
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
            'city_id' => 'required|integer|exists:cities,id',
        ];
    }
}
