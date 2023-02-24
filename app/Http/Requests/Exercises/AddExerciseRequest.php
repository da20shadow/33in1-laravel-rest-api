<?php

namespace App\Http\Requests\Exercises;

use Illuminate\Foundation\Http\FormRequest;

class AddExerciseRequest extends FormRequest
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
            'cal_per_rep' => ['required','numeric'],
            'cal_per_min' => ['required','numeric'],
            'type' => ['required','string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name' => 'Please enter valid exercise name!',
            'description' => 'Please enter valid exercise description!',
            'cal_per_rep' => 'Please enter valid exercise calories per rep!',
            'cal_per_min' => 'Please enter valid exercise calories per minute!',
            'type' => 'Please enter valid exercise type!',
        ];
    }
}
