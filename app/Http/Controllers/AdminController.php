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

        // Ambil 20 data magang terbaru untuk ditampilkan di tabel (scrollable)
        $recentInternships = Internship::with(['student.studentProfile', 'mentor', 'division'])
            ->latest()
            ->take(20)
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

        // Ambil data mentor untuk ditampilkan di modal "Tambah Mentor"
        $mentorsList = User::where('role', 'mentor')->with('mentorProfile')->latest()->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalMentors',
            'activeInternships',
            'recentInternships',
            'pendingExtensions',
            'studentGrowth',
            'mentorGrowth',
            'internshipGrowth',
            'pendingApplicants',
            'finishedInternsCount',
            'mentorsList'
        ));
    }

    /**
     * Master Data Divisi: List.
     */
    public function divisions()
    {
        $divisions = Division::withCount([
            'internships' => function ($query) {
                $query->whereIn('status', ['active', 'pending', 'onboarding']);
            }
        ])->get();

        // Mentors for assigning to divisions
        $mentors = User::where('role', 'mentor')->get();

        return view('admin.divisions.index', compact('divisions', 'mentors'));
    }

    public function showDivision($id)
    {
        $division = Division::with([
            'internships' => function ($query) {
                $query->with(['student.studentProfile', 'mentor'])->latest();
            }
        ])->findOrFail($id);

        $mentors = User::where('role', 'mentor')->get();

        return view('admin.divisions.show', compact('division', 'mentors'));
    }

    public function storeDivision(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:divisions,code',
            'name' => 'required|string|max:255',
            'mentor_id' => 'nullable|exists:users,id',
        ]);

        Division::create([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'mentor_id' => $request->mentor_id,
        ]);

        return back()->with('success', 'Data Divisi berhasil ditambahkan.');
    }

    public function updateDivision(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:divisions,code,' . $id,
            'name' => 'required|string|max:255',
            'mentor_id' => 'nullable|exists:users,id',
        ]);

        $division = Division::findOrFail($id);
        $old_mentor_id = $division->mentor_id;

        $division->update([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'mentor_id' => $request->mentor_id,
        ]);

        // Sinkronisasi otomatis: Jika mentor berubah, update mentor_id untuk intern yang aktif di divisi ini
        if ($old_mentor_id != $request->mentor_id) {
            \App\Models\Internship::where('division_id', $division->id)
                ->whereIn('status', ['active', 'onboarding'])
                ->update(['mentor_id' => $request->mentor_id]);
        }

        return back()->with('success', 'Data Divisi berhasil diperbarui.');
    }

    public function destroyDivision($id)
    {
        $division = Division::findOrFail($id);

        // Cek apakah ada intern aktif/pending di divisi ini
        $hasInterns = Internship::where('division_id', $id)->exists();

        if ($hasInterns) {
            // Jika Anda ingin mengizinkan hapus dengan memutus relasi (set null), 
            // pastikan kolom division_id di tabel internships bersifat nullable.
            // Untuk saat ini, kita berikan pesan yang lebih informatif.
            return back()->with('error', 'Gagal menghapus! Masih ada data intern yang terhubung dengan divisi ' . $division->name . '. Pindahkan data intern terlebih dahulu.');
        }

        $division->delete();
        return redirect()->route('admin.divisions.index')->with('success', 'Data Divisi ' . $division->name . ' berhasil dihapus.');
    }

    /**
     * Form Setup Magang: Admin memilih Student, Mentor, dan Divisi.
     */
    public function createInternship()
    {
        // Ambil semua divisi beserta kepala mentornya
        $divisions = Division::with('mentor')->get();

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
                $query->where(
                    function ($q) use ($search) {
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
                $query->where(
                    function ($q) use ($search) {
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

        // Ambil ID mentor dari kepala divisi yang dipilih
        $division = Division::findOrFail($request->division_id);

        if (!$division->mentor_id) {
            return back()->with('error', 'Divisi yang dipilih belum memiliki Kepala Mentor. Silakan assign mentor ke divisi ini terlebih dahulu di Master Divisi.');
        }

        // Simpan
        Internship::create([
            'student_id' => $request->student_id,
            'mentor_id' => $division->mentor_id,
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
        $studentType = $request->query('student_type');
        $search = $request->query('search');
        $divisionId = $request->query('division_id');
        $sort = $request->query('sort', 'latest');

        // All Divisions for Filter
        $divisions = \App\Models\Division::orderBy('name')->get();

        // Base query: Mentors and Students with active status
        $baseQuery = User::where('role', '!=', 'admin')
            ->where(function ($query) {
                $query->where('role', 'mentor')
                    ->orWhere(function ($q) {
                        $q->where('role', 'student')
                            ->whereHas('internship', function ($sub) {
                                $sub->where('status', 'active');
                            });
                    });
            });

        // Global counts for tabs (Before category filters or search)
        $totalAll = $baseQuery->count();
        $totalMentors = (clone $baseQuery)->where('role', 'mentor')->count();
        $totalStudents = (clone $baseQuery)->where('role', 'student')->count();

        // Sub-counts for students (Mahasiswa vs SMK)
        $studentMahasiswaCount = (clone $baseQuery)->where('role', 'student')
            ->whereHas('studentProfile', function ($q) {
                $q->where('student_type', 'mahasiswa')->where(function ($sub) {
                    $sub->where('education_level', '!=', 'SMK')->orWhereNull('education_level');
                });
            })->count();

        $studentSmkCount = (clone $baseQuery)->where('role', 'student')
            ->whereHas('studentProfile', function ($q) {
                $q->where('student_type', 'siswa')->orWhere('education_level', 'SMK');
            })->count();

        // Build filtered query
        $query = User::with([
            'studentProfile',
            'mentorProfile',
            'mentoredInternships' => function ($q) {
                $q->whereIn('status', ['active', 'onboarding'])->with(['student.studentProfile', 'division']);
            }
        ])
            ->where('role', '!=', 'admin');

        // Mandatory role-based restriction (Mentors OR Active Interns)
        $query->where(function ($q) {
            $q->where('role', 'mentor')
                ->orWhere(function ($sq) {
                    $sq->where('role', 'student')
                        ->whereHas('internship', function ($sub) {
                            $sub->where('status', 'active');
                        });
                });
        });

        // 1. Search (Name/Email)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // 2. Role Filter
        if ($role) {
            $query->where('role', $role);
        }

        // 3. Student Type Filter (SMK vs MHS)
        if ($role === 'student' && $studentType) {
            $query->whereHas('studentProfile', function ($q) use ($studentType) {
                if ($studentType === 'smk') {
                    $q->where('student_type', 'siswa')->orWhere('education_level', 'SMK');
                } elseif ($studentType === 'mahasiswa') {
                    $q->where('student_type', 'mahasiswa')->where(function ($sub) {
                        $sub->where('education_level', '!=', 'SMK')->orWhereNull('education_level');
                    });
                }
            });
        }

        // 4. Division Filter
        if ($divisionId) {
            $query->where(function ($q) use ($divisionId) {
                $q->whereHas('internship', function ($sub) use ($divisionId) {
                    $sub->where('division_id', $divisionId);
                })
                    ->orWhereHas('divisions', function ($sub) use ($divisionId) { // Mentors are division leads
                        $sub->where('id', $divisionId);
                    });
            });
        }

        // 5. Sorting
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact(
            'users',
            'role',
            'studentType',
            'divisionId',
            'sort',
            'divisions',
            'totalAll',
            'totalMentors',
            'totalStudents',
            'studentMahasiswaCount',
            'studentSmkCount'
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
            'position' => 'required|string|max:255',
        ]);

        // 1. Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mentor',
        ]);

        // 2. Create Mentor Profile (without NIK)
        \App\Models\MentorProfile::create([
            'user_id' => $user->id,
            'position' => $request->position,
        ]);

        return redirect()->back()
            ->with('success', 'Mentor baru berhasil ditambahkan!');
    }

    /**
     * Monitoring Magang: List semua magang aktif.
     */
    public function internships(Request $request)
    {
        $status = $request->query('status', 'pending');
        $studentType = $request->query('student_type');
        $search = $request->query('search');
        $divisionId = $request->query('division_id');
        $sort = $request->query('sort', 'latest');

        // 1. Tab Counts (Global for status)
        $onboardingCount = Internship::where('status', 'onboarding')->count();
        $pendingCount = Internship::where('status', 'pending')->count() + $onboardingCount;
        $activeCount = Internship::where('status', 'active')->count();
        $finishedCount = Internship::where('status', 'finished')->count();
        $extensionCount = \App\Models\InternshipExtension::where('status', 'pending')->count();

        // All Divisions and Mentors for Filter / Modal
        $divisions = Division::orderBy('name')->get();
        $mentors = User::where('role', 'mentor')->orderBy('name')->get();

        // Build main query
        $query = Internship::with(['student.studentProfile', 'mentor', 'division', 'documents']);

        // Handle Status
        if ($status === 'extension') {
            $query->whereHas('extensions', function ($q) {
                $q->where('status', 'pending');
            })->with([
                        'extensions' => function ($q) {
                            $q->where('status', 'pending');
                        }
                    ]);
        } elseif ($status === 'pending') {
            $query->whereIn('status', ['pending', 'onboarding']);
        } else {
            $query->where('status', $status);
        }

        // 2. Tab Sub-counts (Based on current base status, but before other filters)
        $totalInterns = (clone $query)->count();
        $internMahasiswaCount = (clone $query)->whereHas('student.studentProfile', function ($q) {
            $q->where('student_type', 'mahasiswa')->where(function ($sub) {
                $sub->where('education_level', '!=', 'SMK')->orWhereNull('education_level');
            });
        })->count();
        $internSmkCount = (clone $query)->whereHas('student.studentProfile', function ($q) {
            $q->where('student_type', 'siswa')->orWhere('education_level', 'SMK');
        })->count();

        // 3. Search Filter
        if ($search) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // 4. Student Type Filter
        if ($studentType) {
            $query->whereHas('student.studentProfile', function ($q) use ($studentType) {
                if ($studentType === 'smk') {
                    $q->where('student_type', 'siswa')->orWhere('education_level', 'SMK');
                } elseif ($studentType === 'mahasiswa') {
                    $q->where('student_type', 'mahasiswa')->where(function ($sub) {
                        $sub->where('education_level', '!=', 'SMK')->orWhereNull('education_level');
                    });
                }
            });
        }

        // 5. Division Filter
        if ($divisionId) {
            $query->where('division_id', $divisionId);
        }

        // 6. Sorting
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->join('users', 'internships.student_id', '=', 'users.id')
                    ->orderBy('users.name', 'asc')
                    ->select('internships.*');
                break;
            case 'name_desc':
                $query->join('users', 'internships.student_id', '=', 'users.id')
                    ->orderBy('users.name', 'desc')
                    ->select('internships.*');
                break;
            case 'end_date_near':
                $query->orderBy('end_date', 'asc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $internships = $query->paginate(10)->withQueryString();

        // Redirect if extension empty
        if ($status === 'extension' && $extensionCount === 0) {
            return redirect()->route('admin.internships.index', ['status' => 'pending']);
        }

        return view('admin.internships.index', compact(
            'internships',
            'status',
            'studentType',
            'search',
            'divisionId',
            'sort',
            'pendingCount',
            'onboardingCount',
            'activeCount',
            'finishedCount',
            'extensionCount',
            'divisions',
            'mentors',
            'totalInterns',
            'internMahasiswaCount',
            'internSmkCount'
        ));
    }

    /**
     * Approve Internship (Pending -> Onboarding)
     */
    public function approveInternship(Request $request, $id, \App\Services\InternshipService $internshipService)
    {
        $internship = Internship::findOrFail($id);

        if ($internship->status !== 'pending') {
            return back()->with('error', 'Status magang tidak valid untuk disetujui.');
        }

        $request->validate([
            'division_id' => 'required|exists:divisions,id',
        ]);

        $division = Division::findOrFail($request->division_id);

        if (!$division->mentor_id) {
            return back()->with('error', 'Divisi yang dipilih belum memiliki Kepala Mentor. Silakan assign mentor ke divisi ini terlebih dahulu di Master Divisi.');
        }

        $internshipService->approve($internship, $division);

        return redirect()->route('admin.internships.index', ['status' => 'pending'])
            ->with('success', 'Pengajuan diterima! Mahasiswa kini statusnya Pending (Melengkapi Berkas).');
    }

    /**
     * Reject Internship (Pending -> Rejected)
     */
    public function rejectInternship(Request $request, $id, \App\Services\InternshipService $internshipService)
    {
        $internship = Internship::findOrFail($id);

        if ($internship->status !== 'pending') {
            return back()->with('error', 'Status magang tidak valid untuk ditolak.');
        }

        $internshipService->reject($internship);

        return redirect()->route('admin.internships.index', ['status' => 'pending'])
            ->with('success', 'Pengajuan magang ditolak. Data akan dihapus otomatis dalam 3 hari.');
    }

    /**
     * Activate Internship (Onboarding -> Active)
     */
    public function activateInternship(Request $request, $id, \App\Services\InternshipService $internshipService)
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

        $inductionData = [
            'date' => $request->induction_date,
            'time' => $request->induction_time,
        ];

        $message = $internshipService->activate($internship, $inductionData);

        return redirect()->route('admin.internships.index', ['status' => 'pending'])
            ->with('success', $message);
    }

    /**
     * Complete Internship (Upload Certificate & Assessment)
     */
    public function completeInternship(Request $request, $id, \App\Services\InternshipService $internshipService)
    {
        $internship = Internship::with('student.studentProfile')->findOrFail($id);

        $request->validate([
            'dokumen_kelulusan' => 'required|array|min:1',
            'dokumen_kelulusan.*' => 'file|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('dokumen_kelulusan')) {
            $internshipService->complete($internship, $request->file('dokumen_kelulusan'));
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
            'status' => 'required|in:present,late,sick,permit,alpha',
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