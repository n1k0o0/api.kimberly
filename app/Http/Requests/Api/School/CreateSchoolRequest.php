<?php

namespace App\Http\Requests\Api\School;

use App\Models\City;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateSchoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'city_id' => ['required', 'integer', Rule::exists(City::class, 'id')],
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string'],

            'avatar' => ['nullable', 'image'],

            'coaches' => ['nullable', 'array'],
            'coaches.*.first_name' => ['required_with:coaches', 'string'],
            'coaches.*.last_name' => ['required_with:coaches', 'string'],
            'coaches.*.patronymic' => ['nullable', 'string'],
            'coaches.*.avatar' => ['nullable', 'image'],

            'teams' => ['nullable', 'array'],
            'teams.*.division_id' => ['required_with:teams', 'integer'],
            'teams.*.color_id' => ['nullable', 'integer'],

            'inst_link' => ['nullable', 'url'],
            'youtube_link' => ['nullable', 'url'],
            'vk_link' => ['nullable', 'url'],
            'diagram_link' => ['nullable', 'url'],
        ];
    }
}
