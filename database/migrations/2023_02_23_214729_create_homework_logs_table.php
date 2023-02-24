<?php

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
        Schema::create('homework_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('minutes');
            $table->float('calories');
            $table->dateTime('start_time');
            $table->foreignIdFor(\App\Models\Homework::class);
            $table->foreignIdFor(\App\Models\User::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homework_logs');
    }
};
