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
        Schema::create('meal_logs', function (Blueprint $table) {
            $table->id();
            $table->float('serving_size');
            $table->float('quantity')->default(1);
            $table->enum('meal_type',['Breakfast','Lunch','Dinner',
                'Morning snack', 'Afternoon snack', 'Evening snack']);
            $table->foreignIdFor(\App\Models\Food::class);
            $table->foreignIdFor(\App\Models\User::class);
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_logs');
    }
};
