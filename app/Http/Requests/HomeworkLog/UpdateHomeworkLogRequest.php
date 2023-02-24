<?php

namespace App\Http\Requests\HomeworkLog;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeworkLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'minutes' => ['sometimes','numeric','nullable'],
            'calories' => ['sometimes','numeric','nullable'],
            'start_date' => ['sometimes','date','nullable'],
            'homework_id' => ['sometimes','numeric','nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'minutes.numeric' => 'Please enter valid homework minutes!',
            'calories.string' => 'Please enter valid homework calories!',
            'start_time.date' => 'Please enter valid start date!',
            'homework_id.numeric' => 'Please enter valid homework ID!',
        ];
    }
}
