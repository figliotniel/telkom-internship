<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\StudentProfile;
use App\Models\MentorProfile;
use App\Models\Internship;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Clean the Slate
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        User::truncate();
        Division::truncate();
        Internship::truncate();
        StudentProfile::truncate();
        MentorProfile::truncate();
        \App\Models\DailyLogbook::truncate();
        \App\Models\Attendance::truncate();
        \App\Models\Evaluation::truncate();
        \App\Models\InternshipExtension::truncate();
        \App\Models\Document::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $faker = \Faker\Factory::create('id_ID');

        // 1. Create Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@telkom.co.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Create Divisions
        $divisionsData = [
            ['name' => 'Shared Service and General Support', 'code' => 'SSGS'],
            ['name' => 'Business Service', 'code' => 'BS'],
            ['name' => 'Government Service', 'code' => 'GS'],
            ['name' => 'Performance, Risk, and Quality of Sales', 'code' => 'PRQS'],
        ];
        $divisions = [];
        foreach ($divisionsData as $data) {
            $divisions[] = Division::create($data);
        }

        // 3. Create 5 Mentors
        $mentors = [];
        for ($i = 0; $i < 5; $i++) {
            $mentor = User::create([
                'name' => $faker->name,
                'email' => "mentor" . ($i + 1) . "@telkom.co.id",
                'password' => Hash::make('password'),
                'role' => 'mentor',
            ]);

            MentorProfile::create([
                'user_id' => $mentor->id,
                'nik' => "NIK-M-00" . ($i + 1),
                'position' => 'Senior Staff',
                'quota' => 10,
            ]);

            $mentors[] = $mentor;
        }

        // 4. Create 10 Pending Interns
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => "pending" . ($i + 1) . "@student.com",
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
            StudentProfile::create([
                'user_id' => $user->id,
                'university' => $faker->company,
                'major' => 'Informatika',
                'nim' => "NIM-P-00" . ($i + 1)
            ]);
            Internship::create([
                'student_id' => $user->id,
                'status' => 'pending',
                'mentor_id' => null,
                'division_id' => null,
                'start_date' => now()->addDays(7),
                'end_date' => now()->addMonths(3),
            ]);
        }

        // 5. Create 20 Active Interns (10 MHS, 10 SMK)
        $activeInterns = [];
        for ($i = 1; $i <= 20; $i++) {
            $isSmk = $i <= 10; // First 10 are SMK, Next 10 are MHS
            
            $user = User::create([
                'name' => $faker->name,
                'email' => "active" . $i . "@student.com",
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);

            StudentProfile::create([
                'user_id' => $user->id,
                'university' => $isSmk ? 'SMK Telkom' : 'Telkom University',
                'major' => $isSmk ? 'RPL' : 'Teknik Informatika',
                'nim' => "NIM-A-00" . $i,
                'education_level' => $isSmk ? 'SMK' : 'S1',
                'student_type' => $isSmk ? 'siswa' : 'mahasiswa'
            ]);

            $internship = Internship::create([
                'student_id' => $user->id,
                'status' => 'active',
                'mentor_id' => $mentors[array_rand($mentors)]->id,
                'division_id' => $divisions[array_rand($divisions)]->id,
                'start_date' => now()->subMonths(1),
                'end_date' => now()->addMonths(2),
            ]);

            // Add 6 validated logbooks
            for ($j = 1; $j <= 6; $j++) {
                \App\Models\DailyLogbook::create([
                    'internship_id' => $internship->id,
                    'date' => now()->subDays(6 - $j)->toDateString(),
                    'title' => "Aktivitas Hari ke-$j",
                    'activity' => "Melakukan pengerjaan modul $j dan riset mendalam.",
                    'status' => 'approved',
                ]);
            }
        }

        // 6. Create 5 Finished Interns
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => "finished" . $i . "@student.com",
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);
            StudentProfile::create([
                'user_id' => $user->id,
                'university' => 'Universitas Indonesia',
                'major' => 'Manajemen Bisnis',
                'nim' => "NIM-F-00" . $i
            ]);
            $internship = Internship::create([
                'student_id' => $user->id,
                'status' => 'finished',
                'mentor_id' => $mentors[array_rand($mentors)]->id,
                'division_id' => $divisions[array_rand($divisions)]->id,
                'start_date' => now()->subMonths(4),
                'end_date' => now()->subDays(5),
            ]);

            // Add 10 validated logbooks
            for ($j = 1; $j <= 10; $j++) {
                \App\Models\DailyLogbook::create([
                    'internship_id' => $internship->id,
                    'date' => now()->subMonths(1)->addDays($j)->toDateString(),
                    'title' => "Laporan Akhir Progres $j",
                    'activity' => "Finalisasi dokumentasi bagian $j dan testing sistem.",
                    'status' => 'approved',
                ]);
            }
        }
    }
}
