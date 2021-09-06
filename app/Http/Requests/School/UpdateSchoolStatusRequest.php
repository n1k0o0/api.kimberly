<?php

namespace App\Http\Requests\School;

use App\Models\School;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSchoolStatusRequest extends FormRequest
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
            'school_id' => 'required|int',
            'status' => [
                'required',
                'string',
                Rule::in(School::STATUSES),
            ],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['school_id' => $this->route('id')]);
    }
}
