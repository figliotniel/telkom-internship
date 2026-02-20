@props(['totalPresent', 'attendancePercentage', 'totalPermit'])

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <!-- Stats: Total Hadir -->
    <div class="group bg-white rounded-xl p-4 shadow-sm border border-slate-100 hover:shadow-md transition-all flex items-center gap-4">
        <div class="p-3 bg-emerald-100 text-emerald-600 rounded-lg group-hover:bg-emerald-600 group-hover:text-white transition-colors shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
            </svg>
        </div>
        
        <div class="grow">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-0.5">Kehadiran</p>
            <h4 class="text-2xl font-bold text-slate-800">{{ $totalPresent }} <span class="text-xs font-normal text-slate-500">Hari</span></h4>
        </div>

        <div class="text-right shrink-0">
            <span class="text-sm font-bold text-emerald-600">{{ $attendancePercentage }}%</span>
            <div class="w-12 h-1.5 bg-slate-100 rounded-full mt-1 overflow-hidden">
                <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $attendancePercentage }}%"></div>
            </div>
        </div>
    </div>

    <!-- Stats: Total Izin -->
    <div class="group bg-white rounded-xl p-4 shadow-sm border border-slate-100 hover:shadow-md transition-all flex items-center gap-4">
        <div class="p-3 bg-amber-100 text-amber-600 rounded-lg group-hover:bg-amber-600 group-hover:text-white transition-colors shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
            </svg>
        </div>
        
        <div class="grow">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-0.5">Izin</p>
            <h4 class="text-2xl font-bold text-slate-800">{{ $totalPermit ?? 0 }} <span class="text-xs font-normal text-slate-500">Hari</span></h4>
        </div>
    </div>
</div>
