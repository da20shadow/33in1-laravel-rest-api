<?php

namespace App\Http\Requests\HomeworkLog;

use Illuminate\Foundation\Http\FormRequest;

class AddHomeworkLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'minutes' => ['required','numeric'],
            'homework_id' => ['required','numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            'minutes.numeric' => 'Please enter valid homework minutes!',
            'minutes.required' => 'Please enter homework minutes!',
            'homework_id.numeric' => 'Please enter valid homework ID!',
            'homework_id.required' => 'Please enter homework ID!',
        ];
    }
}
