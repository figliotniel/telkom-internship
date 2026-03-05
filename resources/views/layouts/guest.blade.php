<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="transition-colors duration-300">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Telkom Witel Internship') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script>
        // Use system preference or explicitly handle theme later, removing forced mode
    </script>
</head>
<body class="font-sans flex flex-col min-h-screen m-0 overflow-x-hidden bg-white text-slate-800 transition-colors duration-300">

    <header class="bg-white border-b border-slate-50 flex justify-between items-center py-3 px-10 shadow-[0_4px_20px_rgba(0,0,0,0.03)] transition-all duration-300">
        <div class="flex-shrink-0 group">
            <img src="{{ asset('images/logo-telkom.png') }}" alt="Telkom Indonesia" class="h-20 w-auto dark:hidden transition-all duration-300">
            <img src="{{ asset('images/logo-telkom-white.png') }}" alt="Telkom Indonesia Logo" class="h-20 w-auto hidden dark:block transition-all duration-300">
        </div>
        <a href="/" class="bg-[#D6001C] text-white no-underline py-2.5 px-6 rounded-full font-bold text-sm shadow-[0_4px_12px_rgba(214,0,28,0.2)] transition-all duration-300 hover:bg-[#b00017] hover:-translate-y-[1px] hover:shadow-[0_6px_15px_rgba(214,0,28,0.3)]">Main Website</a>
    </header>

    <main class="flex-1 flex flex-col items-center pb-[50px] min-h-[90vh] justify-center w-full z-10 relative">
        {{ $slot }}
    </main>

    @include('partials.footer')

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

</body>
</html>
                                                                                                                                                                                                                     