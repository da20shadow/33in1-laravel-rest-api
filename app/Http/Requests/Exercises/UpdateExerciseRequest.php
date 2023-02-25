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
            'name' => ['string', 'sometimes'],
            'description' => ['string', 'sometimes'],
            'cal_per_rep' => ['numeric', 'sometimes'],
            'cal_per_min' => ['numeric', 'sometimes'],
            'slow_met' => ['numeric', 'sometimes'],
            'moderate_met' => ['numeric', 'sometimes'],
            'energetic_met' => ['numeric', 'sometimes',],
            'type' => ['string', 'sometimes'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Please enter valid exercise name!',
            'description.string' => 'Please enter valid exercise description!',
            'cal_per_rep.numeric' => 'Please enter valid exercise calories per rep!',
            'cal_per_min.numeric' => 'Please enter valid exercise calories per minute!',
            'type.string' => 'Please enter valid exercise type!',
            'slow_met.numeric' => 'Please enter valid Slow MET!',
            'moderate_met.numeric' => 'Please enter valid Moderate MET!',
            'energetic_met.numeric' => 'Please enter valid Energetic MET!',
        ];
    }

}
