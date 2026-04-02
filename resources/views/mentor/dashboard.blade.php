<x-app-layout>
    {{-- Main Scrollable Content Wrapper - Enforcing strict HTML structural fidelity --}}
    <div class="p-8 lg:p-10 max-w-7xl mx-auto space-y-10 w-full flex-1">
        
        <!-- Welcome Section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Here's the summary of your mentees for today, {{ now()->translatedFormat('l, M d') }}.</p>
            </div>
            
            @if(($pendingLogbooksCount ?? 0) > 0)
            <div class="flex gap-3">
                <a href="{{ route('mentor.approvals.index') }}" class="px-5 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all font-semibold text-sm shadow-lg shadow-red-500/30 hover:shadow-red-500/50 active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Validate {{ $pendingLogbooksCount }} Logbooks
                </a>
            </div>
            @endif
        </div>

        <!-- Premium Stats Grid - STRICT ALIGNMENT grid-cols-1 lg:grid-cols-2 gap-8 -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Stat 1: Total Interns -->
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl p-8 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.3)] dark:shadow-none relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 border border-slate-700/50">
                <div class="absolute -right-10 -top-10 w-48 h-48 bg-emerald-500/20 rounded-full blur-3xl group-hover:bg-emerald-500/30 group-hover:scale-110 transition-all duration-500"></div>
                <div class="absolute right-0 bottom-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.8)]"></span>
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Intern Aktif</p>
                        </div>
                        <h3 class="text-6xl font-black text-white tracking-tighter">{{ $internships->where('status', 'active')->count() }}</h3>
                    </div>
                    <div class="p-4 bg-white/5 backdrop-blur-md rounded-2xl text-white border border-white/10 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                
                <div class="mt-8 relative z-10">
                    <div class="flex items-center gap-3 text-sm">
                        @if($internships->where('status', 'active')->count() > 0)
                            <span class="flex items-center text-white font-bold bg-white/10 backdrop-blur-md px-3 py-1 rounded-lg border border-white/10">
                                Across {{ $internships->where('status', 'active')->pluck('division_id')->unique()->count() }} Divisi
                            </span>
                            <a href="{{ route('mentor.students.index', ['status' => 'active']) }}" class="text-slate-400 font-medium hover:text-white transition-colors cursor-pointer flex items-center gap-1 group/link text-xs">
                                View details <svg class="w-3.5 h-3.5 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @else
                            <span class="text-slate-400 font-medium">Belum Ada Intern Aktif.</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stat 2: Pending Validations -->
            <div class="bg-gradient-to-br from-red-600 to-red-800 rounded-3xl p-8 shadow-[0_10px_40px_-10px_rgba(220,38,38,0.4)] dark:shadow-none relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 border border-red-500/30">
                <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-orange-500/30 rounded-full blur-3xl group-hover:bg-orange-500/40 group-hover:scale-110 transition-all duration-500"></div>
                <div class="absolute right-10 top-10 w-32 h-32 bg-rose-500/20 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 flex items-start justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full {{ ($pendingLogbooksCount ?? 0) > 0 ? 'bg-orange-400 shadow-[0_0_10px_rgba(251,146,60,0.8)]' : 'bg-red-400/50' }}"></span>
                            <p class="text-[11px] font-black text-red-200 uppercase tracking-widest">Membutuhkan Validasi</p>
                        </div>
                        <h3 class="text-6xl font-black text-white tracking-tighter">{{ $pendingLogbooksCount ?? 0 }}</h3>
                    </div>
                    <div class="p-4 bg-black/10 backdrop-blur-md rounded-2xl text-white border border-white/20 group-hover:scale-110 transition-transform duration-300 shadow-xl">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                
                <div class="mt-8 relative z-10">
                    <div class="flex items-center flex-wrap gap-2 text-sm">
                        @if(($pendingLogbooksCount ?? 0) > 0)
                            <span class="flex items-center text-white font-bold bg-black/20 backdrop-blur-md px-3 py-1 rounded-lg border border-white/10 text-xs shadow-inner">
                                {{ $pendingLogbooksCount ?? 0 }} Logbooks
                            </span>
                            <a href="{{ route('mentor.approvals.index') }}" class="text-red-200 mt-2 sm:mt-0 sm:ml-2 font-medium hover:text-white transition-colors cursor-pointer flex items-center gap-1 group/link text-xs">
                                Validate now <svg class="w-3.5 h-3.5 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @else
                            <span class="text-red-200 font-medium text-sm normal tracking-wide">All logbooks are validated!</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Content Grid: Mentees and Pending Logbooks -->
        <div class="grid grid-cols-1 gap-8 items-start" x-data="{ searchQuery: '' }">
            
            <!-- Left: Mentees List (Full width) -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-slate-100 dark:border-slate-800 overflow-hidden h-[540px] flex flex-col group/mentees transition-all duration-300 hover:shadow-xl">
                <div class="px-7 py-6 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-transparent relative z-10 font-sans">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800 dark:text-white tracking-tight">Intern Aktif</h3>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">Kelola dan pantau progres dari interns</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative hidden sm:block">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" x-model="searchQuery" placeholder="Cari Intern..." class="pl-9 pr-4 py-2 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all dark:text-white w-full sm:w-64">
                    </div>
                    <a href="{{ route('mentor.students.index') }}" class="p-2 border border-slate-200 dark:border-slate-800 rounded-lg text-slate-500 hover:text-red-600 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors" title="View all Interns">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </a>
                </div>
            </div>
            
            <div class="overflow-y-auto flex-1 custom-scrollbar mt-2">
                <div class="divide-y divide-slate-100 dark:divide-slate-800/60">
                    @forelse($internships as $internship)
                        @php
                            $isSmk = optional(optional($internship->student)->studentProfile)->student_type === 'siswa' || optional(optional($internship->student)->studentProfile)->education_level === 'SMK';
                            $colorStyles = $isSmk ? 'from-amber-400/20 to-orange-500/20 text-amber-600 dark:text-amber-400 ring-amber-100 dark:ring-amber-500/20' : 'from-emerald-400/20 to-teal-500/20 text-emerald-600 dark:text-emerald-400 ring-emerald-100 dark:ring-emerald-500/20';
                            $accentColor = $isSmk ? 'amber' : 'emerald';
                        @endphp

                        <div x-show="!searchQuery || '{{ strtolower(optional($internship->student)->name ?? '') }}'.includes(searchQuery.toLowerCase())" 
                             onclick="window.location='{{ route('mentor.students.show', $internship->id) }}'" 
                             class="p-5 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors group relative cursor-pointer">
                            
                            <!-- Edge Hover Indicator -->
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-{{ $accentColor }}-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                            <!-- Name & Avatar -->
                            <div class="flex items-center gap-4 min-w-[280px] z-10 w-full lg:w-auto">
                                <div class="relative flex-shrink-0">
                                    @if(optional(optional($internship->student)->studentProfile)->photo)
                                        <img class="h-12 w-12 rounded-full object-cover shadow-inner ring-4 ring-white dark:ring-slate-900 group-hover:scale-105 transition-transform" 
                                             src="{{ asset('storage/' . $internship->student->studentProfile->photo) }}" 
                                             alt="{{ optional($internship->student)->name }}">
                                    @else
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-tr {{ $colorStyles }} flex items-center justify-center font-black text-xl shadow-inner ring-4 ring-white dark:ring-slate-900 group-hover:scale-105 transition-transform">
                                            {{ strtoupper(substr(optional($internship->student)->name ?? 'U', 0, 1)) }}
                                        </div>
                                    @endif
                                    
                                    @if($internship->status == 'active')
                                        <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full ring-2 ring-white dark:ring-slate-900 bg-emerald-500"></span>
                                    @endif
                                </div>
                                <div class="min-w-0 pr-4">
                                    <h3 class="font-bold text-slate-800 dark:text-white text-base leading-tight group-hover:text-{{ $accentColor }}-600 dark:group-hover:text-{{ $accentColor }}-400 transition-colors truncate" title="{{ optional($internship->student)->name }}">
                                        {{ optional($internship->student)->name ?? 'Unknown Student' }}
                                    </h3>
                                    <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400 mt-0.5 truncate" title="{{ optional(optional($internship->student)->studentProfile)->university ?? 'Universitas Tidak Diketahui' }}">
                                        {{ optional(optional($internship->student)->studentProfile)->university ?? 'Universitas Tidak Diketahui' }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Contextual Information -->
                            <div class="flex-1 flex flex-col sm:flex-row items-start sm:items-center justify-start lg:justify-end gap-4 lg:gap-8 w-full lg:w-auto mt-2 lg:mt-0">
                                
                                <!-- Division -->
                                <div class="min-w-[120px] hidden sm:block relative text-left">
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        Divisi
                                    </p>
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 transition-colors">
                                        {{ optional($internship->division)->name ?? 'No Divisi' }}
                                    </span>
                                </div>

                                <!-- Status -->
                                <div class="min-w-[100px] hidden md:block relative text-left">
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Status
                                    </p>
                                    @if($internship->status == 'active')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-[10px] font-bold bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50 uppercase tracking-widest">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_5px_rgba(16,185,129,0.5)]"></span>
                                            Aktif
                                        </span>
                                    @elseif($internship->status == 'finished')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 uppercase tracking-widest">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md text-[10px] font-bold bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800/50 uppercase tracking-widest animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            {{ $internship->status }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Logbooks -->
                                <div class="min-w-[130px] hidden sm:block relative text-right lg:text-left">
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center lg:justify-start justify-end gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        Logbooks
                                    </p>
                                    @php
                                        $startDate = $internship->start_date ? \Carbon\Carbon::parse($internship->start_date) : null;
                                        $endDate = $internship->end_date ? \Carbon\Carbon::parse($internship->end_date) : now();
                                        $totalDates = $startDate ? $startDate->diffInWeekdays($endDate) : 0;
                                        $approvedLogbooks = $internship->dailyLogbooks()->where('status', 'approved')->count();
                                        $progress = $totalDates > 0 ? min(100, round(($approvedLogbooks / $totalDates) * 100)) : 0;
                                    @endphp
                                    <div class="flex flex-col gap-1.5 w-full lg:w-32">
                                        <div class="flex items-center justify-between text-[10px] font-bold">
                                            <span class="text-slate-500 dark:text-slate-400">{{ $approvedLogbooks }} / {{ $totalDates }} Approved</span>
                                            <span class="text-{{ $accentColor }}-600 dark:text-{{ $accentColor }}-400">{{ $progress }}%</span>
                                        </div>
                                        <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-{{ $accentColor }}-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Interactive Icon -->
                                <div class="hidden sm:flex items-center justify-center w-9 h-9 ml-2 rounded-full text-slate-400 group-hover:text-{{ $accentColor }}-500 group-hover:bg-{{ $accentColor }}-50 dark:group-hover:bg-{{ $accentColor }}-500/10 transition-all border border-transparent group-hover:border-{{ $accentColor }}-200 dark:group-hover:border-{{ $accentColor }}-500/20">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-16 text-center text-slate-500 dark:text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-slate-100 dark:border-slate-800 flex items-center justify-center shadow-inner mb-1">
                                    <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-base font-bold text-slate-600 dark:text-slate-300">No assigned interns</p>
                                    <p class="text-xs font-medium text-slate-400 mt-0.5">You do not have any interns assigned to you currently.</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

    </div>

    </div>
</x-app-layout>