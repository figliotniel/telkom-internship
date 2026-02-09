<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Internship;
use carbon\carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // Fungsi CHECK-IN (Datang)
    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship || $internship->status !== 'active') {
             return back()->with('error', 'Status magang belum aktif.');
        }

        // Cek apakah hari ini sudah absen?
        $existingAttendance = Attendance::where('internship_id', $internship->id)
            ->whereDate('date', Carbon::today())
            ->first();

        if ($existingAttendance) {
            return back()->with('error', 'Kamu sudah check-in hari ini!');
        }

        Attendance::create([
            'internship_id' => $internship->id,
            'date' => Carbon::today(),
            'check_in_time' => Carbon::now()->format('H:i:s'),
            'check_in_lat' => $request->latitude,
            'check_in_long' => $request->longitude,
            'status' => 'present',
        ]);

        return back()->with('success', 'Berhasil Check-in! Semangat kerjanya.');
    }

    // Fungsi CHECK-OUT (Pulang)
    public function checkOut(Request $request)
    {
        $internship = Internship::where('student_id', Auth::id())->first();

        // Cari absen hari ini yang belum di-checkout
        $attendance = Attendance::where('internship_id', $internship->id)
            ->whereDate('date', Carbon::today())
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Kamu belum check-in hari ini!');
        }

        $attendance->update([
            'check_out_time' => Carbon::now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Berhasil Check-out! Hati-hati di jalan.');
    }

    // Fungsi IZIN (Permission)
    public function permission(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'permit_type' => 'required|in:full,temporary',
            'note' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'start_time' => 'nullable|required_if:permit_type,temporary|date_format:H:i',
            'end_time' => 'nullable|required_if:permit_type,temporary|date_format:H:i|after:start_time',
        ]);

        // Validation: No attachment required for any permit type
        // if ($request->permit_type === 'full' && !$request->hasFile('attachment')) {
        //    return back()->with('error', 'Izin Penuh (Full Day) wajib melampirkan bukti/surat keterangan.');
        // }

        $internship = Internship::where('student_id', Auth::id())->first();

        if (!$internship || $internship->status !== 'active') {
             return back()->with('error', 'Status magang tidak aktif.');
        }

        // Check if attendance exists for date
        $exists = Attendance::where('internship_id', $internship->id)
            ->whereDate('date', $request->date)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Absensi/Izin untuk tanggal ini sudah ada.');
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('permissions', 'public');
        }

        Attendance::create([
            'internship_id' => $internship->id,
            'date' => $request->date,
            'status' => 'permit', // Set as permit
            'permit_type' => $request->permit_type,
            'permit_start_time' => $request->permit_type === 'temporary' ? $request->start_time : null,
            'permit_end_time' => $request->permit_type === 'temporary' ? $request->end_time : null,
            'note' => $request->note,
            'attachment' => $attachmentPath,
        ]);

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
}
