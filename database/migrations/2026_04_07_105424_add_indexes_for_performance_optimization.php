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
        // Users Table
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
        });

        // Internships Table
        Schema::table('internships', function (Blueprint $table) {
            $table->index('status');
            $table->index('division_id');
            $table->index('student_id');
        });

        // Student Profiles Table
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->index('student_type');
            $table->index('education_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
        });

        Schema::table('internships', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['division_id']);
            $table->dropIndex(['student_id']);
        });

        Schema::table('student_profiles', function (Blueprint $table) {
            $table->dropIndex(['student_type']);
            $table->dropIndex(['education_level']);
        });
    }
};
