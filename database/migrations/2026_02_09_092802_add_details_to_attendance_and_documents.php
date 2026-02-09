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
        Schema::table('attendances', function (Blueprint $table) {
            if (!Schema::hasColumn('attendances', 'permit_type')) {
                $table->enum('permit_type', ['full', 'half', 'temporary'])->nullable()->after('status');
            }
            if (!Schema::hasColumn('attendances', 'attachment')) {
                $table->string('attachment')->nullable()->after('permit_type');
            }
            if (!Schema::hasColumn('attendances', 'permit_start_time')) {
                $table->time('permit_start_time')->nullable()->after('attachment');
                $table->time('permit_end_time')->nullable()->after('permit_start_time');
            }
        });

        // Add 'perpanjangan_magang' type to documents
        // SQLite does not support MODIFY COLUMN or ENUM natively (it uses TEXT).
        // So we don't need to alter the table structure for SQLite, just the application logic.
        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE documents MODIFY COLUMN type ENUM('pakta_integritas', 'cv', 'transkrip', 'laporan_akhir', 'perpanjangan_magang', 'laporan_bulanan') NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['permit_type', 'attachment']);
        });

        // Revert document type enum (risky if data exists, but okay for dev)
        // Ignoring revert for enum to avoid data loss if new types were used.
    }
};
