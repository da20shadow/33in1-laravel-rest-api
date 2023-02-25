<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sleep_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->dateTime('date');
            $table->dateTime('sleep_start_time');
            $table->dateTime('sleep_end_time')->nullable();
            $table->dateTime('nap_start_time')->nullable();
            $table->dateTime('nap_end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sleep_logs');
    }
};
