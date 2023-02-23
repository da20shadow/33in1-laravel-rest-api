<?php

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workout_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Exercise::class)->nullable(false);
            $table->integer('reps')->nullable();
            $table->integer('minutes')->nullable();
            $table->float('calories')->nullable(false);
            $table->dateTime('start_time');
            $table->foreignIdFor(User::class)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_logs');
    }
};
