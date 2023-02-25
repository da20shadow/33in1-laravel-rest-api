<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MealLogs extends Model
{
    use HasFactory;
    protected $fillable = [
      'food_id',
      'meal_id',
      'serving_size', //The serving size of the food consumed in the meal.
      'quantity', //The number of servings of the food consumed in the meal.
      'created_at',
      'user_id',
    ];

    public function mealLogs(): HasMany
    {
        return $this->hasMany(Food::class);
    }
}
