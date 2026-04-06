<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
        <!-- Flatpickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        <!-- Trix Editor CSS -->
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts -->
        {{ Vite::useScriptTagAttributes(['data-turbo-track' => 'reload']) }}
        {{ Vite::useStyleTagAttributes(['data-turbo-track' => 'reload']) }}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            // Anti-flash script
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
        <style>
            body { font-family: 'Inter', sans-serif; }
            [x-cloak] { display: none !important; }

            /* SOFT LIGHT MODE (EYE-CARE) GLOBAL ENHANCEMENTS */
            /* Mengubah warna putih murni dan hitam pekat menjadi warna yang lebih ramah mata (kalem) */
            html:not(.dark) body, 
            html:not(.dark) main, 
            html:not(.dark) .bg-\[\#f8fafc\],
            html:not(.dark) .bg-slate-50 {
                background-color: #F7F8FA !important; /* Latar utama yang lebih teduh dari slate-50 */
            }

            html:not(.dark) .bg-white {
                background-color: #FCFDFD !important; /* Off-white lembut menghilangkan pantulan cahaya menyilaukan */
            }

            html:not(.dark) .text-slate-800,
            html:not(.dark) .text-slate-900,
            html:not(.dark) .text-gray-900,
            html:not(.dark) .text-black {
                color: #334155 !important; /* Teks diredupkan ke Slate-700 (abu-abu tua) untuk menurunkan kontras layar */
            }

            html:not(.dark) .border-slate-100,
            html:not(.dark) .border-slate-200 {
                border-color: #EEF2F6 !important; /* Melunakkan garis tepi */
            }
            
            /* (Opsional) Efek Sepia Lembut (Saringan Cahaya Biru) Khusus Layar Terang */
            html:not(.dark) body::after {
                content: '';
                position: fixed;
                inset: 0;
                background-color: rgba(255, 249, 240, 0.6); /* Tint Krem Kertas yang sangat lembut */
                pointer-events: none; /* Tidak mengganggu klik mouse */
                z-index: 99999;
                mix-blend-mode: multiply; /* Melebur warna putih menjadi warna krem, persis mode layar HP Eye-Care */
            }
        </style>
    </head>
    <body 
        x-data="{ 
            darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
            toggleTheme() {
                this.darkMode = !this.darkMode;
                localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        }"
        class="font-sans antialiased text-slate-800 dark:text-slate-200 bg-slate-50 dark:bg-slate-950 transition-colors duration-300"
    >
        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'mentor', 'student']))
            {{-- Unified Layout: Sidebar + Topbar --}}
            <div class="flex h-screen overflow-hidden text-slate-800 dark:text-slate-200 antialiased bg-[#f8fafc] dark:bg-slate-950">
                @if(auth()->user()->role === 'admin')
                    @include('layouts.admin-sidebar')
                @elseif(auth()->user()->role === 'mentor')
                    @include('layouts.mentor-sidebar')
                @elseif(auth()->user()->role === 'student')
                    @include('layouts.intern-sidebar')
                @endif
                
                <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
                    @if(auth()->user()->role === 'admin')
                        @include('layouts.admin-topbar')
                    @elseif(auth()->user()->role === 'mentor')
                        @include('layouts.mentor-topbar')
                    @elseif(auth()->user()->role === 'student')
                        @include('layouts.intern-topbar')
                    @endif
                    
                    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f8fafc] dark:bg-slate-950 transition-colors duration-300 flex flex-col justify-between">
                        <div>
                            {{ $slot }}
                        </div>
                        <div class="mt-auto block w-full">
                            @include('partials.footer')
                        </div>
                    </main>
                </div>
            </div>
        @else
            {{-- Standard Layout: Navigation only --}}
            <div class="w-full block min-h-screen bg-slate-50 dark:bg-slate-950">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white dark:bg-slate-900 shadow-sm border-b border-gray-100 dark:border-slate-800 transition-colors duration-300 w-full block">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 w-full block">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="w-full block">
                    {{ $slot }}
                </main>
            </div>
            @include('partials.footer')
        @endif
        
        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

        <!-- Trix Editor JS -->
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

        <!-- Global SweetAlert Flash Messages -->
        @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session("success") }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-lg',
                        title: 'text-slate-800 dark:text-slate-100',
                        htmlContainer: 'text-slate-500 dark:text-slate-400'
                    }
                });
            });
        </script>
        @endif

        @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Waduh...',
                    text: '{{ session("error") }}',
                    buttonsStyling: false,
                    customClass: {
                        popup: 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-xl',
                        title: 'text-slate-800 dark:text-slate-100 font-bold',
                        htmlContainer: 'text-slate-500 dark:text-slate-400',
                        confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all',
                    }
                });
            });
        </script>
        @endif

        @if($errors->any() && !request()->routeIs('dashboard'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cek Kembali Input Anda',
                    text: '{{ $errors->first() }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-lg',
                        title: 'text-slate-800 dark:text-slate-100',
                        htmlContainer: 'text-slate-500 dark:text-slate-400'
                    }
                });
            });
        </script>
        @endif

        @stack('scripts')
    </body>
</html>
