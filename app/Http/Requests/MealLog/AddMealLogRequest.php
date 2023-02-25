<?php

namespace App\Http\Requests\MealLog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddMealLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'food_id' => ['required', 'numeric', 'gt:0'],
            'serving_size' => ['required', 'numeric', 'between:1,5000'],
            'quantity' => ['required', 'numeric', 'between:0.1,100'],
            'meal_type' => ['required', 'string',
                Rule::in(['Breakfast', 'Lunch', 'Dinner', 'Morning snack', 'Afternoon snack', 'Evening snack'])],
        ];
    }

    public function messages(): array
    {
        return [
            'created_at.date' => 'Please enter valid date!',
            'created_at.required' => 'Please enter date!',
            'quantity.numeric' => 'Please enter valid quantity!',
            'quantity.required' => 'Please enter quantity!',
            'food_id.required' => 'Please, enter food id.',
            'serving_size.required' => 'Please, enter meal serving size.',
            'meal_type.required' => 'Please, enter meal type.',
        ];
    }
}
