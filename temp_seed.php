<?php
foreach (\App\Models\Internship::where('status', 'active')->get() as $internship) {
    \App\Models\Attendance::create([
        'internship_id' => $internship->id,
        'date' => now()->toDateString(),
        'check_in_time' => '08:00:00',
        'check_out_time' => '17:00:00',
        'status' => 'present'
    ]);
    \App\Models\Attendance::create([
        'internship_id' => $internship->id,
        'date' => now()->subDays(1)->toDateString(),
        'status' => 'permit',
        'permit_type' => 'temporary',
        'note' => 'Izin ke kampus sebentar ambil ijazah',
        'permit_start_time' => '10:00:00',
        'permit_end_time' => '12:00:00'
    ]);
    \App\Models\Attendance::create([
        'internship_id' => $internship->id,
        'date' => now()->subDays(2)->toDateString(),
        'check_in_time' => '08:15:00',
        'check_out_time' => '17:00:00',
        'status' => 'present'
    ]);
    \App\Models\Attendance::create([
        'internship_id' => $internship->id,
        'date' => now()->subDays(3)->toDateString(),
        'status' => 'permit',
        'permit_type' => 'full',
        'note' => 'Izin sakit typus'
    ]);
}
echo 'Seeded successfully.';

