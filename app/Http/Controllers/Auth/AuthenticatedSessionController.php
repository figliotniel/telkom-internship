<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // Check if student has active internship
        if ($user->hasRole('student')) {
            $internship = \App\Models\Internship::where('student_id', $user->id)->first();

            // If internship exists
            if ($internship) {
                // 1. Block 'dropped' status immediately
                if ($internship->status === 'dropped') {
                    Auth::guard('web')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return back()->withErrors(['email' => 'Akun Anda telat dinonaktifkan (Dropped).']);
                }

                // 2. Handle 'finished' status
                if ($internship->status === 'finished') {
                    // Check if more than 1 month has passed since end_date
                    $endDate = \Carbon\Carbon::parse($internship->end_date);
                    $limitDate = $endDate->copy()->addMonth();

                    if (now()->gt($limitDate)) {
                        Auth::guard('web')->logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();

                        return back()->withErrors([
                            'email' => 'Masa akses akun Anda telah berakhir (lebih dari 1 bulan setelah magang selesai).',
                        ]);
                    }
                    // If within 1 month, ALLOW login (proceed to redirect logic below)
                }
            }
        }

        // Cek role dan redirect ke dashboard sesuai role
        if ($user->hasRole('mentor')) {
            return redirect()->intended(route('mentor.dashboard', absolute: false));
        }

        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        // Default arahkan ke dashboard mahasiswa (untuk role 'student')
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
