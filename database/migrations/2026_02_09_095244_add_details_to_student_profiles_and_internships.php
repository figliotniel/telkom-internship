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
        // Add details to student_profiles
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->enum('education_level', ['SMK', 'D3', 'D4', 'S1'])->nullable()->after('major');
            $table->date('date_of_birth')->nullable()->after('education_level');
        });

        // Add details to internships
        Schema::table('internships', function (Blueprint $table) {
            $table->string('location')->default('Witel Semarang')->after('division_id');
            $table->string('pact_integrity')->nullable()->after('location'); // Path to Pact Integrity Photo
            $table->string('response_letter')->nullable()->after('pact_integrity'); // Path to Acceptance/Rejection Letter
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->dropColumn(['education_level', 'date_of_birth']);
        });

        Schema::table('internships', function (Blueprint $table) {
            $table->dropColumn(['location', 'pact_integrity', 'response_letter']);
        });
    }
};
