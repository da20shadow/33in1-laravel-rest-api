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
            'slow_met' => ['required','numeric'],
            'moderate_met' => ['required','numeric'],
            'energetic_met' => ['required','numeric'],
            'type' => ['required','string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Please enter valid exercise name!',
            'name.required' => 'Please enter exercise name!',
            'description.string' => 'Please enter valid exercise description!',
            'description.required' => 'Please enter exercise description!',
            'cal_per_rep.numeric' => 'Please enter valid exercise calories per rep!',
            'cal_per_rep.required' => 'Please enter exercise calories per rep!',
            'cal_per_min.numeric' => 'Please enter valid exercise calories per minute!',
            'cal_per_min.required' => 'Please enter exercise calories per minute!',
            'type.string' => 'Please enter valid exercise type!',
            'type.required' => 'Please enter exercise type!',
            'slow_met.numeric' => 'Please enter valid exercise MET!',
            'slow_met.required' => 'Please enter exercise type!',
            'moderate_met.numeric' => 'Please enter valid exercise MET!',
            'moderate_met.required' => 'Please enter exercise type!',
            'energetic_met.numeric' => 'Please enter valid exercise MET!',
            'energetic_met.required' => 'Please enter exercise type!',
        ];
    }
}
