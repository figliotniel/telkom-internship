<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\StudentProfile;
use App\Models\MentorProfile;
use App\Models\Internship;
use App\Models\Attendance;
use App\Models\DailyLogbook;
use Illuminate\Support\Facades\Hash;

class SmkSeeder extends Seeder
{
    public function run(): void
    {
        $emailsToDelete = [
            'mentor_smk1@telkom.co.id', 'mentor_smk2@telkom.co.id', 'mentor_smk3@telkom.co.id',
            'siswa_smk1@gmail.com', 'siswa_smk2@gmail.com', 'siswa_smk3@gmail.com',
            'siswa_smk4@gmail.com', 'siswa_smk5@gmail.com', 'siswa_smk6@gmail.com'
        ];
        $users = User::whereIn('email', $emailsToDelete)->get();
        foreach ($users as $user) {
            $internships = Internship::where('student_id', $user->id)->orWhere('mentor_id', $user->id)->get();
            foreach ($internships as $i) {
                Attendance::where('internship_id', $i->id)->delete();
                DailyLogbook::where('internship_id', $i->id)->delete();
                $i->delete();
            }
            if ($user->role === 'student') {
                StudentProfile::where('user_id', $user->id)->delete();
            }
            else {
                MentorProfile::where('user_id', $user->id)->delete();
            }
            $user->delete();
        }

        $allDivisions = Division::all();
        if ($allDivisions->isEmpty()) {
            $this->command->error("No divisions found. Please run DatabaseSeeder first.");
            return;
        }

        $mentorEmails = [];
        $studentEmails = [];
        $password = Hash::make('password');

        $this->command->info("Membuat 3 Mentor baru...");
        $mentors = [];
        for ($i = 4; $i <= 6; $i++) {
            $email = "mentor{$i}@telkom.co.id";
            $mentorEmails[] = $email;
            $mentor = User::updateOrCreate(['email' => $email], [
                'name' => "Mentor {$i}",
                'password' => $password,
                'role' => 'mentor',
            ]);
            MentorProfile::updateOrCreate(['user_id' => $mentor->id], [
                'nik' => fake()->unique()->numerify('##########'),
                'position' => 'Senior Specialist SMK',
                'quota' => 3,
            ]);
            $mentors[] = $mentor;
        }

        $this->command->info("Membuat 6 Siswa SMK baru...");
        for ($i = 1; $i <= 6; $i++) {
            $email = "smk{$i}@gmail.com";
            $studentEmails[] = $email;
            $intern = User::updateOrCreate(['email' => $email], [
                'name' => "Siswa SMK {$i}",
                'password' => $password,
                'role' => 'student',
            ]);

            StudentProfile::updateOrCreate(['user_id' => $intern->id], [
                'university' => 'SMK Telkom ' . fake()->city(),
                'major' => 'Teknik Komputer dan Jaringan',
                'student_type' => 'siswa',
                'education_level' => 'SMK',
                'nim' => fake()->unique()->numerify('##########'),
                'phone' => fake()->phoneNumber(),
            ]);

            // Buat Internship Terkait
            // 2 siswa per mentor
            $mentorIndex = intval(ceil($i / 2)) - 1;
            $mentor = $mentors[$mentorIndex];

            $internship = Internship::updateOrCreate(['student_id' => $intern->id], [
                'mentor_id' => $mentor->id,
                'division_id' => $allDivisions->random()->id,
                'status' => 'active',
                'start_date' => now()->subMonths(1)->format('Y-m-d'),
                'end_date' => now()->addMonths(2)->format('Y-m-d'),
                'location' => 'Semarang',
            ]);

            // Generate riwayat Absensi & Logbook secara acak (15 hari terakhir)
            for ($d = 0; $d < 15; $d++) {
                $date = now()->subDays($d);
                if (!$date->isWeekend()) {
                    Attendance::updateOrCreate(
                    ['internship_id' => $internship->id, 'date' => $date->format('Y-m-d')],
                    [
                        'status' => 'present',
                        'check_in_time' => '08:00:00',
                        'check_out_time' => '17:00:00',
                        'check_in_lat' => -6.992,
                        'check_in_long' => 110.422,
                    ]
                    );

                    DailyLogbook::updateOrCreate(
                    ['internship_id' => $internship->id, 'date' => $date->format('Y-m-d')],
                    [
                        'activity' => fake()->sentence(8),
                        'status' => 'approved',
                        'mentor_note' => 'Kerja bagus!',
                    ]
                    );
                }
            }
        }

        $this->command->info("\n--- DAFTAR EMAIL MENTOR ---");
        foreach ($mentorEmails as $email) {
            $this->command->info($email);
        }

        $this->command->info("\n--- DAFTAR EMAIL SISWA SMK ---");
        foreach ($studentEmails as $email) {
            $this->command->info($email);
        }
    }
}
