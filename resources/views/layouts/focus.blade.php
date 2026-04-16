<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Onboarding</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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
            
            /* Custom Scrollbar for better UI */
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: transparent; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
            .dark ::-webkit-scrollbar-thumb { background: #475569; }
            ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

            /* Glassmorphism Classes */
            .glass-card {
                background: rgba(255, 255, 255, 0.4);
                backdrop-filter: blur(24px);
                -webkit-backdrop-filter: blur(24px);
                border: 1px solid rgba(255, 255, 255, 0.6);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05), inset 0 0 0 1px rgba(255,255,255,0.4);
            }
            .dark .glass-card {
                background: rgba(15, 23, 42, 0.6);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 0 0 1px rgba(255,255,255,0.05);
            }

            .glass-inner {
                background: rgba(255, 255, 255, 0.9);
            }
            .dark .glass-inner {
                background: rgba(30, 41, 59, 0.8);
            }

            /* Animated gradient background */
            .bg-dynamic {
                background: linear-gradient(-45deg, #f8f9fa, #e9ecef, #f1f3f5, #ffffff);
                background-size: 400% 400%;
                animation: gradient 15s ease infinite;
            }
            .dark .bg-dynamic {
                background: linear-gradient(-45deg, #0f172a, #152238, #0f172a, #0b1120);
            }

            @keyframes gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            /* Telkom Colors Blobs */
            .blob-1 { position: absolute; top: -10%; right: -10%; width: 400px; height: 400px; background: rgba(238, 42, 36, 0.15); filter: blur(50px); border-radius: 50%; z-index: -1; animation: float 6s ease-in-out infinite; }
            .blob-2 { position: absolute; bottom: -10%; left: -10%; width: 500px; height: 500px; background: rgba(85, 86, 91, 0.12); filter: blur(60px); border-radius: 50%; z-index: -1; animation: float 8s ease-in-out infinite reverse; }
            .dark .blob-1 { background: rgba(238, 42, 36, 0.2); }
            .dark .blob-2 { background: rgba(148, 163, 184, 0.1); }
            
            @keyframes float {
                0% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-30px) rotate(10deg); }
                100% { transform: translateY(0px) rotate(0deg); }
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
        class="bg-dynamic text-[#55565b] dark:text-slate-300 font-sans antialiased min-h-screen relative flex flex-col items-center justify-center p-4 selection:bg-[#EE2A24] selection:text-white transition-colors duration-300 overflow-x-hidden"
    >
        <!-- The background blobs -->
        <div class="blob-1"></div>
        <div class="blob-2"></div>

        <main class="w-full flex-grow flex flex-col justify-center items-center relative z-10 my-16 lg:my-0">
            {{ $slot }}
        </main>
        
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
                    title: 'Oops...',
                    text: '{{ session("error") }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-lg',
                        title: 'text-slate-800 dark:text-slate-100 font-bold',
                        htmlContainer: 'text-slate-500 dark:text-slate-400'
                    }
                });
            });
        </script>
        @endif

        @stack('scripts')
    </body>
</html>
