<?php
$emails = [
    'mentor_smk1@telkom.co.id', 'mentor_smk2@telkom.co.id', 'mentor_smk3@telkom.co.id',
    'siswa_smk1@gmail.com', 'siswa_smk2@gmail.com', 'siswa_smk3@gmail.com',
    'siswa_smk4@gmail.com', 'siswa_smk5@gmail.com', 'siswa_smk6@gmail.com'
];

$users = App\Models\User::whereIn('email', $emails)->get();
foreach ($users as $user) {
    if ($user->role === 'student') {
        $internships = App\Models\Internship::where('student_id', $user->id)->get();
        foreach ($internships as $i) {
            App\Models\Attendance::where('internship_id', $i->id)->delete();
            App\Models\DailyLogbook::where('internship_id', $i->id)->delete();
            $i->delete();
        }
        App\Models\StudentProfile::where('user_id', $user->id)->delete();
    }
    else {
        App\Models\MentorProfile::where('user_id', $user->id)->delete();
    }
    $user->delete();
}
echo "Cleanup completed successfully.\n";
