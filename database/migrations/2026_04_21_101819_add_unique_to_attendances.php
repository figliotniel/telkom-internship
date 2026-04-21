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
        // Cleanup duplicates if any exist (keep the latest one)
        $duplicates = DB::table('attendances')
            ->select('internship_id', 'date', DB::raw('COUNT(*) as count'))
            ->groupBy('internship_id', 'date')
            ->having('count', '>', 1)
            ->get();

        foreach ($duplicates as $duplicate) {
            $ids = DB::table('attendances')
                ->where('internship_id', $duplicate->internship_id)
                ->where('date', $duplicate->date)
                ->orderBy('created_at', 'desc')
                ->pluck('id')
                ->toArray();
            
            array_shift($ids); // Keep the first (latest) one
            DB::table('attendances')->whereIn('id', $ids)->delete();
        }

        Schema::table('attendances', function (Blueprint $table) {
            $table->unique(['internship_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropUnique(['internship_id', 'date']);
        });
    }
};
