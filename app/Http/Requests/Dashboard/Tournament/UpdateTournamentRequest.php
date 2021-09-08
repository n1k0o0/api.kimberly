<?php

namespace App\Http\Requests\Dashboard\Tournament;

use App\Models\Tournament;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTournamentRequest extends FormRequest
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
            'name' => 'sometimes|string',
            'city_id' => 'sometimes|exists:cities,id',
            'started_at' => 'sometimes|date',
            'ended_at' => 'sometimes|date|after_or_equal:started_at',
        ];
    }
}
