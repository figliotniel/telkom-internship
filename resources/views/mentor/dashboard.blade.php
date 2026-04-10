<x-app-layout>
    {{-- Main Scrollable Content Wrapper - Enforcing strict HTML structural fidelity --}}
    <div class="p-8 lg:p-10 max-w-7xl mx-auto space-y-10 w-full flex-1">
        
        <!-- Welcome Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Selamat datang kembali, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Berikut adalah ringkasan hari ini untuk peserta bimbingan Anda, {{ now()->translatedFormat('l, d M Y') }}.</p>
            </div>
            
            @if(($pendingLogbooksCount ?? 0) > 0)
            <div class="flex gap-3">
                <a href="{{ route('mentor.approvals.index') }}" class="px-5 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all font-semibold text-sm shadow-lg shadow-red-500/30 hover:shadow-red-500/50 active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Validasi {{ $pendingLogbooksCount }} Logbook
                </a>
            </div>
            @endif
        </div>

        <!-- Premium Stats Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Card 1: Peserta Aktif (Emerald Theme) -->
            <div class="flex flex-col group p-6 rounded-[2rem] border transition-all duration-500 hover:scale-[1.03] hover-glint glass-card-light dark:bg-slate-900 border-emerald-500/30 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="flex items-start justify-between mb-2">
                    <div class="relative z-10 text-left">
                        <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Peserta Aktif</p>
                        <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">{{ $internships->where('status', 'active')->count() }}</h3>
                    </div>
                    <div class="p-4 bg-emerald-500/10 dark:bg-emerald-500/10 rounded-2xl text-emerald-600 dark:text-emerald-400 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 border border-emerald-500/20 relative z-10 shadow-sm">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                
                <div class="mt-4 flex items-center relative z-10">
                    <span class="flex items-center text-emerald-600 dark:text-emerald-400 font-black bg-emerald-500/10 px-3 py-1 rounded-lg text-[10px] border border-emerald-500/20 shadow-sm uppercase tracking-wider">
                        di {{ $internships->where('status', 'active')->pluck('division_id')->unique()->count() }} Divisi
                    </span>
                </div>
            </div>

            <!-- Card 2: Perlu Validasi (Red Theme) -->
            <div onclick="window.location='{{ route('mentor.approvals.index') }}'" class="flex flex-col group p-6 rounded-[2rem] border transition-all duration-500 hover:scale-[1.03] hover-glint glass-card-light dark:bg-slate-900 border-red-500/30 relative overflow-hidden cursor-pointer">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-400 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="flex items-start justify-between mb-2">
                    <div class="relative z-10 text-left">
                        <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Perlu Validasi</p>
                        <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">{{ $pendingLogbooksCount ?? 0 }}</h3>
                    </div>
                    <div class="p-4 bg-red-500/10 dark:bg-red-500/10 rounded-2xl text-[#ed1e28] dark:text-red-400 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 border border-red-500/20 relative z-10 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                
                <div class="mt-4 flex items-center relative z-10">
                    @if(($pendingLogbooksCount ?? 0) > 0)
                        <span class="flex items-center text-[#ed1e28] dark:text-red-400 font-black bg-red-500/10 px-3 py-1 rounded-lg text-[10px] border border-red-500/20 shadow-sm uppercase tracking-wider">
                            <div class="w-1.5 h-1.5 rounded-full bg-[#ed1e28] animate-pulse mr-2 shadow-[0_0_8px_#ed1e28]"></div>
                            Logbook Tertunda
                        </span>
                    @else
                        <span class="flex items-center text-emerald-600 dark:text-emerald-400 font-black bg-emerald-500/10 px-3 py-1 rounded-lg text-[10px] border border-emerald-500/20 shadow-sm uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            Logbook Aman
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content Grid: Mentees and Pending Logbooks -->
        <div class="grid grid-cols-1 gap-8 items-start" x-data="{ searchQuery: '' }">
            
            <!-- Left: Mentees List (Full width) -->
            <div class="bg-white dark:bg-[#0B1120] rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-slate-100 dark:border-slate-800 overflow-hidden flex flex-col group/mentees transition-all duration-300">
                
                <!-- Header Component -->
                <div class="px-8 py-7 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:justify-between md:items-center gap-6 bg-transparent relative z-10 font-sans">
                    <div>
                        <h3 class="text-xl font-black text-slate-800 dark:text-white tracking-tight flex items-center gap-3">
                            List Intern
                            <span class="px-2.5 py-0.5 rounded-md bg-amber-500/10 text-amber-600 dark:text-amber-400 text-xs font-bold border border-amber-500/20">{{ $internships->count() }}</span>
                        </h3>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">Kelola dan pantau progres dari peserta magang</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="relative w-full md:w-auto">
                            <svg class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" x-model="searchQuery" placeholder="Cari Intern..." class="pl-11 pr-4 py-2.5 bg-slate-50 dark:bg-[#1E293B]/50 border border-slate-200 dark:border-slate-700/50 rounded-xl text-sm font-medium focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500/50 outline-none transition-all text-slate-800 dark:text-white w-full md:w-64 placeholder-slate-400 shadow-inner">
                        </div>
                        <a href="{{ route('mentor.students.index') }}" class="p-2.5 border border-slate-200 dark:border-slate-700/50 bg-slate-50 dark:bg-[#1E293B]/50 rounded-xl text-slate-400 hover:text-amber-500 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all shadow-sm group" title="Filter / View All">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        </a>
                    </div>
                </div>
            
                <div class="overflow-y-auto flex-1 custom-scrollbar p-3">
                    <div class="flex flex-col gap-1.5">
                        @forelse($internships as $internship)
                            @php
                                $isSmk = optional(optional($internship->student)->studentProfile)->student_type === 'siswa' || optional(optional($internship->student)->studentProfile)->education_level === 'SMK';
                                $accentColor = $isSmk ? 'amber' : 'emerald';
                            @endphp

                            <div x-show="!searchQuery || '{{ strtolower(optional($internship->student)->name ?? '') }}'.includes(searchQuery.toLowerCase())" 
                                onclick="window.location='{{ route('mentor.students.show', $internship->id) }}'" 
                                class="p-4 mx-2 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-5 lg:gap-6 bg-transparent hover:bg-white dark:hover:bg-slate-800/60 rounded-[1.25rem] transition-all duration-300 group cursor-pointer border border-transparent hover:border-{{ $accentColor }}-200/50 dark:hover:border-slate-700/60 hover:shadow-[0_12px_40px_-10px_rgb(0,0,0,0.1)] dark:hover:shadow-none hover:-translate-y-0.5 relative z-10 overflow-hidden">
                                
                                <!-- Light Mode Hover Effect Layer -->
                                <div class="absolute inset-0 bg-gradient-to-r from-{{ $accentColor }}-50/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10 rounded-[1.25rem] dark:hidden"></div>
                                <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0 w-[4px] bg-gradient-to-b from-{{ $accentColor }}-400 to-{{ $accentColor }}-600 rounded-r-full group-hover:h-3/5 transition-all duration-500 opacity-0 group-hover:opacity-100 dark:hidden"></div>
                                
                                <!-- Container Kiri: Avatar & Nama -->
                                <div class="flex items-center gap-4 lg:gap-5 w-full lg:w-[35%] min-w-[260px]">
                                    <div class="relative flex-shrink-0">
                                        @if($internship->student->avatar_url)
                                            <img class="h-[52px] w-[52px] rounded-full object-cover shadow-inner ring-1 ring-slate-200 dark:ring-slate-700/50 group-hover:scale-105 group-hover:ring-{{ $accentColor }}-500/50 transition-all duration-300" 
                                                 src="{{ $internship->student->avatar_url }}" 
                                                 alt="{{ optional($internship->student)->name }}">
                                        @else
                                            <div class="h-[52px] w-[52px] rounded-full bg-slate-100 dark:bg-[#1E293B] flex items-center justify-center font-black text-xl text-{{ $accentColor }}-600 dark:text-{{ $accentColor }}-500 border border-slate-200 dark:border-slate-700/80 shadow-inner group-hover:scale-105 group-hover:border-{{ $accentColor }}-500/50 transition-all duration-300">
                                                {{ strtoupper(substr(optional($internship->student)->name ?? 'U', 0, 1)) }}
                                            </div>
                                        @endif
                                        
                                        @if($internship->status == 'active')
                                            <div class="absolute bottom-0 right-0.5 flex h-3.5 w-3.5 items-center justify-center">
                                                <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 animate-ping"></span>
                                                <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500 ring-[2.5px] ring-white dark:ring-[#0B1120] shadow-[0_0_10px_rgba(16,185,129,0.8)]"></span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 pr-2">
                                        <h3 class="font-bold text-slate-800 dark:text-gray-100 text-[15px] leading-tight group-hover:text-{{ $accentColor }}-600 dark:group-hover:text-{{ $accentColor }}-400 transition-colors truncate" title="{{ optional($internship->student)->name }}">
                                            {{ optional($internship->student)->name ?? 'Unknown Student' }}
                                        </h3>
                                        <p class="text-[12px] font-medium text-slate-500 dark:text-slate-400 mt-1 truncate" title="{{ optional(optional($internship->student)->studentProfile)->university ?? 'Universitas Tidak Diketahui' }}">
                                            {{ optional(optional($internship->student)->studentProfile)->university ?? 'Universitas Tidak Diketahui' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Container Tengah: Divisi -->
                                <div class="w-full lg:w-[25%] hidden md:block">
                                    <span class="inline-flex py-1.5 px-3 rounded-lg text-[9px] font-black uppercase tracking-widest bg-slate-50 dark:bg-[#151E32] text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700/60 shadow-sm leading-snug lg:leading-tight max-w-[200px] xl:max-w-[90%] text-left line-clamp-2">
                                        {{ optional($internship->division)->name ?? 'No Divisi' }}
                                    </span>
                                </div>

                                <!-- Container Tengah: Status -->
                                <div class="w-full lg:w-[15%] hidden lg:flex items-center">
                                    @if($internship->status == 'active')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-extrabold bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/30 uppercase tracking-widest shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_5px_rgba(16,185,129,0.5)]"></span>
                                            AKTIF
                                        </span>
                                    @elseif($internship->status == 'finished')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-extrabold bg-slate-100 dark:bg-slate-800/80 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 uppercase tracking-widest shadow-sm">
                                            SELESAI
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[10px] font-extrabold bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30 uppercase tracking-widest shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shadow-[0_0_5px_rgba(245,158,11,0.5)] animate-pulse"></span>
                                            {{ strtoupper($internship->status) }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Container Kanan: Progres -->
                                <div class="w-full lg:w-[25%] flex items-center justify-end gap-5 border-t border-slate-100 dark:border-slate-800/60 lg:border-t-0 pt-4 lg:pt-0">
                                    @php
                                        $startDate = $internship->start_date ? \Carbon\Carbon::parse($internship->start_date) : null;
                                        $endDate = $internship->end_date ? \Carbon\Carbon::parse($internship->end_date) : now();
                                        $totalDates = $startDate ? $startDate->diffInWeekdays($endDate) : 0;
                                        $approvedLogbooks = $internship->dailyLogbooks()->where('status', 'approved')->count();
                                        $progress = $totalDates > 0 ? min(100, round(($approvedLogbooks / $totalDates) * 100)) : 0;
                                    @endphp
                                    <div class="flex flex-col gap-1.5 w-full max-w-[14rem]">
                                        <div class="flex items-center justify-between text-[11px] font-bold">
                                            <span class="text-slate-500 dark:text-slate-400 font-medium">{{ $approvedLogbooks }} / {{ $totalDates }} Disetujui</span>
                                            <span class="text-{{ $accentColor }}-600 dark:text-{{ $accentColor }}-500">{{ $progress }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-100 dark:bg-[#1E293B]/70 rounded-full h-1.5 overflow-hidden border border-slate-200 dark:border-slate-700/50 shadow-inner">
                                            <div class="bg-{{ $accentColor }}-500 dark:bg-{{ $accentColor }}-500 h-full rounded-full transition-all duration-700 relative" style="width: {{ $progress }}%">
                                                <div class="absolute inset-0 bg-gradient-to-r from-transparent to-white/20"></div>
                                                <div class="absolute right-0 top-0 h-full w-2 bg-white/40 blur-[1px]"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-8 h-8 rounded-full border border-transparent group-hover:bg-slate-100 dark:group-hover:bg-[#1E293B]/80 group-hover:border-slate-200 dark:group-hover:border-slate-700/80 flex items-center justify-center transition-all duration-300 flex-shrink-0 hidden sm:flex">
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-{{ $accentColor }}-600 dark:group-hover:text-{{ $accentColor }}-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-24 text-center text-slate-500 dark:text-slate-400 bg-slate-50/50 dark:bg-slate-800/20 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700/50 m-2">
                                <div class="flex flex-col items-center justify-center gap-4">
                                    <div class="w-24 h-24 bg-white dark:bg-slate-800/80 rounded-[2rem] border border-slate-100 dark:border-slate-700/50 flex items-center justify-center shadow-sm mb-1 group-hover:scale-105 transition-transform duration-500">
                                        <svg class="w-12 h-12 text-slate-300 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-lg font-black text-slate-700 dark:text-slate-200 tracking-tight">Belum Ada Peserta</p>
                                        <p class="text-sm font-medium text-slate-400 mt-1 max-w-sm mx-auto leading-relaxed">Anda saat ini tidak memiliki peserta magang yang ditugaskan. Setelah admin menugaskan, intern akan otomatis muncul di sini.</p>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

    </div>

    </div>


    @push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }

        /* Premium Glint & Glass Effects */
        .glass-card-light {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
        }
        
        .hover-glint {
            position: relative;
            overflow: hidden;
        }
        
        .hover-glint::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0) 40%,
                rgba(255, 255, 255, 0.4) 50%,
                rgba(255, 255, 255, 0) 60%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(45deg);
            transition: all 0.7s;
            opacity: 0;
            pointer-events: none;
        }
        
        .hover-glint:hover::after {
            left: 100%;
            top: 100%;
            opacity: 1;
        }
    </style>
    @endpush
</x-app-layout>