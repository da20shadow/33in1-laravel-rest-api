<?php

namespace App\Http\Requests\BodyComposition;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBodyCompositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'birth_date' => ['date', 'sometimes', 'nullable'],
            'gender' => ['string', 'sometimes', 'nullable'],
            'weight' => ['numeric', 'sometimes', 'nullable'],
            'height' => ['numeric', 'sometimes', 'nullable'],
            'chest' => ['numeric', 'sometimes', 'nullable'],
            'waist' => ['numeric', 'sometimes', 'nullable'],
            'hips' => ['numeric', 'sometimes', 'nullable'],
            'upper_thigh' => ['numeric', 'sometimes', 'nullable'],
            'calves' => ['numeric', 'sometimes', 'nullable'],
            'arm' => ['numeric', 'sometimes', 'nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'birth_date.string' => 'Please enter valid birth date!',
            'gender.string' => 'Please enter valid gender!',
            'weight.string' => 'Please enter valid weight!',
            'height.string' => 'Please enter valid height!',
            'chest.string' => 'Please enter valid chest!',
            'waist.string' => 'Please enter valid waist!',
            'hips.string' => 'Please enter valid hips!',
            'upper_thigh.string' => 'Please enter valid upper thigh!',
            'calves.string' => 'Please enter valid calves!',
            'arm.string' => 'Please enter valid arm!',
        ];
    }
}
