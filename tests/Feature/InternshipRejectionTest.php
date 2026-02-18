<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Internship;
use App\Models\Division;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Layout;

class InternshipRejectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_rejecting_internship_deletes_all_data()
    {
        // 1. Create Admin
        $admin = User::firstOrCreate(
        ['email' => 'admin_test@example.com'],
        ['name' => 'Admin Test', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        // 2. Create Student
        $student = User::create([
            'name' => 'Reject Candidate',
            'email' => 'reject_candidate@example.com',
            'password' => bcrypt('password'),
            'role' => 'student',
        ]);

        $student->studentProfile()->create(['nim' => '12345', 'university' => 'Test Uni', 'major' => 'IT']);

        // 3. Create Internship
        $division = Division::first() ?? Division::create(['name' => 'IT Division']);
        $internship = Internship::create([
            'student_id' => $student->id,
            'division_id' => $division->id,
            'status' => 'pending',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
        ]);

        // 4. Create Dummy Document
        Storage::fake('public');
        $file = \Illuminate\Http\UploadedFile::fake()->create('cv.pdf', 100);
        $path = $file->store('documents', 'public');

        $internship->documents()->create([
            'name' => 'CV',
            'file_path' => $path,
            'type' => 'cv',
            'is_verified' => false
        ]);

        // 5. Act: Reject
        $response = $this->actingAs($admin)
            ->patch(route('admin.internships.reject', $internship->id));

        // 6. Assert
        $response->assertRedirect(route('admin.internships.index', ['status' => 'pending']));

        // Assert Deleted from DB
        $this->assertDatabaseMissing('internships', ['id' => $internship->id]);
        $this->assertDatabaseMissing('users', ['id' => $student->id]);
        $this->assertDatabaseMissing('documents', ['file_path' => $path]);

        // Assert File Deleted
        Storage::disk('public')->assertMissing($path);

        // Cleanup Admin (Optional)
        $admin->delete();
    }
}
