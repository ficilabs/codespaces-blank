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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_day_id')->constrained('school_days')->cascadeOnDelete();
            $table->enum('status', ['HADIR', 'SAKIT', 'IZIN', 'ALFA'])->default('HADIR');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'school_day_id']); // only one record per user per day
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
