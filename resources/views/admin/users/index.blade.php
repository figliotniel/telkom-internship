<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 dark:text-slate-200 leading-tight transition-colors hidden">
            {{ __('Data User') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-950 min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Page Title Area -->
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Data User</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Manage all registered users, roles, and access across the application.</p>
            </div>

            <!-- Main Container -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors duration-300">
                <div class="p-8">
                    
                    <!-- Controls Row: Tabs & Actions -->
                    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 border-b border-slate-100 dark:border-slate-800 pb-6 mb-6 transition-colors">
                        
                        <!-- Premium Tabs -->
                        <nav class="flex space-x-2 overflow-x-auto w-full lg:w-auto pb-2 lg:pb-0" aria-label="Tabs">
                            {{-- Semua --}}
                            <a href="{{ route('admin.users.index') }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap {{ !request('role') ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Semua
                                <span class="ml-2 {{ !request('role') ? 'bg-white dark:bg-slate-800 text-red-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }} dark:text-red-400 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm dark:border dark:border-slate-700">{{ $totalAll }}</span>
                            </a>

                            {{-- Intern --}}
                            <a href="{{ route('admin.users.index', ['role' => 'student']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap {{ request('role') == 'student' ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Intern
                                <span class="ml-2 {{ request('role') == 'student' ? 'bg-white dark:bg-slate-800 text-red-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }} dark:text-red-400 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm dark:border dark:border-slate-700">{{ $totalStudents }}</span>
                            </a>

                            {{-- Mentor --}}
                            <a href="{{ route('admin.users.index', ['role' => 'mentor']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap {{ request('role') == 'mentor' ? 'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-100 dark:border-red-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Mentor
                                <span class="ml-2 {{ request('role') == 'mentor' ? 'bg-white dark:bg-slate-800 text-red-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }} dark:text-red-400 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm dark:border dark:border-slate-700">{{ $totalMentors }}</span>
                            </a>
                        </nav>
                        
                        <!-- Actions & Filters -->
                        <div class="flex flex-col sm:flex-row flex-wrap items-center justify-end gap-4 w-full lg:w-auto">
                            {{-- Sub Filter for Interns --}}
                            @if(request('role') == 'student')
                                <div class="inline-flex bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-1 shrink-0" role="group">
                                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['student_type' => request('student_type') == 'mahasiswa' ? null : 'mahasiswa', 'page' => null])) }}"
                                        class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all 
                                        {{ request('student_type') == 'mahasiswa' 
                                            ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 shadow-sm' 
                                            : 'text-gray-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-red-600 dark:hover:text-red-400' }}">
                                        MHS ({{ $studentMahasiswaCount }})
                                    </a>
                                    <a href="{{ route('admin.users.index', array_merge(request()->query(), ['student_type' => request('student_type') == 'smk' ? null : 'smk', 'page' => null])) }}" 
                                        class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all 
                                        {{ request('student_type') == 'smk' 
                                            ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 shadow-sm' 
                                            : 'text-gray-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-red-600 dark:hover:text-red-400' }}">
                                        SMK ({{ $studentSmkCount }})
                                    </a>
                                </div>
                            @endif

                            <!-- Search -->
                            <form action="{{ route('admin.users.index') }}" method="GET" class="relative w-full sm:w-64" x-data x-ref="form">
                                @if(request('role'))
                                    <input type="hidden" name="role" value="{{ request('role') }}">
                                @endif
                                @if(request('student_type'))
                                    <input type="hidden" name="student_type" value="{{ request('student_type') }}">
                                @endif
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Search..." 
                                    @input.debounce.500ms="$refs.form.submit()"
                                    x-init="$el.focus(); $el.setSelectionRange($el.value.length, $el.value.length);"
                                    class="pl-9 pr-4 py-2.5 w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 outline-none transition-all placeholder-slate-400 font-medium text-slate-700 dark:text-slate-300">
                            </form>
                        </div>
                    </div>


                    <!-- Modern Stacked List -->
                    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm mt-6">
                        <div class="divide-y divide-slate-100 dark:divide-slate-800/60">
                            @forelse ($users as $user)
                                @php
                                    $roleColors = [
                                        'admin' => 'from-purple-500/20 to-indigo-500/20 text-purple-600 dark:text-purple-400 ring-purple-100 dark:ring-purple-500/20',
                                        'mentor' => 'from-blue-500/20 to-cyan-500/20 text-blue-600 dark:text-blue-400 ring-blue-100 dark:ring-blue-500/20',
                                        'student' => 'from-emerald-400/20 to-teal-500/20 text-emerald-600 dark:text-emerald-400 ring-emerald-100 dark:ring-emerald-500/20',
                                    ];
                                    $isSmk = optional($user->studentProfile)->student_type === 'siswa' || optional($user->studentProfile)->education_level === 'SMK';
                                    if ($user->role === 'student' && $isSmk) {
                                        $roleColors['student'] = 'from-amber-400/20 to-orange-500/20 text-amber-600 dark:text-amber-400 ring-amber-100 dark:ring-amber-500/20';
                                    }
                                    $colorStyles = $roleColors[$user->role] ?? 'from-slate-400/20 to-slate-500/20 text-slate-600 dark:text-slate-400 ring-slate-100 dark:ring-slate-800';
                                    
                                    $accentColor = 'slate';
                                    if ($user->role === 'admin') $accentColor = 'purple';
                                    elseif ($user->role === 'mentor') $accentColor = 'blue';
                                    elseif ($user->role === 'student') $accentColor = $isSmk ? 'amber' : 'emerald';
                                @endphp
                                
                                <div class="p-5 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors group relative cursor-pointer">
                                    <!-- Edge Hover Indicator -->
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-{{ $accentColor }}-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                    <!-- Name & Avatar -->
                                    <div class="flex items-center gap-4 min-w-[280px]">
                                        <div class="relative flex-shrink-0 z-10">
                                            <div class="h-12 w-12 rounded-full bg-gradient-to-tr {{ $colorStyles }} flex items-center justify-center font-black text-xl shadow-inner ring-4 ring-white dark:ring-slate-900 group-hover:scale-105 transition-transform">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full ring-2 ring-white dark:ring-slate-900 bg-{{ $accentColor }}-500"></span>
                                        </div>
                                        <div class="min-w-0 pr-4">
                                            <div class="flex items-center gap-2">
                                                <h3 class="font-bold text-slate-800 dark:text-white text-base leading-tight group-hover:text-{{ $accentColor }}-600 dark:group-hover:text-{{ $accentColor }}-400 transition-colors truncate max-w-[200px]" title="{{ $user->name }}">
                                                    {{ $user->name }}
                                                </h3>
                                                @if($user->role === 'mentor')
                                                    @php $count = $user->mentoredInternships->count(); @endphp
                                                    <span class="flex-shrink-0 inline-flex items-center px-1.5 py-0.5 rounded-md text-[9px] font-black {{ $count > 0 ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }} border border-transparent transition-colors">
                                                        {{ $count }} Intern
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400 mt-0.5 truncate max-w-[200px]" title="{{ $user->email }}">
                                                {{ $user->email }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Contextual Information -->
                                    <div class="flex-1 flex flex-col sm:flex-row items-start sm:items-center justify-start lg:justify-end gap-4 lg:gap-8 w-full lg:w-auto mt-2 lg:mt-0">
                                        @if(request('role') !== 'mentor')
                                            <!-- Education & Role -->
                                            <div class="min-w-[150px] hidden md:flex flex-col text-left">
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                    Pendidikan / Jabatan
                                                </p>
                                                <div class="flex items-center gap-2">
                                                    @if($user->role === 'student')
                                                        @php
                                                            $eduLevel = optional($user->studentProfile)->education_level ?? '-';
                                                            $eduClasses = ($eduLevel === 'SMK' || $eduLevel === 'Siswa')
                                                                ? 'bg-amber-100/50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20' 
                                                                : 'bg-emerald-100/50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20';
                                                        @endphp
                                                        <span class="px-2.5 py-1 inline-flex text-[9px] uppercase tracking-widest font-black rounded-lg border {{ $eduClasses }}">
                                                            {{ $eduLevel }}
                                                        </span>
                                                    @endif
                                                    @php
                                                        $roleConfig = [
                                                            'admin' => ['bg' => 'bg-purple-50 dark:bg-purple-500/10', 'text' => 'text-purple-700 dark:text-purple-400', 'border' => 'border-purple-200 dark:border-purple-500/20'],
                                                            'mentor' => ['bg' => 'bg-blue-50 dark:bg-blue-500/10', 'text' => 'text-blue-700 dark:text-blue-400', 'border' => 'border-blue-200 dark:border-blue-500/20'],
                                                            'student' => ['bg' => 'bg-slate-50 dark:bg-slate-800/50', 'text' => 'text-slate-600 dark:text-slate-300', 'border' => 'border-slate-200 dark:border-slate-700/50'],
                                                        ];
                                                        $config = $roleConfig[$user->role] ?? $roleConfig['student'];
                                                    @endphp
                                                    <span class="px-2.5 py-1 inline-flex text-[9px] uppercase tracking-widest font-black rounded-lg border {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                                        {{ $user->role }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="min-w-[150px] hidden sm:block relative text-left">
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Tgl Terdaftar
                                                </p>
                                                <div class="text-[13px] font-black text-slate-700 dark:text-slate-200 leading-tight">
                                                    {{ $user->created_at->format('d M Y') }}
                                                </div>
                                                <div class="text-[10px] font-medium text-slate-400 dark:text-slate-500 mt-0.5">
                                                    {{ $user->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        @else
                                            <!-- Mentored Internships Stack for Mentor -->
                                            <div class="w-full lg:w-[450px] text-left">
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-2 flex items-center gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                    Intern Diampuh
                                                </p>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    @forelse($user->mentoredInternships as $internship)
                                                        @if($internship->student)
                                                            <div class="relative flex items-center gap-2.5 bg-slate-50 dark:bg-slate-800/50 p-2 rounded-xl border border-slate-100 dark:border-slate-700/50 shadow-sm transition-all group/intern overflow-hidden">
                                                                <div class="relative h-8 w-8 flex-shrink-0 rounded-lg bg-gradient-to-tr from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-600 flex items-center justify-center text-slate-600 dark:text-slate-300 font-black text-xs border border-slate-200 dark:border-slate-600">
                                                                    {{ substr($internship->student->name, 0, 1) }}
                                                                </div>
                                                                <div class="relative flex flex-col min-w-0">
                                                                    <div class="text-[11px] font-black text-slate-700 dark:text-slate-200 truncate leading-tight transition-colors">
                                                                        {{ $internship->student->name }}
                                                                    </div>
                                                                    <div class="flex items-center gap-1.5 mt-1">
                                                                        @php
                                                                            $statusConfig = $internship->status === 'active' 
                                                                                ? ['bg' => 'bg-emerald-500', 'text' => 'text-emerald-600 dark:text-emerald-400', 'label' => 'Active']
                                                                                : ['bg' => 'bg-amber-500', 'text' => 'text-amber-600 dark:text-amber-400', 'label' => 'Onboarding'];
                                                                        @endphp
                                                                        <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['bg'] }} {{ $internship->status === 'active' ? 'animate-pulse' : '' }}"></span>
                                                                        <span class="text-[8px] font-bold uppercase tracking-widest {{ $statusConfig['text'] }}">{{ $statusConfig['label'] }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @empty
                                                        <div class="col-span-full py-4 flex items-center justify-center bg-slate-50 dark:bg-slate-800/30 border border-dashed border-slate-200 dark:border-slate-800 rounded-xl">
                                                            <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Belum Ada Intern</span>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Interactive Button -->
                                        @if(request('role') !== 'mentor')
                                        <div class="hidden sm:flex items-center justify-center w-9 h-9 ml-2 rounded-full text-slate-400 group-hover:text-{{ $accentColor }}-500 group-hover:bg-{{ $accentColor }}-50 dark:group-hover:bg-{{ $accentColor }}-500/10 transition-all border border-transparent group-hover:border-{{ $accentColor }}-200 dark:group-hover:border-{{ $accentColor }}-500/20 cursor-pointer">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="px-6 py-20 text-center text-slate-500 dark:text-slate-400">
                                    <div class="flex flex-col items-center justify-center h-full gap-3">
                                        <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 rounded-3xl flex items-center justify-center mb-1 shadow-sm">
                                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-lg font-bold text-slate-600 dark:text-slate-300">Tidak ada data</p>
                                            <p class="text-sm font-medium text-slate-400 mt-0.5">Tidak ditemukan data filter ini.</p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    
                    <div class="mt-6">
                        {{ $users->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
