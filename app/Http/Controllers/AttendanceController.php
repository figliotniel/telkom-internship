<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Internship;
use App\Http\Requests\CheckInRequest;
use App\Http\Requests\PermissionRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Koordinat Kantor Telkom Pahlawan Semarang
    private const OFFICE_LAT = -6.9941902;
    private const OFFICE_LONG = 110.4216824;
    private const ALLOWED_RADIUS = 150; // dalam meter

    // Fungsi CHECK-IN (Datang)
    public function checkIn(CheckInRequest $request)
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return back()->with('error', 'Data magang tidak ditemukan.');
        }

        if ($internship->status === 'finished') {
            return redirect()->back()->with('error', 'Masa magang Anda telah selesai. Anda tidak dapat lagi mengisi presensi atau logbook.');
        }

        if ($internship->status !== 'active') {
            return back()->with('error', 'Status magang Anda belum aktif.');
        }

        // Cek apakah hari ini sudah absen? (Logic Reset jam 7 pagi)
        $dateCheck = Carbon::now()->hour < 7 ?Carbon::yesterday() : Carbon::today();

        $existingAttendance = Attendance::where('internship_id', $internship->id)
            ->whereDate('date', $dateCheck)
            ->first();

        if ($existingAttendance) {
            // Logic Izin Sementara: Pekerja dapat check-in kapan saja setelah kembali
            if ($existingAttendance->status === 'pending' && $existingAttendance->permit_type === 'temporary') {

                // Update record yang sudah ada, jangan buat baru
                $existingAttendance->update([
                    'check_in_time' => Carbon::now()->format('H:i:s'),
                    'check_in_lat' => $request->latitude,
                    'check_in_long' => $request->longitude,
                    // Status menjadi present setelah check-in
                    'status' => 'present',
                ]);

                return back()->with('success', 'Berhasil Check-in setelah izin sementara!');
            }

            return back()->with('error', 'Kamu sudah check-in hari ini!');
        }

        // Time Validation: Start from 07:00
        $now = Carbon::now();
        $startCheckIn = $now->copy()->hour(7)->minute(0)->second(0);
        $onTimeLimit = $now->copy()->hour(9)->minute(0)->second(0);
        $lateLimit = $now->copy()->hour(17)->minute(0)->second(0); // Cannot check-in after check-out starts

        if ($now->lt($startCheckIn)) {
            return back()->with('error', 'Check-in hanya dapat dilakukan mulai pukul 07:00 WIB.');
        }

        if ($now->gt($lateLimit)) {
            return back()->with('error', 'Batas waktu check-in telah berakhir (17:00 WIB).');
        }

        // Determine status based on time
        $status = $now->lte($onTimeLimit) ? 'present' : 'late';

        // 3. Geofencing Validation (Backend Security)
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            self::OFFICE_LAT,
            self::OFFICE_LONG
        );

        if ($distance > self::ALLOWED_RADIUS) {
            return back()->with('error', 'Presensi gagal! Anda terdeteksi berada di luar radius kantor (' . round($distance) . 'm dari titik kantor).');
        }

        try {
            Attendance::create([
                'internship_id' => $internship->id,
                'date' => $dateCheck,
                'check_in_time' => Carbon::now()->format('H:i:s'),
                'check_in_lat' => $request->latitude,
                'check_in_long' => $request->longitude,
                'status' => $status,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return back()->with('error', 'Kamu sudah check-in hari ini!');
            }
            throw $e;
        }

        $msg = $status === 'late' ? 'Berhasil Check-in! Anda tercatat telat hari ini.' : 'Berhasil Check-in! Semangat kerjanya.';
        return back()->with('success', $msg);
    }

    // Fungsi CHECK-OUT (Pulang)
    public function checkOut(Request $request)
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if ($internship && $internship->status === 'finished') {
            return redirect()->back()->with('error', 'Masa magang Anda telah selesai. Anda tidak dapat lagi mengisi presensi atau logbook.');
        }

        // Cari absen hari ini yang belum di-checkout (Logic Reset 7 Pagi)
        $dateCheck = Carbon::now()->hour < 7 ?Carbon::yesterday() : Carbon::today();

        $attendance = Attendance::where('internship_id', $internship->id)
            ->whereDate('date', $dateCheck)
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Kamu belum check-in hari ini!');
        }

        // Time Validation: 17:00 - 19:00
        $now = Carbon::now();
        $startCheckOut = $now->copy()->hour(17)->minute(0)->second(0);
        $endCheckOut = $now->copy()->hour(23)->minute(59)->second(59);

        if (!$now->between($startCheckOut, $endCheckOut)) {
            return back()->with('error', 'Check-out hanya dapat dilakukan setelah pukul 17:00 WIB.');
        }

        // Silent Block: Jika izin full day, jangan lakukan apa-apa
        if ($attendance->status === 'permit' && $attendance->permit_type === 'full') {
            return back();
        }

        $attendance->update([
            'check_out_time' => Carbon::now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Berhasil Check-out! Hati-hati di jalan.');
    }

    // Fungsi IZIN (Permission)
    public function permission(PermissionRequest $request)
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return back()->with('error', 'Data magang tidak ditemukan.');
        }

        if ($internship->status === 'finished') {
            return redirect()->back()->with('error', 'Masa magang Anda telah selesai. Anda tidak dapat lagi mengisi presensi atau logbook.');
        }

        if ($internship->status !== 'active') {
            return back()->with('error', 'Status magang Anda belum aktif.');
        }

        // Parse date. If permit_type is 'full', date can be "YYYY-MM-DD" or "YYYY-MM-DD to YYYY-MM-DD"
        $datesToProcess = [];
        if ($request->permit_type === 'full') {
            $dateParts = explode(' to ', $request->date);
            $startDate = \Carbon\Carbon::parse($dateParts[0]);
            $endDate = isset($dateParts[1]) ?\Carbon\Carbon::parse($dateParts[1]) : $startDate->copy();

            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                $datesToProcess[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }
        }
        else {
            $datesToProcess[] = \Carbon\Carbon::parse($request->date)->format('Y-m-d');
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('permissions', 'public');
        }

        $successCount = 0;
        $errorDates = [];

        foreach ($datesToProcess as $processDate) {
            $existingAttendance = Attendance::where('internship_id', $internship->id)
                ->whereDate('date', $processDate)
                ->first();

            if ($existingAttendance) {
                // Allow update ONLY if permit_type is 'temporary' (Half-day)
                if ($request->permit_type === 'temporary') {
                    // Check if they ALREADY have a temporary permit submitted today
                    if ($existingAttendance->permit_type === 'temporary' || $existingAttendance->permit_start_time !== null) {
                        $errorDates[] = $processDate;
                        continue;
                    }

                    // Update the existing attendance (could be already 'present') 
                    // with the temporary permit details. Don't override status if they are already present.
                    $existingAttendance->update([
                        'permit_type' => 'temporary',
                        'permit_start_time' => $request->start_time,
                        'permit_end_time' => $request->end_time,
                        'note' => $request->note,
                        'attachment' => $attachmentPath ?? $existingAttendance->attachment,
                    ]);
                    $successCount++;
                }
                else {
                    // It's a full day permit, but attendance already exists. Reject to prevent overriding a check-in.
                    $errorDates[] = $processDate;
                }
            }
            else {
                // No attendance exists yet. Create a new one.
                try {
                    Attendance::create([
                        'internship_id' => $internship->id,
                        'date' => $processDate,
                        'status' => $request->permit_type === 'full' ? 'permit' : 'pending', // Temporary permit shouldn't mean they took a full day off.
                        'permit_type' => $request->permit_type,
                        'permit_start_time' => $request->permit_type === 'temporary' ? $request->start_time : null,
                        'permit_end_time' => $request->permit_type === 'temporary' ? $request->end_time : null,
                        'note' => $request->note,
                        'attachment' => $attachmentPath,
                    ]);
                    $successCount++;
                } catch (\Illuminate\Database\QueryException $e) {
                    if ($e->getCode() === '23000') {
                        $errorDates[] = $processDate;
                        continue;
                    }
                    throw $e;
                }
            }
        }

        if (count($errorDates) > 0 && $successCount === 0) {
            return back()->with('error', 'Absensi/Izin untuk tanggal yang dipilih sudah ada.');
        }

        if ($successCount > 0) {
            // Send email Notification to Mentor
            $durationText = '';
            if ($request->permit_type === 'full') {
                if (count($datesToProcess) > 1) {
                    $durationText = \Carbon\Carbon::parse($datesToProcess[0])->translatedFormat('d F Y') . ' s/d ' . \Carbon\Carbon::parse(end($datesToProcess))->translatedFormat('d F Y') . ' (' . count($datesToProcess) . ' Hari)';
                }
                else {
                    $durationText = \Carbon\Carbon::parse($datesToProcess[0])->translatedFormat('d F Y') . ' (1 Hari)';
                }
            }
            else {
                $durationText = \Carbon\Carbon::parse($datesToProcess[0])->translatedFormat('d F Y') . ', ' . $request->start_time . ' - ' . $request->end_time;
            }

            $permissionData = [
                'permit_type' => $request->permit_type,
                'duration_text' => $durationText,
                'reason' => $request->note,
            ];

            try {
                $mentorEmail = $internship->mentor->email ?? null;
                if ($mentorEmail) {
                    \Illuminate\Support\Facades\Mail::to($mentorEmail)->send(new \App\Mail\InternPermissionNotification($permissionData, Auth::user()));
                }
            }
            catch (\Exception $e) {
                // Log the error silently, DO NOT break the application flow.
                \Illuminate\Support\Facades\Log::error('Failed to send permission email: ' . $e->getMessage());
            }
        }

        if (count($errorDates) > 0 && $successCount > 0) {
            return back()->with('success', "Sebagian pengajuan izin dikirim ($successCount hari). Beberapa hari (" . count($errorDates) . " hari) tidak diproses karena sudah ada absensi.");
        }

        return back()->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    // Fungsi Laporan Bulanan (Monthly Report)
    public function downloadReport(Request $request)
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship) {
            return redirect()->route('dashboard');
        }

        $month = $request->month ?? Carbon::now()->month;
        $year = $request->year ?? Carbon::now()->year;

        // Get attendances
        $attendances = Attendance::where('internship_id', $internship->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();

        // Get logbooks
        $logbooks = \App\Models\DailyLogbook::where('internship_id', $internship->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();

        // If no view exists yet, we can create one.
        // For now, assume we will create 'reports.monthly'
        return view('reports.monthly', compact('internship', 'attendances', 'logbooks', 'month', 'year'));
    }

    /**
     * Menghitung jarak antara dua titik koordinat (Haversine Formula)
     * Output dalam meter.
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Radius bumi dalam meter

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
