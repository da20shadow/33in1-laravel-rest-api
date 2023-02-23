<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeworkLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'minutes',
        'calories',
        'homework_id',
        'user_id',
    ];
}
