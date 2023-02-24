<?php

namespace App\Http\Requests\WorkoutLog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddWorkoutLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'exercise_id' => ['required','numeric'],
            'reps' => ['numeric','required_without:minutes','nullable'],
            'minutes' => ['numeric','required_without:reps','nullable'],
            'intensity' => ['required','string', Rule::in(['slow', 'moderate', 'energetic'])]
        ];
    }

    public function messages(): array
    {
        return [
            'exercise_id.numeric' => 'Please enter valid exercise id!',
            'exercise_id.required' => 'Please enter valid exercise id!',
            'reps.numeric' => 'Please enter valid workout reps!',
            'reps.required' => 'Please enter workout reps!',
            'minutes.numeric' => 'Please enter valid workout minutes!',
            'minutes.required' => 'Please enter workout minutes!',
            'intensity.string' => 'Please enter valid workout intensity!',
            'intensity.required' => 'Please enter workout intensity!',
        ];
    }
}
