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
            $table->float('carbs')->default(0);
            $table->float('protein')->default(0);
            $table->float('fat')->default(0);
            $table->enum('status',['Waiting Approval','Published'])->default('Waiting Approval');
            $table->enum('category', ['Appetizer','Fruits salad','Vegetable salad','Soup','Fish','Main dish','Roast','Dessert','Snack']);
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
