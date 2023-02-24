<?php

namespace App\Http\Requests\Homework;

use Illuminate\Foundation\Http\FormRequest;

class AddHomeworkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required','string'],
            'description' => ['required','string'],
            'met' => ['required','numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Please enter valid homework name!',
            'name.required' => 'Please enter homework name!',
            'description.string' => 'Please enter valid homework description!',
            'description.required' => 'Please enter homework description!',
            'met.numeric' => 'Please enter valid homework MET!',
            'met.required' => 'Please enter homework MET!',
        ];
    }
}
