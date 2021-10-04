<?php

namespace App\Http\Requests\Dashboard\Tournament;

use Illuminate\Foundation\Http\FormRequest;

class CreateTournamentRequest extends FormRequest
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
            'city_id' => 'required|exists:cities,id',
            'started_at' => [
                'required',
                'date',
                'after_or_equal:' . date('Y-m-d'),
            ],
            'ended_at' => 'required|date|after_or_equal:started_at',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Имя',
            'city_id' => 'Город',
            'started_at' => 'Дата и время начала',
            'ended_at' => 'Дата и время окончания',
        ];
    }
}
