<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->enum('student_type', ['mahasiswa', 'siswa'])->default('mahasiswa')->after('user_id');
        });

        // Modify education_level to include SMK/SMA if using MySQL/MariaDB
        if (in_array(DB::connection()->getDriverName(), ['mysql', 'mariadb'])) {
             DB::statement("ALTER TABLE student_profiles MODIFY COLUMN education_level ENUM('D3', 'D4', 'S1', 'SMK', 'SMA') NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->dropColumn('student_type');
        });
        
        // Revert education_level if needed, but usually safe to leave wider enum
        if (in_array(DB::connection()->getDriverName(), ['mysql', 'mariadb'])) {
             DB::statement("ALTER TABLE student_profiles MODIFY COLUMN education_level ENUM('D3', 'D4', 'S1') NULL");
        }
    }
};
