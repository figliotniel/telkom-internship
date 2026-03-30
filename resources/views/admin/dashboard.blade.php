<x-app-layout>
    {{-- Dashboard Main Area (New Layout Structure Matching HTML Reference) --}}
    <div class="p-6 lg:p-10 max-w-7xl mx-auto space-y-10 w-full flex-1">
        
        {{-- Welcome Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Welcome back, {{ Auth::user()->name }} 👋</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Here's your summary for today, {{ \Carbon\Carbon::now()->format('l, M d') }}.</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="openAddMentorModal()" class="px-5 py-2.5 bg-red-600 dark:bg-red-600 text-white rounded-xl hover:bg-red-700 dark:hover:bg-red-700 transition-all font-semibold text-sm shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Mentor
                </button>
            </div>
        </div>

        {{-- 1. Stats Grid (Elevasi, Hierarki Tipografi, Hover, Aksen Ikon) 
             Using grid-cols-1 md:grid-cols-3 since the HTML reference 4-columns layout drops the 4th item (Logbook Rate) per your instruction 
        --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            {{-- Stat 1: Total Interns --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] dark:shadow-none hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] dark:hover:shadow-red-900/20 transition-all duration-300 relative overflow-hidden group border border-slate-100 dark:border-slate-800">
                <div class="absolute top-0 left-0 w-full h-1 bg-red-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="flex items-start justify-between">
                    <div class="relative z-10 text-left">
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Total Interns</p>
                        <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">{{ $totalStudents }}</h3>
                    </div>
                    <div class="p-3.5 bg-red-50 dark:bg-red-500/10 rounded-xl text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform duration-300 ring-1 ring-red-100 dark:ring-red-500/20 relative z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                
                <div class="mt-5 flex items-center text-sm relative z-10">
                    @if($studentGrowth > 0)
                        <span class="flex items-center text-emerald-500 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-500/10 px-2 py-0.5 rounded-md text-xs border border-emerald-100 dark:border-emerald-500/20">
                            <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            +{{ $studentGrowth }}
                        </span>
                        <span class="text-slate-400 dark:text-slate-500 ml-2 text-xs font-medium">this month</span>
                    @else
                        <span class="text-xs font-medium text-slate-400 dark:text-slate-500 italic">Stable data</span>
                    @endif
                </div>
                <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="absolute inset-0 z-10"></a>
            </div>

            {{-- Stat 2: Active Interns (Replacing Approvals from HTML to match real Admin metrics) --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] dark:shadow-none hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] dark:hover:shadow-emerald-900/20 transition-all duration-300 relative overflow-hidden group border border-slate-100 dark:border-slate-800">
                <div class="absolute top-0 left-0 w-full h-1 bg-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="flex items-start justify-between">
                    <div class="relative z-10 text-left">
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Active Interns</p>
                        <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">{{ $activeInternships }}</h3>
                    </div>
                    <div class="p-3.5 bg-emerald-50 dark:bg-emerald-500/10 rounded-xl text-emerald-500 dark:text-emerald-400 group-hover:scale-110 transition-transform duration-300 ring-1 ring-emerald-100 dark:ring-emerald-500/20 relative z-10">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="mt-5 flex items-center relative z-10">
                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-0.5 rounded-md border border-emerald-100 dark:border-emerald-500/20">Currently Active</span>
                </div>
                <a href="{{ route('admin.internships.index', ['status' => 'active']) }}" class="absolute inset-0 z-10"></a>
            </div>

            {{-- Stat 3: Total Mentors --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] dark:shadow-none hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] dark:hover:shadow-blue-900/20 transition-all duration-300 relative overflow-hidden group border border-slate-100 dark:border-slate-800">
                <div class="absolute top-0 left-0 w-full h-1 bg-blue-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="flex items-start justify-between">
                    <div class="relative z-10 text-left">
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Mentors</p>
                        <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">{{ $totalMentors }}</h3>
                    </div>
                    <div class="p-3.5 bg-blue-50 dark:bg-blue-500/10 rounded-xl text-blue-500 dark:text-blue-400 group-hover:scale-110 transition-transform duration-300 ring-1 ring-blue-100 dark:ring-blue-500/20 relative z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-5 flex items-center text-sm relative z-10">
                    @if($mentorGrowth > 0)
                        <span class="flex items-center text-emerald-500 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-500/10 px-2 py-0.5 rounded-md text-xs border border-emerald-100 dark:border-emerald-500/20">
                            <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            +{{ $mentorGrowth }} new
                        </span>
                        <span class="text-slate-400 dark:text-slate-500 ml-2 text-xs font-medium">this month</span>
                    @else
                        <span class="text-xs font-medium text-slate-400 dark:text-slate-500 italic">Stable count</span>
                    @endif
                </div>
                 <a href="{{ route('admin.users.index', ['role' => 'mentor']) }}" class="absolute inset-0 z-10"></a>
            </div>

        </div>

        {{-- 2. Content Sections Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left: Recent Activities (2 columns wide) --}}
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] dark:shadow-none border border-slate-100 dark:border-slate-800">
                <div class="px-7 py-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-transparent relative z-10">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Recent Internship Enrollments</h3>
                    <a href="{{ route('admin.internships.index') }}" class="text-sm font-semibold text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 flex items-center gap-1 group">
                        View All
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="h-[465px] overflow-y-auto divide-y divide-slate-100/80 dark:divide-slate-800/80 custom-scrollbar">
                    @forelse($recentInternships as $internship)
                    <div class="px-7 py-6 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between group cursor-pointer {{ $loop->last ? 'rounded-b-2xl' : '' }}" onclick="window.location='{{ route('admin.internships.show', $internship->id) }}'">
                        
                        <div class="flex items-center gap-4">
                            <div class="relative flex-shrink-0">
                                @if($internship->student->studentProfile && $internship->student->studentProfile->photo)
                                    <img src="{{ asset('storage/' . $internship->student->studentProfile->photo) }}" class="w-11 h-11 rounded-full border-2 border-white dark:border-slate-800 shadow-sm object-cover">
                                @else
                                    <div class="w-11 h-11 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold border-2 border-white dark:border-slate-800 shadow-sm">
                                        {{ substr(optional($internship->student)->name ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                                
                                @if($internship->status == 'active')
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white dark:border-slate-800 rounded-full"></div>
                                @elseif($internship->status == 'pending')
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-amber-500 border-2 border-white dark:border-slate-800 rounded-full"></div>
                                @elseif($internship->status == 'finished')
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-blue-500 border-2 border-white dark:border-slate-800 rounded-full"></div>
                                @else
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-slate-300 dark:bg-slate-600 border-2 border-white dark:border-slate-800 rounded-full"></div>
                                @endif
                            </div>
                            
                            <div class="flex flex-col">
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">
                                    {{ optional($internship->student)->name ?? 'Unknown User' }}
                                    <span class="text-slate-400 dark:text-slate-500 font-medium ml-1">
                                        @if($internship->status == 'active') is active @elseif($internship->status == 'pending') applied for @else is in @endif
                                    </span>
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5 font-medium">{{ $internship->division->name ?? '-' }} Role</p>
                            </div>
                        </div>
                        
                        <div class="mt-2 sm:mt-0 flex sm:flex-col items-center sm:items-end justify-between sm:justify-center w-full sm:w-auto pl-15 sm:pl-0">
                             <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] sm:hidden font-bold border shadow-sm transition-colors uppercase tracking-wider
                                    {{ $internship->status == 'active' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50' : 
                                        ($internship->status == 'pending' ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-200 dark:border-amber-800/50' : 
                                        ($internship->status == 'finished' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-200 dark:border-blue-800/50' : 'bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700/50')) }}">
                                    {{ $internship->status }}
                             </span>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">
                                {{ $internship->created_at ? $internship->created_at->diffForHumans() : '-' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="px-7 py-12 text-center">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-2">
                                <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-500 dark:text-slate-400">No recent activity found.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Right: Quick Actions / Need Attention (Dark Premium Aesthetic) --}}
            <div class="lg:h-[535px] bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl border border-slate-700 text-white overflow-hidden relative group">
                {{-- Decorative background elements --}}
                <div class="absolute -top-20 -right-20 w-48 h-48 bg-red-600 rounded-full blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-700 pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-blue-600 rounded-full blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-700 pointer-events-none"></div>

                <div class="px-7 py-7 border-b border-slate-700/50 relative z-10 flex items-center justify-between bg-transparent">
                    <h3 class="text-lg font-bold tracking-tight">Requires Attention</h3>
                    @if($pendingApplicants > 0 || $pendingExtensions->count() > 0)
                        <span class="flex h-2.5 w-2.5 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                        </span>
                    @endif
                </div>

                <div class="p-6 pb-10 space-y-4 relative z-10">
                    
                    {{-- Pending Applicants Card --}}
                    <a href="{{ $pendingApplicants > 0 ? route('admin.internships.index', ['status' => 'pending']) : '#' }}" 
                       class="block bg-[#1e293b]/70 backdrop-blur-sm border {{ $pendingApplicants > 0 ? 'border-amber-500/30' : 'border-slate-700/80' }} rounded-xl p-4 peer hover:border-amber-500/50 hover:bg-slate-800/80 transition-all shadow-sm group/card {{ $pendingApplicants == 0 ? 'cursor-default opacity-60' : 'cursor-pointer' }}">
                        
                        <div class="flex justify-between items-start mb-1.5">
                            <h4 class="font-bold text-sm text-slate-100 group-hover/card:text-amber-400 transition-colors">Pending Applications</h4>
                            <span class="{{ $pendingApplicants > 0 ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : 'bg-slate-800 text-slate-400 border-slate-700' }} text-[10px] font-bold px-2 py-0.5 rounded-md border">
                                {{ $pendingApplicants }} Waiting
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed font-medium">Review new internship applications.</p>
                        
                        @if($pendingApplicants > 0)
                            <div class="mt-3 flex items-center text-[11px] font-bold text-amber-500 opacity-0 group-hover/card:opacity-100 transition-opacity transform translate-y-1 group-hover/card:translate-y-0 uppercase tracking-wider">
                                Review Now <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                        @else
                            <div class="mt-3 flex items-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">All Clear</div>
                        @endif
                    </a>

                    {{-- Finished Internships Card --}}
                    <div class="relative group/card-parent">
                        <a href="{{ $finishedInternsCount > 0 ? route('admin.internships.index', ['status' => 'finished']) : '#' }}" 
                           class="block bg-[#1e293b]/70 backdrop-blur-sm border {{ $finishedInternsCount > 0 ? 'border-blue-500/30' : 'border-slate-700/80' }} rounded-xl p-4 hover:border-blue-500/50 hover:bg-slate-800/80 transition-all shadow-sm group/card {{ $finishedInternsCount == 0 ? 'cursor-default opacity-60' : 'cursor-pointer' }}">
                            <div class="flex justify-between items-start mb-1.5">
                                <h4 class="font-bold text-sm text-slate-100 group-hover/card:text-blue-400 transition-colors">Finished Internships</h4>
                                <span class="{{ $finishedInternsCount > 0 ? 'bg-blue-500/10 text-blue-400 border-blue-500/20' : 'bg-slate-800 text-slate-400 border-slate-700' }} text-[10px] font-bold px-2 py-0.5 rounded-md border">
                                    {{ $finishedInternsCount }} Ended
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 leading-relaxed font-medium">Prepare completion documents and certificates.</p>
                            
                            @if($finishedInternsCount > 0)
                                <div class="mt-3 flex items-center text-[11px] font-bold text-blue-500 opacity-0 group-hover/card:opacity-100 transition-opacity transform translate-y-1 group-hover/card:translate-y-0 uppercase tracking-wider">
                                    View List <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            @else
                                <div class="mt-3 flex items-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">All Clear</div>
                            @endif
                        </a>
                    </div>

                    {{-- Pending Extensions Card --}}
                    <a href="{{ $pendingExtensions->count() > 0 ? route('admin.internships.index', ['status' => 'extension']) : '#' }}" 
                       class="block bg-[#1e293b]/70 backdrop-blur-sm border {{ $pendingExtensions->count() > 0 ? 'border-amber-500/30' : 'border-slate-700/80' }} rounded-xl p-4 peer hover:border-amber-500/50 hover:bg-slate-800/80 transition-all shadow-sm group/card {{ $pendingExtensions->count() == 0 ? 'cursor-default opacity-60' : 'cursor-pointer' }}">
                        <div class="flex justify-between items-start mb-1.5">
                            <h4 class="font-bold text-sm text-slate-100 group-hover/card:text-amber-400 transition-colors">Extension Requests</h4>
                            <span class="{{ $pendingExtensions->count() > 0 ? 'bg-amber-500/10 text-amber-400 border-amber-500/20' : 'bg-slate-800 text-slate-400 border-slate-700' }} text-[10px] font-bold px-2 py-0.5 rounded-md border">
                                {{ $pendingExtensions->count() }} Requests
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed font-medium">Review time extension requests.</p>
                        @if($pendingExtensions->count() > 0)
                            <div class="mt-3 flex items-center text-[11px] font-bold text-amber-500 opacity-0 group-hover/card:opacity-100 transition-opacity transform translate-y-1 group-hover/card:translate-y-0 uppercase tracking-wider">
                                Review Now <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                         @else
                            <div class="mt-3 flex items-center text-[11px] font-bold text-slate-500 uppercase tracking-wider">All Clear</div>
                        @endif
                    </a>
                </div>
            </div>
            
        </div>

    </div>

    <!-- Add Mentor Modal (Premium Glassmorphism Design) -->
    <div id="addMentorModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        
        <!-- Modal Container -->
        <div class="bg-white/70 dark:bg-slate-900/75 backdrop-blur-xl border border-white/40 dark:border-white/5 w-full max-w-6xl rounded-[2rem] shadow-2xl transform scale-95 transition-all duration-300 flex flex-col md:flex-row overflow-hidden max-h-[90vh] ring-1 ring-white/20 dark:ring-white/10" id="addMentorModalContent">
            
            <!-- ========================================== -->
            <!-- LEFT SIDE: List of existing mentors -->
            <!-- ========================================== -->
            <div class="w-full md:w-5/12 lg:w-4/12 flex flex-col bg-white/40 dark:bg-slate-900/40 relative border-b md:border-b-0 md:border-r border-slate-200/50 dark:border-slate-700/50">
                
                <!-- Header Left -->
                <div class="px-8 py-6 border-b border-slate-200/50 dark:border-slate-700/50 flex justify-between items-center sticky top-0 backdrop-blur-xl z-20">
                    <div>
                        <h3 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">Daftar Mentor</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Pembimbing aktif divisi</p>
                    </div>
                    <div class="px-3 py-1.5 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 text-xs font-black rounded-xl border border-red-100 dark:border-red-500/20 shadow-sm">
                        {{ $mentorsList->count() }} Mentor
                    </div>
                </div>

                <!-- List Area (Scrollable) -->
                <div class="p-6 overflow-y-auto custom-scrollbar flex-1 space-y-4 max-h-[26rem]">
                    @forelse($mentorsList as $mentor)
                        <div class="group relative bg-white dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-4 flex items-center gap-4 hover:shadow-xl hover:shadow-red-500/10 hover:border-red-300 dark:hover:border-red-500/50 hover:-translate-y-1 transition-all duration-300">
                            <div class="w-12 h-12 rounded-[1rem] bg-gradient-to-br from-red-500 to-red-400 flex items-center justify-center text-white font-bold text-lg shadow-inner shrink-0 ring-2 ring-white dark:ring-slate-900">
                                {{ substr($mentor->name, 0, 1) }}
                            </div>
                            <div class="min-w-0 flex-1 relative">
                                <h4 class="font-bold text-slate-900 dark:text-slate-100 text-sm truncate group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">{{ $mentor->name }}</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate mt-0.5">{{ $mentor->email }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-[9px] px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-md font-bold uppercase tracking-wider">{{ optional($mentor->mentorProfile)->position ?? 'Mentor' }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada data mentor.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ========================================== -->
            <!-- RIGHT SIDE: Form Add Mentor -->
            <!-- ========================================== -->
            <div class="w-full md:w-7/12 lg:w-8/12 flex flex-col bg-white dark:bg-slate-900 relative">
                
                <!-- Close Button (Absolute Top Right) -->
                <button type="button" onclick="closeAddMentorModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-700 dark:hover:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-full p-2.5 transition-all focus:outline-none z-30 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <!-- Form Header -->
                <div class="px-10 pt-10 pb-6 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-red-50 dark:bg-red-500/10 flex items-center justify-center text-red-600 dark:text-red-400 border border-red-100 dark:border-red-500/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Tambah Mentor Baru</h2>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Buat akun untuk pembimbing magang dengan kredensial baru.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Form Scrollable Area -->
                <div class="px-10 py-8 overflow-y-auto custom-scrollbar flex-1">
                    <form action="{{ route('admin.mentors.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Form Grid -->
                        <div class="grid grid-cols-1 gap-6">
                            
                            <!-- Nama Lengkap (Full Width) -->
                            <div class="group/input transition-transform duration-300 focus-within:-translate-y-0.5">
                                <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <input type="text" name="name" required placeholder="Masukkan nama lengkap" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 hover:border-slate-300 dark:hover:border-slate-700 transition-all shadow-sm">
                                </div>
                            </div>
                            
                            <!-- Grid Setengah (Email & Password) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Email -->
                                <div class="group/input transition-transform duration-300 focus-within:-translate-y-0.5">
                                    <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2">Email <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <input type="email" name="email" required placeholder="mentor@telkom.co.id" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 hover:border-slate-300 dark:hover:border-slate-700 transition-all shadow-sm">
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="group/input transition-transform duration-300 focus-within:-translate-y-0.5">
                                    <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2">Password <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        </div>
                                        <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 hover:border-slate-300 dark:hover:border-slate-700 transition-all shadow-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Jabatan (Full Width instead of half with NIK) -->
                            <div class="group/input transition-transform duration-300 focus-within:-translate-y-0.5">
                                <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2">Jabatan (Posisi) <span class="text-red-500">*</span></label>
                                <input type="text" name="position" required placeholder="Contoh: Officer 2" class="w-full px-5 py-3.5 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 hover:border-slate-300 dark:hover:border-slate-700 transition-all shadow-sm">
                            </div>
                        </div>

                        <!-- Footer Action -->
                        <div class="pt-8 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-4">
                            <button type="button" onclick="closeAddMentorModal()" class="px-6 py-3.5 text-slate-600 dark:text-slate-400 font-bold hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl transition-colors text-sm">
                                Batal
                            </button>
                            <button type="submit" class="px-8 py-3.5 bg-red-600 text-white rounded-2xl hover:bg-red-700 transition-all font-bold text-sm shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] active:scale-95 flex items-center gap-2">
                                Simpan Data
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>

                    </form>
                </div>
                
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        const addMentorModal = document.getElementById('addMentorModal');
        const addMentorModalContent = document.getElementById('addMentorModalContent');

        function openAddMentorModal() {
            addMentorModal.classList.remove('opacity-0', 'pointer-events-none');
            addMentorModalContent.classList.remove('scale-95');
            addMentorModalContent.classList.add('scale-100');
        }

        function closeAddMentorModal() {
            addMentorModal.classList.add('opacity-0', 'pointer-events-none');
            addMentorModalContent.classList.remove('scale-100');
            addMentorModalContent.classList.add('scale-95');
        }

        function showInfoModal(title, text) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'info',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
            });
        }
    </script>
    @endpush
</x-app-layout>