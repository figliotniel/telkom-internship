<nav x-data="{ open: false }" class="bg-[#991b1b] dark:bg-slate-900 w-64 border-r border-transparent dark:border-slate-800 hidden lg:flex flex-col z-20 h-screen sticky top-0 shadow-[4px_0_24px_rgba(0,0,0,0.1)] transition-colors duration-300">
    {{-- Logo Area --}}
    <div class="h-20 flex items-center px-6 border-b border-white/10 dark:border-slate-800 transition-colors duration-300">
        <a href="{{ route('mentor.dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-white dark:bg-gradient-to-br dark:from-red-500 dark:to-red-700 rounded-xl flex items-center justify-center text-[#991b1b] dark:text-white font-bold text-xl shadow-sm group-hover:scale-105 transition-transform">
                T
            </div>
            <span class="font-extrabold text-xl tracking-tight text-white transition-colors duration-300">Internship</span>
        </a>
    </div>

    {{-- Main Menu --}}
    @php
        $pendingCount = \App\Models\DailyLogbook::whereHas('internship', function($q) {
            $q->where('mentor_id', auth()->id());
        })->where('status', 'pending')->count();
    @endphp

    <div class="px-6 py-4 flex-1 overflow-y-auto">
        <p class="text-[10px] font-bold text-red-200/60 dark:text-slate-500 uppercase tracking-widest mb-3 pl-1">Mentees Panel</p>
        <nav class="space-y-1">
            <a href="{{ route('mentor.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold transition-all {{ request()->routeIs('mentor.dashboard') ? 'bg-black/20 text-white dark:bg-red-500/10 dark:text-red-400 border border-white/5 dark:border-red-500/20 shadow-inner' : 'text-red-100 dark:text-slate-400 hover:text-white dark:hover:text-slate-200 hover:bg-black/10 dark:hover:bg-slate-800 group' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('mentor.dashboard') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100 text-red-200 group-hover:text-white dark:text-slate-400 dark:group-hover:text-slate-300 transition-opacity' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>
            
            <a href="{{ route('mentor.students.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold transition-all {{ request()->routeIs('mentor.students*') ? 'bg-black/20 text-white dark:bg-red-500/10 dark:text-red-400 border border-white/5 dark:border-red-500/20 shadow-inner' : 'text-red-100 dark:text-slate-400 hover:text-white dark:hover:text-slate-200 hover:bg-black/10 dark:hover:bg-slate-800 group' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('mentor.students*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100 text-red-200 group-hover:text-white dark:text-slate-400 dark:group-hover:text-slate-300 transition-opacity' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                My Interns
            </a>

            <a href="{{ route('mentor.approvals.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl font-bold transition-all {{ request()->routeIs('mentor.approvals*') ? 'bg-black/20 text-white dark:bg-red-500/10 dark:text-red-400 border border-white/5 dark:border-red-500/20 shadow-inner' : 'text-red-100 dark:text-slate-400 hover:text-white dark:hover:text-slate-200 hover:bg-black/10 dark:hover:bg-slate-800 group' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('mentor.approvals*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100 text-red-200 group-hover:text-white dark:text-slate-400 dark:group-hover:text-slate-300 transition-opacity' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Persetujuan
                </div>
                @if($pendingCount > 0)
                    <span class="bg-amber-400 text-amber-900 border border-amber-300 text-[10px] font-black px-2 py-0.5 rounded-md shadow-sm">{{ $pendingCount }}</span>
                @endif
            </a>
        </nav>
    </div>

    {{-- Bottom Section (Profile & Logout) --}}
    <div class="px-6 py-4 border-t border-white/10 dark:border-slate-800 space-y-1 w-full block">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 w-full text-left text-red-100 dark:text-slate-400 hover:text-white dark:hover:text-slate-200 hover:bg-black/10 dark:hover:bg-slate-800 rounded-xl font-bold transition-colors">
            <svg class="w-5 h-5 flex-shrink-0 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="truncate">Profil Anda</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="m-0 block w-full">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-3 py-2.5 w-full text-left text-[#ffb3b5] hover:text-white hover:bg-black/10 dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-slate-800 rounded-xl font-bold transition-colors">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Sign Out
            </button>
        </form>
    </div>
</nav>
