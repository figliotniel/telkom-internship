@props(['totalPresent', 'attendancePercentage', 'totalPermit'])

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 transition-colors duration-300">
    <!-- Stats: Total Hadir -->
    <div class="group bg-white dark:bg-slate-900 rounded-2xl p-5 shadow-sm dark:shadow-emerald-950/20 border border-slate-100 dark:border-slate-800 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 flex items-center gap-5">
        <div class="p-4 bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-all transform group-hover:scale-110 group-hover:rotate-3 shrink-0 shadow-sm border border-transparent dark:border-emerald-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
            </svg>
        </div>
        
        <div class="grow">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1 transition-colors">Total Kehadiran</p>
            <h4 class="text-3xl font-black text-slate-800 dark:text-slate-100 transition-colors leading-none">{{ $totalPresent }} <span class="text-sm font-bold text-slate-400 dark:text-slate-500">Hari</span></h4>
        </div>

        <div class="text-right shrink-0">
            <span class="text-lg font-black text-emerald-600 dark:text-emerald-400 tabular-nums">{{ $attendancePercentage }}%</span>
            <div class="w-16 h-2 bg-slate-100 dark:bg-slate-800 rounded-full mt-2 overflow-hidden border border-slate-200/50 dark:border-slate-700/50 shadow-inner">
                <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-400 rounded-full shadow-[0_0_12px_rgba(16,185,129,0.5)] transition-all duration-1000" style="width: {{ $attendancePercentage }}%"></div>
            </div>
        </div>
    </div>

    <!-- Stats: Total Izin -->
    <div class="group bg-white dark:bg-slate-900 rounded-2xl p-5 shadow-sm dark:shadow-amber-950/20 border border-slate-100 dark:border-slate-800 hover:shadow-xl hover:shadow-amber-500/10 transition-all duration-300 flex items-center gap-5">
        <div class="p-4 bg-amber-100 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-xl group-hover:bg-amber-600 group-hover:text-white transition-all transform group-hover:scale-110 group-hover:-rotate-3 shrink-0 shadow-sm border border-transparent dark:border-amber-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7">
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
            </svg>
        </div>
        
        <div class="grow">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-1 transition-colors">Total Izin</p>
            <h4 class="text-3xl font-black text-slate-800 dark:text-slate-100 transition-colors leading-none">{{ $totalPermit ?? 0 }} <span class="text-sm font-bold text-slate-400 dark:text-slate-500">Hari</span></h4>
        </div>
    </div>
</div>
