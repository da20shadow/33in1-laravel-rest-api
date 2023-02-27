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
        'neck',
        'shoulders',
        'chest',
        'waist',
        'arm',
        'hips',
        'thigh',
        'calf',
    ];
}
