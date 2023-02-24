<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Exercise::class)->nullable();
            $table->foreignIdFor(\App\Models\Homework::class)->nullable();
            $table->foreignIdFor(\App\Models\User::class)->nullable(false);
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->enum('status',['Running','Finished']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
