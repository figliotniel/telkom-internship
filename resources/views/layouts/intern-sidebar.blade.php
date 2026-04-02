<nav x-data="{ open: false }" class="bg-white dark:bg-slate-900 w-64 border-r border-gray-100 dark:border-slate-800 hidden lg:flex flex-col z-20 h-screen sticky top-0 shadow-[4px_0_24px_rgba(0,0,0,0.02)] transition-colors duration-300">
    {{-- Logo Area --}}
    <div class="h-20 flex items-center px-6 border-b border-gray-100 dark:border-slate-800 transition-colors duration-300">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-700 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-red-500/30">
                T
            </div>
            <span class="font-extrabold text-xl tracking-tight text-slate-900 dark:text-white transition-colors duration-300">Internship</span>
        </a>
    </div>

    {{-- Main Menu --}}
    <div class="px-6 py-4 flex-1 overflow-y-auto w-full">
        <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3 pl-1">Main Menu</p>
        <nav class="space-y-1 block w-full">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold transition-all w-full {{ request()->routeIs('dashboard') ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 group' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('dashboard') ? 'opacity-80' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Ringkasan Magang
            </a>
            
            <a href="{{ route('logbooks.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold transition-all w-full {{ request()->routeIs('logbooks.*') ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 group' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('logbooks.*') ? 'opacity-80' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Logbook Harian
            </a>

            <a href="{{ route('documents.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold transition-all w-full {{ request()->routeIs('documents.*') ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 group' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('documents.*') ? 'opacity-80' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" /></svg>
                Pusat Dokumen
            </a>
        </nav>
    </div>

    {{-- Bottom Section (Profile & Logout) --}}
    <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-800 space-y-1 w-full block">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 w-full text-left text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl font-bold transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="truncate">Profil Anda</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="m-0 block w-full">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-3 py-2.5 w-full text-left text-red-600 hover:bg-red-50 dark:hover:bg-slate-800 rounded-xl font-bold transition-colors">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Sign Out
            </button>
        </form>
    </div>
</nav>
