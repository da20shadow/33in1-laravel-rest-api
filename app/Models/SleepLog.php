<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SleepLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'date',
        'sleep_start_time',
        'sleep_end_time',
        'nap_start_time',
        'nap_end_time',
    ];
}
