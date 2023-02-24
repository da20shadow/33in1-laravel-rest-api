<?php

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
        Schema::create('body_compositions', function (Blueprint $table) {
            $table->id();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->float('chest')->nullable();
            $table->float('waist')->nullable();
            $table->float('arm')->nullable();
            $table->float('hips')->nullable();
            $table->float('upper_thigh')->nullable();
            $table->float('calves')->nullable();
            $table->foreignIdFor(User::class)->nullable(false)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_compositions');
    }
};
