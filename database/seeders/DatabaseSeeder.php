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
        // 0. Buat Akun ADMIN
        $adminEmail = 'admin@telkom.co.id';
        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => $adminEmail,
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        // 1. Buat Data Divisi
        $divisions = [
            ['name' => 'Business Service', 'description' => 'Pengelolaan layanan bisnis.'],
            ['name' => 'Enterprise Service', 'description' => 'Solusi untuk korporat.'],
            ['name' => 'Government Service', 'description' => 'Layanan untuk pemerintah.'],
            ['name' => 'Human Capital', 'description' => 'Pengelolaan SDM.'],
            ['name' => 'Payment Collection', 'description' => 'Manajemen penagihan.'],
            ['name' => 'Warroom', 'description' => 'Pusat pemantauan jaringan.'],
        ];

        foreach ($divisions as $divData) {
            Division::firstOrCreate(['name' => $divData['name']], $divData);
        }

        $allDivisions = Division::all();

        // 2. Buat Akun MENTOR
        $mentors = [
            ['name' => 'Bapak Mentor Telkom', 'email' => 'mentor1@telkom.co.id'],
            ['name' => 'Ibu Mentor Digital', 'email' => 'mentor2@telkom.co.id'],
        ];

        foreach ($mentors as $mentorData) {
            $user = User::firstOrCreate(['email' => $mentorData['email']], [
                'name' => $mentorData['name'],
                'password' => Hash::make('password'),
                'role' => 'mentor',
            ]);

            MentorProfile::firstOrCreate(['user_id' => $user->id], [
                'nik' => fake()->numerify('##########'),
                'position' => 'Senior Engineer',
                'quota' => 5,
            ]);
        }

        $allMentors = User::where('role', 'mentor')->get();

        // 3. Buat Akun MAHASISWA & Internship
        $students = [
            ['name' => 'Dzaky Hamid', 'email' => 'dzaky@student.com'],
            ['name' => 'Budi Santoso', 'email' => 'budi@student.com'],
            ['name' => 'Ani Wijaya', 'email' => 'ani@student.com'],
        ];

        foreach ($students as $studentData) {
            $student = User::firstOrCreate(['email' => $studentData['email']], [
                'name' => $studentData['name'],
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);

            StudentProfile::firstOrCreate(['user_id' => $student->id], [
                'university' => fake()->company(),
                'major' => 'Teknik Informatika',
                'education_level' => 'S1',
                'phone' => fake()->phoneNumber(),
            ]);

            // Create Internship for each student
            $internship = Internship::create([
                'student_id' => $student->id,
                'mentor_id' => $allMentors->random()->id,
                'division_id' => $allDivisions->random()->id,
                'status' => 'active',
                'start_date' => now()->subMonths(1)->format('Y-m-d'),
                'end_date' => now()->addMonths(2)->format('Y-m-d'),
            ]);

            // Create some random Attendance and Logbook for each internship
            for ($i = 0; $i < 10; $i++) {
                $date = now()->subDays($i);
                if (!$date->isWeekend()) {
                    \App\Models\Attendance::create([
                        'internship_id' => $internship->id,
                        'date' => $date->format('Y-m-d'),
                        'status' => 'present',
                        'check_in' => '08:00:00',
                        'check_out' => '17:00:00',
                    ]);

                    \App\Models\DailyLogbook::create([
                        'internship_id' => $internship->id,
                        'date' => $date->format('Y-m-d'),
                        'activity' => fake()->sentence(10),
                        'status' => 'approved',
                    ]);
                }
            }
        }
    }
}
