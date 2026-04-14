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
        // SQLite does not support MODIFY COLUMN or ENUM change naturally.
        // We use Laravel's change() which handles this by recreating the table on SQLite.
        Schema::table('attendances', function (Blueprint $table) {
            $table->enum('status', ['present', 'late', 'sick', 'permit', 'alpha'])->default('present')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->enum('status', ['present', 'sick', 'permit', 'alpha'])->default('present')->change();
        });
    }
};
