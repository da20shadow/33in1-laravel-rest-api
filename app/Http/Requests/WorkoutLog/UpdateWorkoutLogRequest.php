<?php

namespace App\Http\Requests\WorkoutLog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkoutLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'exercise_id' => ['required','numeric','sometimes','nullable'],
            'reps' => ['numeric','sometimes','nullable'],
            'minutes' => ['numeric','sometimes','nullable'],
            'intensity' => ['required','string', Rule::in(['slow', 'moderate', 'energetic']),'sometimes','nullable'],
            'start_time' => ['date','sometimes','nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'exercise_id.numeric' => 'Please enter valid exercise id!',
            'reps.numeric' => 'Please enter valid workout reps!',
            'minutes.numeric' => 'Please enter valid workout minutes!',
            'intensity.numeric' => 'Please enter valid workout calories!',
            'start_time.date' => 'Please enter valid workout start time!',
        ];
    }
}
