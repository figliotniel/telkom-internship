<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Division;
use App\Models\Internship;
use App\Services\InternshipService;

class AdminInternshipActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_internship()
    {
        // Mock InternshipService to avoid sending actual emails or writing to DB inside the service during controller testing
        $this->mock(InternshipService::class, function ($mock) {
            $mock->shouldReceive('approve')->once();
        });

        // Setup test data
        // We use create and directly insert since we might not have factories set up completely
        $admin = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        
        $mentor = User::create([
            'name' => 'Mentor Test',
            'email' => 'mentor@test.com',
            'password' => bcrypt('password'),
            'role' => 'mentor'
        ]);

        $student = User::create([
            'name' => 'Student Test',
            'email' => 'student@test.com',
            'password' => bcrypt('password'),
            'role' => 'student'
        ]);
        
        $division = Division::create([
            'code' => 'IT',
            'name' => 'Information Technology',
            'mentor_id' => $mentor->id
        ]);

        $internship = Internship::create([
            'student_id' => $student->id,
            'mentor_id' => $mentor->id,
            'division_id' => $division->id,
            'start_date' => '2026-06-01',
            'end_date' => '2026-08-31',
            'status' => 'pending'
        ]);

        // Act
        $response = $this->actingAs($admin)->patch(route('admin.internships.approve', $internship->id), [
            'division_id' => $division->id
        ]);

        // Assert
        $response->assertRedirect(route('admin.internships.index', ['status' => 'pending']));
        $response->assertSessionHas('success');
    }
}
