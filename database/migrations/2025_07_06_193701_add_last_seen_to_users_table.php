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
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_seen_at')->nullable()->after('email_verified_at');
            $table->string('national_id')->nullable()->unique()->after('password');
            $table->foreignId('class_group_id')->nullable()->after('password')->constrained('class_groups')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_seen_at');
            $table->dropColumn('national_id');
            $table->dropForeign(['class_group_id']);
        });
    }
};