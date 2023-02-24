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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->nullable(false);
            $table->string('description')->nullable(false);
            $table->float('cal_per_rep')->nullable();
            $table->float('cal_per_min')->nullable();
            $table->enum('type',['Chest','Shoulder','Arms','Back','Abs','Legs'])->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
