<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyComposition extends Model
{
    use HasFactory;

    protected $fillable = [
        'birth_date',
        'gender',
        'weight',
        'height',
        'chest',
        'waist',
        'arm',
        'hips',
        'upper_thigh',
        'calves',
    ];
}
