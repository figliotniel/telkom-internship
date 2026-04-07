<nav x-data="{ open: false }" class="bg-[#ed1e28] dark:bg-slate-900 w-64 border-r border-transparent dark:border-slate-800 hidden lg:flex flex-col z-20 h-screen sticky top-0 shadow-[4px_0_24px_rgba(0,0,0,0.1)] transition-colors duration-300">
    {{-- Logo Area --}}
    <div class="h-20 flex items-center px-6 border-b border-white/10 dark:border-slate-800 transition-colors duration-300">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-white dark:bg-gradient-to-br dark:from-red-500 dark:to-red-700 rounded-xl flex items-center justify-center text-[#ed1e28] dark:text-white font-bold text-xl shadow-sm group-hover:scale-105 transition-transform">
                T
            </div>
            <span class="font-extrabold text-xl tracking-tight text-white transition-colors duration-300">Magang</span>
        </a>
    </div>

    {{-- Main Menu --}}
    <div class="px-6 py-4 flex-1 overflow-y-auto">
        <p class="text-[10px] font-bold text-red-200/60 dark:text-slate-500 uppercase tracking-widest mb-3 pl-1">Menu Utama</p>
        <nav class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-black/20 text-white dark:bg-red-500/10 dark:text-red-400 border border-white/5 dark:border-red-500/20 shadow-inner' : 'text-red-100 dark:text-slate-400 hover:text-white dark:hover:text-slate-200 hover:bg-black/10 dark:hover:bg-slate-800 group' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.dashboard') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100 text-red-200 group-hover:text-white dark:text-slate-400 dark:group-hover:text-slate-300 transition-opacity' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Ringkasan
            </a>
            
            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.users*') ? 'bg-black/20 text-white dark:bg-red-500/10 dark:text-red-400 border border-white/5 dark:border-red-500/20 shadow-inner' : 'text-red-100 dark:text-slate-400 hover:text-white dark:hover:text-slate-200 hover:bg-black/10 dark:hover:bg-slate-800 group' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.users*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100 text-red-200 group-hover:text-white dark:text-slate-400 dark:group-hover:text-slate-300 transition-opacity' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Database Pengguna
            </a>

            <a href="{{ route('admin.internships.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.internships*') ? 'bg-black/20 text-white dark:bg-red-500/10 dark:text-red-400 border border-white/5 dark:border-red-500/20 shadow-inner' : 'text-red-100 dark:text-slate-400 hover:text-white dark:hover:text-slate-200 hover:bg-black/10 dark:hover:bg-slate-800 group' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.internships*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100 text-red-200 group-hover:text-white dark:text-slate-400 dark:group-hover:text-slate-300 transition-opacity' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Monitoring Magang
            </a>

            <a href="{{ route('admin.divisions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-bold transition-all {{ request()->routeIs('admin.divisions*') ? 'bg-black/20 text-white dark:bg-red-500/10 dark:text-red-400 border border-white/5 dark:border-red-500/20 shadow-inner' : 'text-red-100 dark:text-slate-400 hover:text-white dark:hover:text-slate-200 hover:bg-black/10 dark:hover:bg-slate-800 group' }}">
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.divisions*') ? 'opacity-100' : 'opacity-70 group-hover:opacity-100 text-red-200 group-hover:text-white dark:text-slate-400 dark:group-hover:text-slate-300 transition-opacity' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Master Divisi
            </a>
        </nav>
    </div>

    {{-- Bottom Section --}}
    <div class="px-6 py-4 border-t border-white/10 dark:border-slate-800">
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="flex items-center gap-3 px-3 py-2.5 w-full text-left text-[#ffb3b5] hover:text-white hover:bg-black/10 dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-slate-800 rounded-xl font-bold transition-colors">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Keluar
            </button>
        </form>
    </div>
</nav>
