<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeworkLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'minutes',
        'calories',
        'homework_id',
        'user_id',
        'start_time'
    ];

    public function homework(): BelongsTo
    {
        return $this->belongsTo(Homework::class);
    }
}
