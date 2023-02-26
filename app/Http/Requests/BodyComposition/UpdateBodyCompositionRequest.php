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
            'birth_date' => ['date', 'sometimes'],
            'gender' => ['string', 'sometimes',],
            'weight' => ['numeric', 'sometimes','between:1,1000','nullable'],
            'height' => ['numeric', 'sometimes','between:1,1000','nullable'],
            'chest' => ['numeric', 'sometimes','between:1,1000','nullable'],
            'waist' => ['numeric', 'sometimes','between:1,1000','nullable'],
            'hips' => ['numeric', 'sometimes','between:1,1000','nullable'],
            'upper_thigh' => ['numeric', 'sometimes','between:1,1000','nullable'],
            'calves' => ['numeric', 'sometimes','between:1,1000','nullable'],
            'arm' => ['numeric', 'sometimes','between:1,1000','nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'birth_date.string' => 'Please enter valid birth date!',
            'gender.numeric' => 'Please enter valid gender!',
            'weight.numeric' => 'Please enter valid weight!',
            'height.numeric' => 'Please enter valid height!',
            'chest.numeric' => 'Please enter valid chest!',
            'waist.numeric' => 'Please enter valid waist!',
            'hips.numeric' => 'Please enter valid hips!',
            'upper_thigh.string' => 'Please enter valid upper thigh!',
            'calves.numeric' => 'Please enter valid calves!',
            'arm.numeric' => 'Please enter valid arm!',
        ];
    }
}
