<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Internship;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CleanupRejectedApplicants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-rejected-applicants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete rejected internship applications older than 3 days.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = 3;
        $cutoffDate = now()->subDays($days);

        $this->info("Scanning for rejected applications updated before: " . $cutoffDate->toDateTimeString());

        $internships = Internship::where('status', 'rejected')
            ->where('updated_at', '<', $cutoffDate)
            ->with(['student', 'student.studentProfile', 'documents'])
            ->get();

        if ($internships->isEmpty()) {
            $this->info("No rejected applications found older than {$days} days.");
            return;
        }

        $count = 0;

        foreach ($internships as $internship) {
            $student = $internship->student;

            // 1. Delete Documents (CV, Transkrip, etc.)
            foreach ($internship->documents as $doc) {
                if (Storage::exists($doc->file_path)) {
                    Storage::delete($doc->file_path);
                }
                $doc->delete();
            }

            // 2. Delete Response Letter if exists
            if ($internship->response_letter && Storage::exists($internship->response_letter)) {
                Storage::delete($internship->response_letter);
            }

            // 3. Delete Internship Record
            $internship->delete();

            // 4. Delete Student Profile & User Account
            if ($student) {
                // Delete Profile Photo if exists (optional logic, if stored separately)
                // $student->studentProfile->delete(); // Handled by cascade or manual
                if ($student->studentProfile) {
                    $student->studentProfile->delete();
                }

                $studentName = $student->name;
                $studentId = $student->id;

                $student->delete();

                Log::info("Auto-cleanup: Deleted rejected applicant {$studentName} (ID: {$studentId})");
                $this->info("Deleted: {$studentName} (ID: {$studentId})");
                $count++;
            }
        }

        $this->info("Cleanup complete. Total deleted: {$count}");
    }
}
