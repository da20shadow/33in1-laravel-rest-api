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
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable(false);
            $table->integer('calories')->nullable(false);
            $table->float('protein');
            $table->float('carbs');
            $table->float('fat');
            $table->float('fiber');
            $table->float('vitaminA');
            $table->float('vitaminC');
            $table->float('potassium');
            $table->float('calcium');
            $table->float('sodium');
            $table->float('iron');
            $table->enum('status',['Waiting Approval','Published']);
            $table->enum('category', ['Appetizer','Salad','Soup','Fish','Main dish','Roast','Dessert','Snack']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
