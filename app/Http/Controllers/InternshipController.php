<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;
use App\Models\Internship;
use Illuminate\Support\Facades\Auth;

class InternshipController extends Controller
{
    public function create()
    {
        // Cek data magang, send ke dashboard 
        if (Internship::where('student_id', Auth::id())->exists()) {
            return redirect()->route('dashboard');
        }

        $divisions = Division::all();
        return view('internships.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'division_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            // New Fields
            'education_level' => 'required|in:D3,D4,S1',
            'date_of_birth' => 'required|date',
            'location' => 'required|string',
            'pact_integrity' => 'required|image|max:2048', // Photo
        ]);

        // Upload Pakta Integritas
        $pactPath = null;
        if ($request->hasFile('pact_integrity')) {
            $pactPath = $request->file('pact_integrity')->store('pact_integrity', 'public');
        }

        // Update Student Profile
        $studentProfile = \App\Models\StudentProfile::where('user_id', Auth::id())->first();
        if ($studentProfile) {
            $studentProfile->update([
                'education_level' => $request->education_level,
                'date_of_birth' => $request->date_of_birth,
            ]);
        } else {
             // Create if not exists (should already exist from registration, but for safety)
             \App\Models\StudentProfile::create([
                'user_id' => Auth::id(),
                'education_level' => $request->education_level,
                'date_of_birth' => $request->date_of_birth,
                'nim' => 'TEMP-' . Auth::id(), // Temporary placeholder if creating fresh
                'university' => 'Unknown',
                'major' => 'Unknown',
             ]);
        }

        Internship::create([
            'student_id' => Auth::id(),
            'division_id' => $request->division_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'location' => $request->location,
            'pact_integrity' => $pactPath,
            'status' => 'onboarding', // Reset to onboarding for approval process
        ]);

        return redirect()->route('dashboard')->with('success', 'Selamat! Data magang berhasil dibuat.');
    }
}