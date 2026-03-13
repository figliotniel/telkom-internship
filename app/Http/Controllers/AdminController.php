<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Dashboard Admin: Melihat ringkasan data.
     */
    public function dashboard()
    {
        // Hitung statistik sederhana
        $totalStudents = User::where('role', 'student')->count();
        $totalMentors = User::where('role', 'mentor')->count();
        $activeInternships = Internship::where('status', 'active')->count();

        // Ambil 15 data magang terbaru untuk ditampilkan di tabel (scrollable)
        $recentInternships = Internship::with(['student.studentProfile', 'mentor', 'division'])
            ->latest()
            ->take(15)
            ->get();

        // Ambil data perpanjangan magang yang pending
        $pendingExtensions = \App\Models\InternshipExtension::with(['internship.student', 'internship.division', 'internship.mentor'])
            ->where('status', 'pending')
            ->get();

        // Count finished interns who need document attention (e.g., status is finished but maybe we can add a flag later, for now just finished)
        $finishedInternsCount = Internship::where('status', 'finished')->count();

        // Hitung growth (data baru bulan ini)
        $studentGrowth = User::where('role', 'student')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $mentorGrowth = User::where('role', 'mentor')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $internshipGrowth = Internship::where('status', 'active')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Count pending applicants (Combined Pending + Onboarding)
        $pendingApplicants = Internship::whereIn('status', ['pending', 'onboarding'])->count();

        return view('admin.dashboard', compact(
            'totalStudents', 'totalMentors', 'activeInternships',
            'recentInternships', 'pendingExtensions',
            'studentGrowth', 'mentorGrowth', 'internshipGrowth',
            'pendingApplicants', 'finishedInternsCount'
        ));
    }

    /**
     * Form Setup Magang: Admin memilih Student, Mentor, dan Divisi.
     */
    public function createInternship()
    {
        // Ambil semua divisi (divisi jumlahnya sedikit, aman di-load semua)
        $divisions = Division::all();

        return view('admin.internships.create', compact('divisions'));
    }

    /**
     * AJAX Search untuk Student (Max 20 results)
     */
    public function searchStudents(Request $request)
    {
        $search = $request->query('q');

        $students = User::where('role', 'student')
            ->whereDoesntHave('internship', function ($q) {
            // Jangan tampilkan mahasiswa yang sudah magang aktif/onboarding
            $q->whereIn('status', ['active', 'onboarding']);
        })
            ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                }
                );
            })
            ->select('id', 'name', 'email')
            ->take(20)
            ->get();

        return response()->json($students);
    }

    /**
     * AJAX Search untuk Mentor (Max 20 results, beserta kuota)
     */
    public function searchMentors(Request $request)
    {
        $search = $request->query('q');

        $mentors = User::where('role', 'mentor')
            ->with(['mentorProfile', 'activeInternships'])
            ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                }
                );
            })
            ->take(20)
            ->get();

        $formattedMentors = $mentors->map(function ($mentor) {
            return [
            'id' => $mentor->id,
            'name' => $mentor->name,
            'email' => $mentor->email,
            'display_text' => $mentor->name
            ];
        });

        return response()->json($formattedMentors);
    }

    /**
     * Simpan Data Magang ke Database.
     */
    public function storeInternship(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'mentor_id' => 'required|exists:users,id',
            'division_id' => 'required|exists:divisions,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Cek apakah mahasiswa ini sudah punya magang aktif? (Validasi tambahan)
        $exists = Internship::where('student_id', $request->student_id)
            ->whereIn('status', ['active', 'onboarding'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Mahasiswa ini sudah memiliki program magang aktif!');
        }


        // Simpan
        Internship::create([
            'student_id' => $request->student_id,
            'mentor_id' => $request->mentor_id,
            'division_id' => $request->division_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active', // Langsung aktif
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Mahasiswa berhasil didaftarkan magang!');
    }
    /**
     * Data User: List semua user.
     */
    public function users(Request $request)
    {
        $role = $request->query('role');
        $studentType = $request->query('student_type'); // New filter parameter
        $search = $request->query('search'); // Search query parameter

        // Base query: Mentors are always shown, but Students (interns) are filtered by active status
        $baseQuery = User::where('role', '!=', 'admin')
            ->where(function ($query) {
            $query->where('role', 'mentor')
                ->orWhere(function ($q) {
                $q->where('role', 'student')
                    ->whereHas('internship', function ($sub) {
                    $sub->where('status', 'active');
                }
                );
            }
            );
        });

        // Global counts for tabs (Before category filters or search)
        $totalAll = $baseQuery->count();
        $totalMentors = (clone $baseQuery)->where('role', 'mentor')->count();
        $totalStudents = (clone $baseQuery)->where('role', 'student')->count();

        // Sub-counts for students (Mahasiswa vs SMK)
        $studentMahasiswaCount = (clone $baseQuery)->where('role', 'student')
            ->whereHas('studentProfile', function ($q) {
            $q->where('student_type', 'mahasiswa')->where(function($sub) {
                $sub->where('education_level', '!=', 'SMK')->orWhereNull('education_level');
            });
        })->count();

        $studentSmkCount = (clone $baseQuery)->where('role', 'student')
            ->whereHas('studentProfile', function ($q) {
            $q->where('student_type', 'siswa')->orWhere('education_level', 'SMK');
        })->count();

        // Main filter and search query
        $users = User::with(['studentProfile', 'mentoredInternships' => function ($query) {
            $query->whereIn('status', ['active', 'onboarding'])->with('student');
        }])
            ->when($search, function ($query, $search) {
            return $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                }
                );
            })
            ->when($role, function ($query, $role) {
            return $query->where('role', $role);
        })
            ->when($role === 'student' && $studentType, function ($query) use ($studentType) {
            return $query->whereHas('studentProfile', function ($q) use ($studentType) {
                    if ($studentType === 'smk') {
                        $q->where('student_type', 'siswa')->orWhere('education_level', 'SMK');
                    }
                    elseif ($studentType === 'mahasiswa') {
                        $q->where('student_type', 'mahasiswa')->where(function($sub) {
                            $sub->where('education_level', '!=', 'SMK')->orWhereNull('education_level');
                        });
                    }
                }
                );
            })
            ->where('role', '!=', 'admin')
            ->where(function ($query) {
            $query->where('role', 'mentor')
                ->orWhere(function ($q) {
                $q->where('role', 'student')
                    ->whereHas('internship', function ($sub) {
                    $sub->where('status', 'active');
                }
                );
            }
            );
        })
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact(
            'users', 'role', 'studentType',
            'totalAll', 'totalMentors', 'totalStudents',
            'studentMahasiswaCount', 'studentSmkCount'
        ));
    }

    /**
     * Form Tambah Mentor Baru
     */
    public function createMentor()
    {
        $divisions = Division::all();
        return view('admin.mentors.create', compact('divisions'));
    }

    /**
     * Simpan Data Mentor Baru
     */
    public function storeMentor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nik' => 'required|string|unique:mentor_profiles',
            'position' => 'required|string|max:255',
        ]);

        // 1. Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mentor',
        ]);

        // 2. Create Mentor Profile
        \App\Models\MentorProfile::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'position' => $request->position,
        ]);

        return redirect()->route('admin.users.index', ['role' => 'mentor'])
            ->with('success', 'Mentor baru berhasil ditambahkan!');
    }

    /**
     * Monitoring Magang: List semua magang aktif.
     */
    public function internships(Request $request)
    {
        $status = $request->query('status', 'pending'); // Default to 'pending' (Applicants)
        $studentType = $request->query('student_type');
        $search = $request->query('search');

        // Counts for Tabs
        // Merge Pending and Onboarding into a single count
        $onboardingCount = Internship::where('status', 'onboarding')->count();
        $pendingCount = Internship::where('status', 'pending')->count() + $onboardingCount;
        $activeCount = Internship::where('status', 'active')->count();
        $finishedCount = Internship::where('status', 'finished')->count();

        // Count Pending Extensions
        $extensionCount = \App\Models\InternshipExtension::where('status', 'pending')->count();

        // Sub-counts for current tab's students (Mahasiswa vs SMK vs Semua)
        $baseInternshipQuery = Internship::query();
        if ($status === 'extension') {
            $baseInternshipQuery->whereHas('extensions', function ($q) {
                $q->where('status', 'pending');
            });
        } elseif ($status === 'pending') {
            $baseInternshipQuery->whereIn('status', ['pending', 'onboarding']);
        } else {
            $baseInternshipQuery->where('status', $status);
        }

        $totalInterns = (clone $baseInternshipQuery)->count();
        $internMahasiswaCount = (clone $baseInternshipQuery)->whereHas('student.studentProfile', function ($q) {
            $q->where('student_type', 'mahasiswa')->where(function($sub) {
                $sub->where('education_level', '!=', 'SMK')->orWhereNull('education_level');
            });
        })->count();
        $internSmkCount = (clone $baseInternshipQuery)->whereHas('student.studentProfile', function ($q) {
            $q->where('student_type', 'siswa')->orWhere('education_level', 'SMK');
        })->count();

        // Redirect if trying to view extensions but none exist
        if ($status === 'extension' && $extensionCount === 0) {
            return redirect()->route('admin.internships.index', ['status' => 'pending']);
        }

        // Filter Logic
        if ($status === 'extension') {
            $internships = Internship::whereHas('extensions', function ($q) {
                $q->where('status', 'pending');
            })
                ->when($studentType, function ($query) use ($studentType) {
                return $query->whereHas('student.studentProfile', function ($q) use ($studentType) {
                        if ($studentType === 'smk') {
                            $q->where('student_type', 'siswa')->orWhere('education_level', 'SMK');
                        }
                        elseif ($studentType === 'mahasiswa') {
                            $q->where('student_type', 'mahasiswa')->where(function($sub) {
                                $sub->where('education_level', '!=', 'SMK')->orWhereNull('education_level');
                            });
                        }
                    }
                    );
                })
                ->with(['student.studentProfile', 'mentor', 'division', 'extensions' => function ($q) {
                $q->where('status', 'pending');
            }])
                ->when($search, function ($query, $search) {
                    return $query->whereHas('student', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                          ->orWhere('email', 'LIKE', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(10)
                ->appends(['status' => $status, 'student_type' => $studentType, 'search' => $search]);
        }
        else {
            $internships = Internship::with(['student.studentProfile', 'mentor', 'division'])
                ->when($status === 'pending', function ($query) {
                return $query->whereIn('status', ['pending', 'onboarding']);
            }, function ($query) use ($status) {
                return $query->where('status', $status);
            })
                ->when($studentType, function ($query) use ($studentType) {
                return $query->whereHas('student.studentProfile', function ($q) use ($studentType) {
                        if ($studentType === 'smk') {
                            $q->where('student_type', 'siswa')->orWhere('education_level', 'SMK');
                        }
                        elseif ($studentType === 'mahasiswa') {
                            $q->where('student_type', 'mahasiswa')->where(function($sub) {
                                $sub->where('education_level', '!=', 'SMK')->orWhereNull('education_level');
                            });
                        }
                    }
                    );
                })
                ->when($search, function ($query, $search) {
                    return $query->whereHas('student', function ($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                          ->orWhere('email', 'LIKE', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(10)
                ->appends(['status' => $status, 'student_type' => $studentType, 'search' => $search]);
        }

        // Pass Divisions and Mentors for Dropdowns in Review Modal
        $divisions = Division::all();
        $mentors = User::where('role', 'mentor')->get();

        return view('admin.internships.index', compact(
            'internships', 'status', 'studentType', 'search', 
            'pendingCount', 'onboardingCount', 'activeCount', 'finishedCount', 'extensionCount', 
            'divisions', 'mentors', 'totalInterns', 'internMahasiswaCount', 'internSmkCount'
        ));
    }

    /**
     * Approve Internship (Pending -> Onboarding)
     * Admin uploads Surprise Jawaban & Pakta Integrity Template
     */
    public function approveInternship(Request $request, $id)
    {
        $internship = Internship::findOrFail($id);

        if ($internship->status !== 'pending') {
            return back()->with('error', 'Status magang tidak valid untuk disetujui.');
        }

        $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'mentor_id' => 'required|exists:users,id',
        ]);


        // Hardcoded Link (per user request)
        $paktaLink = 'https://docs.google.com/document/d/1MYswMj78AfqPH9yBIeH8U9VBA5jDaRguTzwQX-9ARe8/edit?tab=t.0';

        // Store Google Docs Link
        $internship->documents()->create([
            'name' => 'Link Template Pakta Integritas',
            'type' => 'pakta_integritas',
            'file_path' => $paktaLink, // Storing URL directly
            'is_verified' => true
        ]);

        $internship->update([
            'status' => 'onboarding',
            'division_id' => $request->division_id,
            'mentor_id' => $request->mentor_id,
        ]);

        try {
            // Optional: Send Notification to Student (Queued)
            if ($internship->student && $internship->student->email) {
                \Illuminate\Support\Facades\Mail::to($internship->student->email)->queue(new \App\Mail\InternshipApproved($internship));
            }
        }
        catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send InternshipApproved email: ' . $e->getMessage());
        }

        return redirect()->route('admin.internships.index', ['status' => 'pending'])
            ->with('success', 'Pengajuan diterima! Mahasiswa kini statusnya Pending (Melengkapi Berkas).');
    }

    /**
     * Reject Internship (Pending -> Rejected)
     */
    public function rejectInternship(Request $request, $id)
    {
        $internship = Internship::findOrFail($id);

        if ($internship->status !== 'pending') {
            return back()->with('error', 'Status magang tidak valid untuk ditolak.');
        }

        // Update status to rejected
        $internship->update(['status' => 'rejected']);

        try {
            // Send Rejection Email (Queued)
            if ($internship->student && $internship->student->email) {
                \Illuminate\Support\Facades\Mail::to($internship->student->email)->queue(new \App\Mail\InternshipRejected($internship));
            }
        }
        catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send InternshipRejected email: ' . $e->getMessage());
        }

        return redirect()->route('admin.internships.index', ['status' => 'pending'])
            ->with('success', 'Pengajuan magang ditolak. Data akan dihapus otomatis dalam 3 hari.');
    }

    /**
     * Activate Internship (Onboarding -> Active)
     */
    public function activateInternship(Request $request, $id)
    {
        $internship = Internship::with('documents')->findOrFail($id);

        if ($internship->status !== 'onboarding') {
            return back()->with('error', 'Status magang tidak valid untuk diaktivasi.');
        }

        // Check if student has uploaded signed pakta integritas
        $hasSignedPact = $internship->documents()->where('type', 'pakta_integritas_signed')->exists();

        if (!$hasSignedPact) {
            return back()->with('error', 'Mahasiswa belum mengupload Pakta Integritas yang sudah ditandatangani.');
        }

        $request->validate([
            'induction_date' => 'required|date',
            'induction_time' => 'required',
        ]);

        $internship->update([
            'status' => 'active',
        ]);

        $inductionData = [
            'date' => $request->induction_date,
            'time' => $request->induction_time,
            'location' => 'Ruang Kompeten Unit Shared Service & General Support Witel Semarang Jateng Utara Lantai 2 GMP Pahlawan, Jl. Pahlawan No. 10, Kota Semarang',
            'activity' => 'Induksi Peserta Magang & Pengambilan ID Card',
        ];

        $message = 'Program magang berhasil diaktifkan. Mahasiswa kini berstatus Aktif dengan Mentor & Divisi terpilih.';

        try {
            // Trigger Email Notification (Queued)
            if ($internship->student && $internship->student->email) {
                \Illuminate\Support\Facades\Mail::to($internship->student->email)->queue(new \App\Mail\InternshipActive($internship, $inductionData));
                $message .= ' Email notifikasi telah antre dikirim.';
            }
        }
        catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send InternshipActive email: ' . $e->getMessage());
            $message .= ' Namun email gagal dikirim (Cek konfigurasi SMTP Anda).';
        }

        return redirect()->route('admin.internships.index', ['status' => 'pending'])
            ->with('success', $message);
    }

    /**
     * Complete Internship (Upload Certificate & Assessment)
     */
    public function completeInternship(Request $request, $id)
    {
        $internship = Internship::with('student.studentProfile')->findOrFail($id);

        $request->validate([
            'dokumen_kelulusan' => 'required|array|min:1',
            'dokumen_kelulusan.*' => 'file|mimes:pdf|max:5120', // Increased to 5MB per file
        ]);

        // Optional: Remove old completion documents if re-uploading
        $internship->documents()->whereIn('type', ['sertifikat_kelulusan', 'laporan_penilaian_pkl', 'dokumen_kelulusan'])->delete();

        if ($request->hasFile('dokumen_kelulusan')) {
            foreach ($request->file('dokumen_kelulusan') as $file) {
                $path = $file->store('documents/admin', 'public');
                $originalName = $file->getClientOriginalName();

                $internship->documents()->create([
                    'type' => 'dokumen_kelulusan',
                    'name' => $originalName,
                    'file_path' => $path,
                    'is_verified' => true
                ]);
            }
        }

        try {
            if ($internship->student && $internship->student->email) {
                \Illuminate\Support\Facades\Mail::to($internship->student->email)->queue(new \App\Mail\InternshipFinished($internship));
            }
        }
        catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send InternshipFinished email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Dokumen kelulusan berhasil dikirim!');
    }




    /**
     * Detail Monitoring Magang (Read Only)
     */
    public function showInternship($id)
    {
        $internship = Internship::with(['student', 'division', 'documents', 'mentor'])->findOrFail($id);
        $mentors = User::where('role', 'mentor')->get();
        $divisions = Division::all();
        return view('admin.internships.show', compact('internship', 'mentors', 'divisions'));
    }

    /**
     * Detail Evaluasi Magang
     */
    public function showEvaluation($id)
    {
        $evaluation = \App\Models\Evaluation::with(['internship.student', 'internship.mentor', 'internship.division'])->findOrFail($id);
        return view('admin.evaluations.show', compact('evaluation'));
    }

    /**
     * Approve Extension Request
     */
    public function approveExtension($id)
    {
        $extension = \App\Models\InternshipExtension::findOrFail($id);

        // Update extension status
        $extension->update([
            'status' => 'approved'
        ]);

        // Update internship end date
        $internship = $extension->internship;
        $internship->update([
            'end_date' => $extension->new_end_date
        ]);

        return back()->with('success', 'Pengajuan perpanjangan berhasil disetujui.');
    }

    /**
     * Reject Extension Request
     */
    public function rejectExtension(Request $request, $id)
    {
        $extension = \App\Models\InternshipExtension::findOrFail($id);

        $extension->update([
            'status' => 'rejected',
            'reason' => $request->reason // Optional reason
        ]);

        return back()->with('success', 'Pengajuan perpanjangan berhasil ditolak.');
    }

    /**
     * Override Attendance (Manual Edit)
     */
    public function overrideAttendance(Request $request)
    {
        $request->validate([
            'internship_id' => 'required|exists:internships,id',
            'date' => 'required|date',
            'status' => 'required|in:present,sick,permit,alpha',
            'check_in_time' => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
            'note' => 'nullable|string'
        ]);

        \App\Models\Attendance::updateOrCreate(
        [
            'internship_id' => $request->internship_id,
            'date' => $request->date,
        ],
        [
            'status' => $request->status,
            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,
            'note' => $request->note
        ]
        );

        return back()->with('success', 'Kehadiran berhasil diedit.');
    }
}