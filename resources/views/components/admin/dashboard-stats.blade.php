@props(['totalStudents', 'studentGrowth', 'activeInternships', 'totalMentors', 'mentorGrowth'])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
    {{-- Stat 1: Total Interns --}}
    <div class="flex flex-col group p-6 rounded-[2rem] border transition-all duration-500 hover:scale-[1.03] hover-glint glass-card-light dark:bg-slate-900 border-red-500/30 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-400 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        
        <div class="flex items-start justify-between mb-2">
            <div class="relative z-10 text-left">
                <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Total Intern</p>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">{{ $totalStudents }}</h3>
            </div>
            <div class="p-4 bg-red-500/10 dark:bg-red-500/10 rounded-2xl text-[#ed1e28] dark:text-red-400 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 border border-red-500/20 relative z-10 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>
        
        <div class="mt-4 flex items-center text-sm relative z-10">
            @if($studentGrowth > 0)
                <span class="flex items-center text-emerald-600 dark:text-emerald-400 font-black bg-emerald-500/10 px-2.5 py-1 rounded-lg text-[10px] border border-emerald-500/20 shadow-sm uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    +{{ $studentGrowth }} Baru
                </span>
                <span class="text-slate-400 dark:text-slate-500 ml-2 text-[10px] font-bold uppercase tracking-wider">Bulan ini</span>
            @else
                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-md">Data stabil</span>
            @endif
        </div>
        <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="absolute inset-0 z-20 focus:outline-none"></a>
    </div>

    {{-- Stat 2: Active Interns --}}
    <div class="flex flex-col group p-6 rounded-[2rem] border transition-all duration-500 hover:scale-[1.03] hover-glint glass-card-light dark:bg-slate-900 border-emerald-500/30 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        
        <div class="flex items-start justify-between mb-2">
            <div class="relative z-10 text-left">
                <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Peserta Aktif</p>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">{{ $activeInternships }}</h3>
            </div>
            <div class="p-4 bg-emerald-500/10 dark:bg-emerald-500/10 rounded-2xl text-emerald-600 dark:text-emerald-400 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 border border-emerald-500/20 relative z-10 shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>
        
        <div class="mt-4 flex items-center relative z-10">
            <span class="flex items-center text-emerald-600 dark:text-emerald-400 font-black bg-emerald-500/10 px-3 py-1 rounded-lg text-[10px] border border-emerald-500/20 shadow-sm uppercase tracking-wider">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse mr-2 shadow-[0_0_8px_#10b981]"></div>
                Sedang Aktif
            </span>
        </div>
        <a href="{{ route('admin.internships.index', ['status' => 'active']) }}" class="absolute inset-0 z-20 focus:outline-none"></a>
    </div>

    {{-- Stat 3: Total Mentors --}}
    <div class="flex flex-col group p-6 rounded-[2rem] border transition-all duration-500 hover:scale-[1.03] hover-glint glass-card-light dark:bg-slate-900 border-blue-500/30 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        
        <div class="flex items-start justify-between mb-2">
            <div class="relative z-10 text-left">
                <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Total Mentor</p>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">{{ $totalMentors }}</h3>
            </div>
            <div class="p-4 bg-blue-500/10 dark:bg-blue-500/10 rounded-2xl text-blue-600 dark:text-blue-400 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 border border-blue-500/20 relative z-10 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        
        <div class="mt-4 flex items-center text-sm relative z-10">
            @if($mentorGrowth > 0)
                <span class="flex items-center text-blue-600 dark:text-blue-400 font-black bg-blue-500/10 px-2.5 py-1 rounded-lg text-[10px] border border-blue-500/20 shadow-sm uppercase tracking-wider">
                    <svg class="w-3.5 h-3.5 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    {{ $mentorGrowth }} Baru
                </span>
                <span class="text-slate-400 dark:text-slate-500 ml-2 text-[10px] font-bold uppercase tracking-wider">Bulan ini</span>
            @else
                <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-md">Data stabil</span>
            @endif
        </div>
            <a href="{{ route('admin.users.index', ['role' => 'mentor']) }}" class="absolute inset-0 z-20 focus:outline-none"></a>
    </div>

</div>
