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
        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->unsignedBigInteger('school_day_id')->after('user_id');
            $table->string('status')->after('school_day_id');
            // Uncomment if you want foreign key constraints:
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('school_day_id')->references('id')->on('school_days')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'school_day_id', 'status']);
        });
    }
};
