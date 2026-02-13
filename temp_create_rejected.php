<?php
try {
    $student = App\Models\User::firstOrCreate(
    ['email' => 'reject@test.com'],
    ['name' => 'RejectMe', 'password' => 'bcrypt("password")', 'role' => 'student']
    );

    if (!$student->studentProfile) {
        $student->studentProfile()->create(['nim' => '999', 'university' => 'Test', 'major' => 'Test']);
    }

    if ($student->internship) {
        $student->internship->delete();
    }

    $internship = $student->internship()->create(['status' => 'rejected', 'division_id' => 1]);
    $internship->updated_at = now()->subDays(5);
    $internship->save();

    echo "Prepared User ID: " . $student->id;
}
catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
