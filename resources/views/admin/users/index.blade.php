<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <!-- 1. HUD HEADER SECTION -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-1">
                    <div class="flex items-center gap-3">
                        <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white font-jakarta">DATABASE PENGGUNA</h1>
                    </div>
                    <div class="flex items-center gap-4 pl-1">
                        <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 tracking-[0.2em] uppercase">Status Sistem: <span class="text-emerald-500">Aktif</span></p>
                        <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                        <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 tracking-[0.2em] uppercase">Total Data: <span class="text-slate-900 dark:text-slate-200">{{ $totalAll }}</span></p>
                    </div>
                </div>

                <!-- Global Actions (Export/Import placeholder context) -->
                <div class="flex items-center gap-3">
                     <button class="px-5 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm flex items-center gap-2 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Export Data
                     </button>
                     <a href="{{ route('admin.mentors.create') }}" class="px-5 py-2.5 bg-[#ed1e28] text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-[#d61b24] transition-all shadow-lg shadow-red-500/20 flex items-center gap-2 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Mendaftarkan Mentor
                     </a>
                </div>
            </div>

            <!-- 2. MAIN HUB CONTAINER -->
            <div class="bg-white/70 dark:bg-slate-900/50 backdrop-blur-xl rounded-[2.5rem] border border-slate-200 dark:border-slate-800 shadow-2xl shadow-slate-200/50 dark:shadow-none overflow-hidden relative" 
                 x-data="{ showFilters: false, isLoading: false }"
                 @submit.document="if($event.target.tagName === 'FORM') isLoading = true">
                
                <!-- SCANNING LOADING OVERLAY -->
                <div x-show="isLoading" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="absolute inset-0 z-50 bg-white/60 dark:bg-slate-950/60 backdrop-blur-md flex flex-col items-center justify-center space-y-4">
                    <div class="relative w-20 h-20">
                        <div class="absolute inset-0 border-4 border-red-500/10 rounded-full"></div>
                        <div class="absolute inset-0 border-t-4 border-red-500 rounded-full animate-spin"></div>
                    </div>
                    <p class="text-[10px] font-black text-[#ed1e28] tracking-[0.3em] uppercase animate-pulse">Memindai Jaringan...</p>
                </div>

                <!-- TOP BAR: TABS & SEARCH -->
                <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex flex-col lg:flex-row lg:items-center justify-between gap-8 bg-slate-50/50 dark:bg-slate-900/30">
                    
                    <!-- ROLE TABS -->
                    <div class="flex items-center gap-1.5 p-1.5 bg-slate-100 dark:bg-slate-950/80 rounded-[1.5rem] border border-slate-200/50 dark:border-slate-800/50">
                        <a href="{{ route('admin.users.index') }}" 
                           class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all {{ !request('role') ? 'bg-white dark:bg-slate-800 text-[#ed1e28] shadow-md dark:shadow-none border border-slate-200 dark:border-slate-700' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                            Semua <span class="ml-1 opacity-50">{{ $totalAll }}</span>
                        </a>
                        <a href="{{ route('admin.users.index', ['role' => 'student', 'student_type' => request('student_type'), 'division_id' => request('division_id'), 'sort' => request('sort')]) }}" 
                           class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all {{ request('role') == 'student' ? 'bg-white dark:bg-slate-800 text-[#ed1e28] shadow-md dark:shadow-none border border-slate-200 dark:border-slate-700' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                            Intern <span class="ml-1 opacity-50">{{ $totalStudents }}</span>
                        </a>
                        <a href="{{ route('admin.users.index', ['role' => 'mentor', 'division_id' => request('division_id'), 'sort' => request('sort')]) }}" 
                           class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-wider transition-all {{ request('role') == 'mentor' ? 'bg-white dark:bg-slate-800 text-[#ed1e28] shadow-md dark:shadow-none border border-slate-200 dark:border-slate-700' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                            Mentor <span class="ml-1 opacity-50">{{ $totalMentors }}</span>
                        </a>
                    </div>

                    <!-- SEARCH & ADVANCED FILTERS TOGGLE -->
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <!-- ADVANCED FILTERS TOGGLE -->
                        <button @click="showFilters = !showFilters" 
                                :class="showFilters ? 'bg-[#ed1e28] text-white border-[#ed1e28]' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700'"
                                class="h-12 px-5 rounded-2xl border text-xs font-black uppercase tracking-widest flex items-center gap-3 transition-all hover:shadow-lg active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Filter
                            <span x-show="!showFilters" class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        </button>

                        <!-- SEARCH SCAN INPUT -->
                        <form action="{{ route('admin.users.index') }}" method="GET" class="relative group" x-data x-ref="searchForm">
                             @foreach(request()->except(['search', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                             @endforeach
                             <svg class="w-5 h-5 text-slate-400 dark:text-slate-600 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-[#ed1e28] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                             
                             <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Cari Identitas..." 
                                    @input.debounce.500ms="$refs.searchForm.submit()"
                                    x-init="$el.focus(); $el.setSelectionRange($el.value.length, $el.value.length)"
                                    class="w-full sm:w-64 h-12 pl-12 pr-12 bg-slate-100/50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm font-bold text-slate-800 dark:text-slate-200 outline-none focus:ring-4 focus:ring-red-500/10 focus:border-[#ed1e28] transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                             
                             @if(request('search'))
                                <a href="{{ route('admin.users.index', request()->except(['search', 'page'])) }}" 
                                   class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </a>
                             @endif
                        </form>
                    </div>
                </div>

                <!-- ADVANCED FILTERS PANEL (Expandable) -->
                <div x-show="showFilters" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="p-8 border-b border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-950/20">
                    
                    <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        @if(request('role')) <input type="hidden" name="role" value="{{ request('role') }}"> @endif
                        @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif

                        <!-- Filter Divisi -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 pl-1">Divisi Penempatan</label>
                            <select name="division_id" onchange="this.form.submit()" class="w-full h-11 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-red-500/20 focus:border-[#ed1e28] outline-none transition-all">
                                <option value="">Semua Divisi</option>
                                @foreach($divisions as $div)
                                    <option value="{{ $div->id }}" {{ request('division_id') == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Tipe (Hanya jika role student/semua) -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 pl-1">Level Pendidikan</label>
                            <select name="student_type" onchange="this.form.submit()" class="w-full h-11 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-red-500/20 focus:border-[#ed1e28] outline-none transition-all">
                                <option value="">Semua Level</option>
                                <option value="mahasiswa" {{ request('student_type') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa (S1/D3)</option>
                                <option value="smk" {{ request('student_type') == 'smk' ? 'selected' : '' }}>Siswa SMK</option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 pl-1">Urutkan Berdasarkan</label>
                            <select name="sort" onchange="this.form.submit()" class="w-full h-11 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-red-500/20 focus:border-[#ed1e28] outline-none transition-all">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru Bergabung</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama Bergabung</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                            </select>
                        </div>

                        <!-- Reset Button -->
                        <div class="flex items-end">
                            <a href="{{ route('admin.users.index', ['role' => request('role')]) }}" class="h-11 w-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
                                Reset Filter
                            </a>
                        </div>
                    </form>
                </div>

                <!-- 3. DATA LIST SECTION -->
                <div class="divide-y divide-slate-100 dark:divide-slate-800/50">
                    @forelse ($users as $user)
                        @php
                            $isSmk = optional($user->studentProfile)->student_type === 'siswa' || optional($user->studentProfile)->education_level === 'SMK';
                            
                            $roleConfig = [
                                'admin' => ['color' => 'purple', 'from' => 'from-purple-500/20', 'text' => 'text-purple-600 dark:text-purple-400', 'bg' => 'bg-purple-50 dark:bg-purple-500/10', 'border' => 'border-purple-100 dark:border-purple-500/20'],
                                'mentor' => ['color' => 'blue', 'from' => 'from-blue-500/20', 'text' => 'text-blue-600 dark:text-blue-400', 'bg' => 'bg-blue-50 dark:bg-blue-500/10', 'border' => 'border-blue-100 dark:border-blue-500/20'],
                                'student' => ['color' => $isSmk ? 'orange' : 'emerald', 'from' => $isSmk ? 'from-orange-500/20' : 'from-emerald-500/20', 'text' => $isSmk ? 'text-orange-600 dark:text-orange-400' : 'text-emerald-600 dark:text-emerald-400', 'bg' => $isSmk ? 'bg-orange-50 dark:bg-orange-500/10' : 'bg-emerald-50 dark:bg-emerald-500/10', 'border' => $isSmk ? 'border-orange-100 dark:border-orange-500/20' : 'border-emerald-100 dark:border-emerald-500/20'],
                            ];
                            $config = $roleConfig[$user->role] ?? $roleConfig['student'];
                        @endphp
                        
                        <div class="group relative flex flex-col lg:flex-row lg:items-center justify-between p-6 lg:p-8 hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-all duration-300">
                            <!-- HOVER ACCENT BAR -->
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#ed1e28] translate-x-[-1.5px] opacity-0 group-hover:opacity-100 transition-all duration-300 rounded-r-full"></div>

                            <!-- LEFT: Profile Info -->
                            <div class="flex items-center gap-6 min-w-0">
                                <div class="relative shrink-0">
                                    <div class="w-16 h-16 rounded-[1.5rem] bg-gradient-to-br {{ $config['from'] }} to-transparent border {{ $config['border'] }} flex items-center justify-center text-2xl font-black {{ $config['text'] }} group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 rounded-full border-4 border-white dark:border-slate-900 group-hover:animate-pulse shadow-sm"></div>
                                </div>
                                <div class="min-w-0 pr-4">
                                    <h4 class="text-xl font-black text-slate-800 dark:text-white font-jakarta group-hover:text-[#ed1e28] transition-colors truncate max-w-[200px] lg:max-w-none" title="{{ $user->name }}">
                                        {{ $user->name }}
                                    </h4>
                                    <div class="flex items-center gap-3 mt-1.5">
                                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 truncate" title="{{ $user->email }}">{{ $user->email }}</p>
                                        <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                                        <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
                                            {{ $user->role === 'student' ? ($isSmk ? 'Siswa SMK' : 'Mahasiswa') : $user->role }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT: Metadata & Lists -->
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-8 lg:gap-16 mt-6 lg:mt-0 ml-0 lg:ml-auto">
                                
                                @if($user->role === 'mentor')
                                    <!-- Mentor's Intern Stack -->
                                    <div class="flex flex-col min-w-[200px] cursor-pointer group/stack hover:scale-105 transition-transform"
                                         @click="$dispatch('open-mentor-interns', { 
                                            name: '{{ addslashes($user->name) }}', 
                                            interns: {{ json_encode($user->mentoredInternships) }}
                                         })">
                                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600 mb-2 opacity-0 group-hover:opacity-100 transition-opacity">Peserta Bimbingan</p>
                                        <div class="flex items-center gap-2">
                                            @php $interns = $user->mentoredInternships->take(3); @endphp
                                            <div class="flex -space-x-3">
                                                @foreach($interns as $intern)
                                                    <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 border-2 border-white dark:border-slate-950 flex items-center justify-center text-[10px] font-black text-slate-500 shadow-sm" title="{{ $intern->student->name }}">
                                                        {{ substr($intern->student->name, 0,1) }}
                                                    </div>
                                                @endforeach
                                                @if($user->mentoredInternships->count() > 3)
                                                    <div class="w-9 h-9 rounded-xl bg-[#ed1e28] border-2 border-white dark:border-slate-950 flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                                        +{{ $user->mentoredInternships->count() - 3 }}
                                                    </div>
                                                @endif
                                            </div>
                                            <span class="text-[11px] font-black text-slate-600 dark:text-slate-400 group-hover/stack:text-[#ed1e28] transition-colors">
                                                {{ $user->mentoredInternships->count() }} Total
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <!-- Intern Details -->
                                    <div class="flex flex-col min-w-[140px]">
                                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600 mb-2 opacity-0 group-hover:opacity-100 transition-opacity">Pendidikan</p>
                                        <div class="text-sm font-black text-slate-700 dark:text-slate-300">
                                            {{ optional($user->studentProfile)->education_level ?? 'S1/D3' }}
                                        </div>
                                        <div class="text-[10px] font-bold text-slate-400 truncate max-w-[120px]">
                                            {{ optional($user->studentProfile)->university ?? 'Telkom Group' }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Joined Date -->
                                <div class="flex flex-col min-w-[120px]">
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600 mb-2 opacity-0 group-hover:opacity-100 transition-opacity">Registered</p>
                                    <div class="text-sm font-black text-slate-700 dark:text-slate-300">
                                        {{ $user->created_at->format('d M Y') }}
                                    </div>
                                    <p class="text-[10px] font-bold text-slate-400">
                                        {{ $user->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-20 text-center">
                            <div class="w-24 h-24 bg-slate-50 dark:bg-slate-950/20 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-[2.5rem] flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-slate-300 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m16-10a4 4 0 11-8 0 4 4 0 018 0zM9 7h.01M9 14h.01"></path></svg>
                            </div>
                            <h5 class="text-xl font-black text-slate-800 dark:text-slate-200 font-jakarta">DATA IDENTIFIKASI NIHIL</h5>
                            <p class="text-sm text-slate-400 mt-2">Tidak ditemukan data user dengan filter aktif saat ini.</p>
                             <a href="{{ route('admin.users.index') }}" class="mt-8 px-6 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl text-xs font-black uppercase tracking-widest inline-block hover:scale-105 transition-transform active:scale-95 shadow-xl">
                                Reset Scan
                             </a>
                        </div>
                    @endforelse
                </div>

                <!-- 4. PAGINATION HUB -->
                @if($users->hasPages())
                    <div class="p-8 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/30">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

        </div>
        @include('admin.users.partials.mentor-interns-modal')
    </div>

    <!-- CUSTOM PAGINATION STYLING (HUD STYLE) -->
    <style>
        .pagination { display: flex; justify-content: center; gap: 0.5rem; align-items: center; }
        .page-item { list-style: none; }
        .page-link { 
            height: 2.75rem; min-width: 2.75rem; display: flex; align-items: center; justify-content: center;
            border-radius: 1rem; font-size: 0.75rem; font-weight: 900; letter-spacing: 0.05em;
            background: white; border: 1px solid #e2e8f0; color: #64748b; transition: all 0.2s;
        }
        .dark .page-link { background: #0f172a; border-color: #1e293b; color: #94a3b8; }
        .page-item.active .page-link { background: #ed1e28; border-color: #ed1e28; color: white; box-shadow: 0 10px 15px -3px rgba(237, 30, 40, 0.2); }
        .page-link:hover:not(.active) { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }
        .dark .page-link:hover:not(.active) { background: #1e293b; border-color: #334155; color: white; }
        .page-item.disabled .page-link { opacity: 0.4; cursor: not-allowed; }
    </style>
</x-app-layout>
