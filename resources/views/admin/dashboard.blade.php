<x-app-layout>
    {{-- Dashboard Main Area (New Layout Structure) --}}
    <div class="max-w-7xl mx-auto space-y-10">
        
        {{-- Welcome Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Welcome back, {{ Auth::user()->name }} 👋</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Here's your summary for today, {{ \Carbon\Carbon::now()->format('l, M d') }}.</p>
            </div>
            <div class="flex gap-3">
                 <a href="{{ route('admin.internships.index') }}" class="px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition-all font-semibold text-sm shadow-sm hover:shadow active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    View Interns
                </a>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Stat 1: Total Interns --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] dark:shadow-none hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] dark:hover:shadow-red-900/20 transition-all duration-300 relative overflow-hidden group border border-slate-100 dark:border-slate-800">
                <div class="absolute top-0 left-0 w-full h-1 bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Total Interns</p>
                        <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">{{ $totalStudents }}</h3>
                    </div>
                    <div class="p-3.5 bg-red-50 dark:bg-red-500/10 rounded-xl text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform duration-300 ring-1 ring-red-100 dark:ring-red-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                
                <div class="mt-5 flex items-center text-sm relative z-10">
                    @if($studentGrowth > 0)
                        <span class="flex items-center text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-500/10 px-2 py-0.5 rounded-md text-xs border border-emerald-100 dark:border-emerald-500/20">
                            <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            +{{ $studentGrowth }}
                        </span>
                        <span class="text-slate-400 dark:text-slate-500 ml-2 text-xs font-medium">Orang Baru</span>
                    @else
                        <span class="text-xs font-medium text-slate-400 dark:text-slate-500 italic">Data Stabil</span>
                    @endif
                </div>
                <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="absolute inset-0 z-10"></a>
            </div>

            {{-- Stat 2: Active Interns --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] dark:shadow-none hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] dark:hover:shadow-emerald-900/20 transition-all duration-300 relative overflow-hidden group border border-slate-100 dark:border-slate-800">
                <div class="absolute top-0 left-0 w-full h-1 bg-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Active Interns</p>
                        <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">{{ $activeInternships }}</h3>
                    </div>
                    <div class="p-3.5 bg-emerald-50 dark:bg-emerald-500/10 rounded-xl text-emerald-500 dark:text-emerald-400 group-hover:scale-110 transition-transform duration-300 ring-1 ring-emerald-100 dark:ring-emerald-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="mt-5 flex items-center text-sm relative z-10">
                    @if($internshipGrowth > 0)
                        <span class="flex items-center text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-500/10 px-2 py-0.5 rounded-md text-xs border border-emerald-100 dark:border-emerald-500/20">
                            <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            +{{ $internshipGrowth }}
                        </span>
                        <span class="text-slate-400 dark:text-slate-500 ml-2 text-xs font-medium">Posisi Aktif</span>
                    @else
                        <span class="text-xs font-medium text-slate-400 dark:text-slate-500 italic">Data Stabil</span>
                    @endif
                </div>
                <a href="{{ route('admin.internships.index', ['status' => 'active']) }}" class="absolute inset-0 z-10"></a>
            </div>

            {{-- Stat 3: Total Mentors --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] dark:shadow-none hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] dark:hover:shadow-blue-900/20 transition-all duration-300 relative overflow-hidden group border border-slate-100 dark:border-slate-800">
                <div class="absolute top-0 left-0 w-full h-1 bg-blue-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Mentors</p>
                        <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">{{ $totalMentors }}</h3>
                    </div>
                    <div class="p-3.5 bg-blue-50 dark:bg-blue-500/10 rounded-xl text-blue-500 dark:text-blue-400 group-hover:scale-110 transition-transform duration-300 ring-1 ring-blue-100 dark:ring-blue-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                </div>
                <div class="mt-5 flex items-center text-sm relative z-10">
                    @if($mentorGrowth > 0)
                        <span class="flex items-center text-emerald-600 dark:text-emerald-400 font-bold bg-emerald-50 dark:bg-emerald-500/10 px-2 py-0.5 rounded-md text-xs border border-emerald-100 dark:border-emerald-500/20">
                            <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            +{{ $mentorGrowth }}
                        </span>
                        <span class="text-slate-400 dark:text-slate-500 ml-2 text-xs font-medium">Mentor Baru</span>
                    @else
                        <span class="text-xs font-medium text-slate-400 dark:text-slate-500 italic">Tim Mentor Stabil</span>
                    @endif
                </div>
                 <a href="{{ route('admin.users.index', ['role' => 'mentor']) }}" class="absolute inset-0 z-10"></a>
            </div>

            {{-- Stat 4: Logbook Rate (Placeholder / Visual Filler from Mockup) --}}
            <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] dark:shadow-none hover:-translate-y-1 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] dark:hover:shadow-indigo-900/20 transition-all duration-300 relative overflow-hidden group border border-slate-100 dark:border-slate-800">
                <div class="absolute top-0 left-0 w-full h-1 bg-indigo-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Overview</p>
                        <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Data</h3>
                    </div>
                    <div class="p-3.5 bg-indigo-50 dark:bg-indigo-500/10 rounded-xl text-indigo-500 dark:text-indigo-400 group-hover:scale-110 transition-transform duration-300 ring-1 ring-indigo-100 dark:ring-indigo-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                <div class="mt-6">
                    <div class="flex justify-between items-end mb-1.5">
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">System Health</span>
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">100%</span>
                    </div>
                    <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-1.5">
                        <div class="bg-gradient-to-r from-indigo-400 to-indigo-500 h-1.5 rounded-full relative" style="width: 100%">
                            <div class="absolute right-0 top-0 bottom-0 w-1.5 bg-white/40 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Sections Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            
            {{-- Left Column: Recent Activity (Takes up 2 cols) --}}
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] dark:shadow-none border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="px-7 py-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-transparent relative z-10">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Recent Internship Enrollments</h3>
                    <a href="{{ route('admin.internships.index') }}" class="text-sm font-semibold text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 flex items-center gap-1 group">
                        View All
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-800">
                        <thead class="bg-slate-50/50 dark:bg-slate-950/50">
                            <tr>
                                <th scope="col" class="px-7 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Student</th>
                                <th scope="col" class="px-7 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Division</th>
                                <th scope="col" class="px-7 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Status</th>
                                <th scope="col" class="px-7 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/80 dark:divide-slate-800/80">
                            @forelse($recentInternships as $internship)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors group cursor-pointer">
                                <td class="px-7 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold border border-slate-200 dark:border-slate-700">
                                            {{ substr($internship->student->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">{{ $internship->student->name }}</div>
                                            <div class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $internship->student->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-7 py-4 whitespace-nowrap text-sm font-medium text-slate-600 dark:text-slate-300">
                                    {{ $internship->division->name ?? '-' }}
                                </td>
                                <td class="px-7 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold border shadow-sm transition-colors uppercase tracking-wider
                                        {{ $internship->status == 'active' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50' : 
                                            ($internship->status == 'pending' ? 'bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 border-red-200 dark:border-red-800/50' : 
                                            ($internship->status == 'finished' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-200 dark:border-blue-800/50' : 'bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700/50')) }}">
                                        {{ $internship->status }}
                                    </span>
                                </td>
                                <td class="px-7 py-4 whitespace-nowrap text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">
                                    {{ $internship->created_at->format('d M Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-7 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-2">
                                            <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        </div>
                                        <p class="text-sm font-bold text-slate-500 dark:text-slate-400">No recent activity found.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

             {{-- Right Column: Requires Attention (Premium Dark Aesthetic) --}}
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl shadow-xl border border-slate-700 text-white overflow-hidden relative group">
                {{-- Decorative background elements --}}
                <div class="absolute -top-20 -right-20 w-48 h-48 bg-red-600 rounded-full blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-700 pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-amber-600 rounded-full blur-3xl opacity-20 group-hover:opacity-30 transition-opacity duration-700 pointer-events-none"></div>

                <div class="px-7 py-5 border-b border-slate-700/50 relative z-10 flex items-center justify-between">
                    <h3 class="text-lg font-bold tracking-tight">Requires Attention</h3>
                    @if($pendingApplicants > 0 || $pendingExtensions->count() > 0)
                        <span class="flex h-2.5 w-2.5 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                        </span>
                    @endif
                </div>
                
                <div class="p-6 space-y-4 relative z-10">
                    
                    {{-- Pending Applicants Card --}}
                    <a href="{{ $pendingApplicants > 0 ? route('admin.internships.index', ['status' => 'pending']) : '#' }}" 
                       class="block bg-[#1e293b]/70 backdrop-blur-sm border {{ $pendingApplicants > 0 ? 'border-red-500/30' : 'border-slate-700/80' }} rounded-xl p-4 hover:border-red-500/50 hover:bg-slate-800/80 transition-all shadow-sm group/card relative {{ $pendingApplicants == 0 ? 'cursor-default opacity-60' : '' }}">
                        <div class="flex justify-between items-start mb-1.5">
                            <h4 class="font-bold text-sm text-slate-100 group-hover/card:text-red-400 transition-colors">Pending Applications</h4>
                            <span class="{{ $pendingApplicants > 0 ? 'bg-red-500/20 text-red-400 border border-red-500/30' : 'bg-slate-700 text-slate-400' }} text-[10px] font-bold px-2 py-0.5 rounded-md">
                                {{ $pendingApplicants }} Waiting
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed font-medium">Review and approve recently submitted applications to join the program.</p>
                        @if($pendingApplicants > 0)
                            <div class="mt-3 flex items-center text-[11px] font-bold text-red-400 opacity-0 group-hover/card:opacity-100 transition-opacity transform translate-y-1 group-hover/card:translate-y-0">
                                Review Now <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                        @endif
                    </a>

                    {{-- Pending Extensions Card --}}
                    <a href="{{ $pendingExtensions->count() > 0 ? route('admin.internships.index', ['status' => 'extension']) : '#' }}" 
                       class="block bg-[#1e293b]/70 backdrop-blur-sm border {{ $pendingExtensions->count() > 0 ? 'border-amber-500/30' : 'border-slate-700/80' }} rounded-xl p-4 hover:border-amber-500/50 hover:bg-slate-800/80 transition-all shadow-sm group/card relative {{ $pendingExtensions->count() == 0 ? 'cursor-default opacity-60' : '' }}">
                        <div class="flex justify-between items-start mb-1.5">
                            <h4 class="font-bold text-sm text-slate-100 group-hover/card:text-amber-400 transition-colors">Extension Requests</h4>
                            <span class="{{ $pendingExtensions->count() > 0 ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-slate-700 text-slate-400' }} text-[10px] font-bold px-2 py-0.5 rounded-md">
                                {{ $pendingExtensions->count() }} Requests
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed font-medium">Review time extension requests submitted by active interns.</p>
                        @if($pendingExtensions->count() > 0)
                            <div class="mt-3 flex items-center text-[11px] font-bold text-amber-400 opacity-0 group-hover/card:opacity-100 transition-opacity transform translate-y-1 group-hover/card:translate-y-0">
                                Review Now <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                        @endif
                    </a>
                </div>
            </div>
            
        </div>
    </div>
    
    @include('admin.internships.partials.extension-modal')

    @push('scripts')
    <script>
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
                    confirmButton: 'px-6 py-2.5 mx-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
            });
        }
    </script>
    @endpush
</x-app-layout>