<?php

namespace App\Http\Requests\Homework;

use Illuminate\Foundation\Http\FormRequest;

class UpdatedHomeworkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes','string','nullable'],
            'description' => ['sometimes','string','nullable'],
            'met' => ['sometimes','numeric','nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Please enter valid homework name!',
            'description.string' => 'Please enter valid homework description!',
            'met.numeric' => 'Please enter valid homework MET!',
        ];
    }
}
