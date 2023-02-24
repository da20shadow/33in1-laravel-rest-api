<?php

namespace App\Http\Requests\Exercises;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExerciseRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['string', 'sometimes', 'nullable'],
            'description' => ['string', 'sometimes', 'nullable'],
            'cal_per_rep' => ['numeric', 'sometimes', 'nullable'],
            'cal_per_min' => ['numeric', 'sometimes', 'nullable'],
            'type' => ['string', 'sometimes', 'nullable'],
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
