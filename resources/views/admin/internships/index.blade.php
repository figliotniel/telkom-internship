<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <!-- 1. HUD HEADER SECTION -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-1">
                    <div class="flex items-center gap-3">
                        <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white font-jakarta uppercase">MONITORING MAGANG</h1>
                    </div>
                    <div class="flex items-center gap-4 pl-1">
                        <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 tracking-[0.2em] uppercase">Status: <span class="text-[#ed1e28]">Pemantauan Langsung</span></p>
                        <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                        <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 tracking-[0.2em] uppercase">Total {{ $status == 'pending' ? 'Menunggu' : ($status == 'active' ? 'Aktif' : ($status == 'finished' ? 'Selesai' : 'Perpanjangan')) }}: <span class="text-slate-900 dark:text-slate-200">{{ $totalInterns }}</span></p>
                    </div>
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

                <!-- TOP BAR: STATUS TABS & SEARCH -->
                <div class="p-8 border-b border-slate-100 dark:border-slate-800 flex flex-col lg:flex-row lg:items-center justify-between gap-8 bg-slate-50/50 dark:bg-slate-900/30">
                    
                    <!-- STATUS HUD TABS -->
                    <div class="flex items-center gap-1.5 p-1.5 bg-slate-100 dark:bg-slate-950/80 rounded-[1.5rem] border border-slate-200/50 dark:border-slate-800/50 overflow-x-auto no-scrollbar">
                        {{-- Pending Tab --}}
                        <a href="{{ route('admin.internships.index', ['status' => 'pending', 'division_id' => request('division_id'), 'sort' => request('sort')]) }}" 
                           class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-2 {{ $status == 'pending' ? 'bg-white dark:bg-slate-800 text-red-600 shadow-md border border-slate-200 dark:border-slate-700' : 'text-slate-500 hover:text-slate-700' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $status == 'pending' ? 'bg-red-500 animate-pulse' : 'bg-slate-400' }}"></span>
                            Menunggu <span class="opacity-50">({{ $pendingCount }})</span>
                        </a>

                        {{-- Active Tab --}}
                        <a href="{{ route('admin.internships.index', ['status' => 'active', 'division_id' => request('division_id'), 'sort' => request('sort')]) }}" 
                           class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-2 {{ $status == 'active' ? 'bg-white dark:bg-slate-800 text-emerald-600 shadow-md border border-slate-200 dark:border-slate-700' : 'text-slate-500 hover:text-slate-700' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $status == 'active' ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                            Aktif <span class="opacity-50">({{ $activeCount }})</span>
                        </a>

                        {{-- Finished Tab --}}
                        <a href="{{ route('admin.internships.index', ['status' => 'finished', 'division_id' => request('division_id'), 'sort' => request('sort')]) }}" 
                           class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-2 {{ $status == 'finished' ? 'bg-white dark:bg-slate-800 text-blue-600 shadow-md border border-slate-200 dark:border-slate-700' : 'text-slate-500 hover:text-slate-700' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $status == 'finished' ? 'bg-blue-500 animate-pulse' : 'bg-slate-400' }}"></span>
                            Selesai <span class="opacity-50">({{ $finishedCount }})</span>
                        </a>

                        {{-- Extension Tab --}}
                        @if($extensionCount > 0)
                        <a href="{{ route('admin.internships.index', ['status' => 'extension', 'division_id' => request('division_id'), 'sort' => request('sort')]) }}" 
                           class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-2 {{ $status == 'extension' ? 'bg-white dark:bg-slate-800 text-indigo-600 shadow-md border border-slate-200 dark:border-slate-700' : 'text-slate-500 hover:text-slate-700' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $status == 'extension' ? 'bg-indigo-500 animate-pulse' : 'bg-slate-400' }}"></span>
                            Perpanjangan <span class="opacity-50">({{ $extensionCount }})</span>
                        </a>
                        @endif
                    </div>

                    <!-- SEARCH & ADVANCED FILTERS TOGGLE -->
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <!-- ADVANCED FILTERS TOGGLE -->
                        <button @click="showFilters = !showFilters" 
                                :class="showFilters ? 'bg-[#ed1e28] text-white border-[#ed1e28]' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700'"
                                class="h-12 px-5 rounded-2xl border text-xs font-black uppercase tracking-widest flex items-center gap-3 transition-all hover:shadow-lg active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Filter
                        </button>

                        <!-- SEARCH SCAN INPUT -->
                        <form action="{{ route('admin.internships.index') }}" method="GET" class="relative group" x-data x-ref="searchForm">
                             @foreach(request()->except(['search', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                             @endforeach
                             <svg class="w-5 h-5 text-slate-400 dark:text-slate-600 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-[#ed1e28] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                             <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Cari Peserta Magang..." 
                                    @input.debounce.500ms="$refs.searchForm.submit()"
                                    x-init="$el.focus(); $el.setSelectionRange($el.value.length, $el.value.length)"
                                    class="w-full sm:w-64 h-12 pl-12 pr-12 bg-slate-100/50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm font-bold text-slate-800 dark:text-slate-200 outline-none focus:ring-4 focus:ring-red-500/10 focus:border-[#ed1e28] transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                             
                             @if(request('search'))
                                <a href="{{ route('admin.internships.index', request()->except(['search', 'page'])) }}" 
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
                    
                    <form action="{{ route('admin.internships.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
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

                        <!-- Filter Tipe -->
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
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Masa Aktif Paling Baru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Masa Aktif Paling Lama</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                                @if($status == 'active')
                                <option value="end_date_near" {{ request('sort') == 'end_date_near' ? 'selected' : '' }}>Akan Segera Selesai</option>
                                @endif
                            </select>
                        </div>

                        <!-- Reset Button -->
                        <div class="flex items-end">
                            <a href="{{ route('admin.internships.index', ['status' => request('status')]) }}" class="h-11 w-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
                                Reset Filters
                            </a>
                        </div>
                    </form>
                </div>

                <!-- 3. DATA LIST SECTION -->
                <div class="divide-y divide-slate-100 dark:divide-slate-800/50">
                    @forelse ($internships as $intern)
                        @php
                            $isSmk = optional($intern->student->studentProfile)->student_type === 'siswa' || optional($intern->student->studentProfile)->education_level === 'SMK';
                            $statusConfig = [
                                'active' => ['theme' => 'emerald', 'label' => 'ACTIVE HUB'],
                                'pending' => ['theme' => 'red', 'label' => 'WAITING REV'],
                                'onboarding' => ['theme' => 'orange', 'label' => 'ONBOARDING'],
                                'finished' => ['theme' => 'blue', 'label' => 'ARCHIVED'],
                                'extension' => ['theme' => 'indigo', 'label' => 'EXT REQ'],
                            ];
                            $config = $statusConfig[$intern->status] ?? $statusConfig['pending'];
                            
                            $isClickable = in_array($intern->status, ['active', 'finished']);
                            $rowUrl = route('admin.internships.show', $intern->id);
                            
                            $colors = ['blue', 'emerald', 'purple', 'amber', 'rose', 'indigo'];
                            $divTheme = $intern->division_id ? $colors[$intern->division_id % 6] : 'slate';
                        @endphp
                        
                        <div class="group relative flex flex-col lg:flex-row lg:items-center justify-between p-6 lg:p-8 hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-all duration-300 {{ $isClickable ? 'cursor-pointer' : '' }}"
                             {!! $isClickable ? 'onclick="window.location=\'' . $rowUrl . '\'"' : '' !!}>
                            
                            <!-- HOVER ACCENT BAR -->
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#ed1e28] translate-x-[-1.5px] opacity-0 group-hover:opacity-100 transition-all duration-300 rounded-r-full"></div>

                            <!-- LEFT: Identity Info -->
                            <div class="flex items-center gap-6 min-w-0">
                                <div class="relative shrink-0">
                                    @if($intern->student->studentProfile && $intern->student->studentProfile->photo)
                                        <div class="w-16 h-16 rounded-[1.5rem] overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm transition-transform duration-500 group-hover:scale-110">
                                            <img src="{{ asset('storage/' . $intern->student->studentProfile->photo) }}" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-16 h-16 rounded-[1.5rem] bg-gradient-to-br from-{{ $divTheme }}-500/20 to-transparent flex items-center justify-center text-2xl font-black text-{{ $divTheme }}-600 dark:text-{{ $divTheme }}-400 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-sm uppercase">
                                            {{ substr($intern->student->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-{{ $config['theme'] }}-500 rounded-full border-4 border-white dark:border-slate-900 group-hover:animate-pulse shadow-sm" title="Status: {{ $config['label'] }}"></div>
                                </div>
                                <div class="min-w-0 pr-4">
                                    <h4 class="text-xl font-black text-slate-800 dark:text-white font-jakarta group-hover:text-[#ed1e28] transition-colors truncate max-w-[200px] lg:max-w-none">
                                        {{ $intern->student->name }}
                                    </h4>
                                    <div class="flex items-center gap-3 mt-1.5">
                                        <p class="text-xs font-bold text-slate-400 dark:text-slate-500 truncate">{{ $intern->student->email }}</p>
                                        <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                                        <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded bg-{{ $config['theme'] }}-50 dark:bg-{{ $config['theme'] }}-500/10 text-{{ $config['theme'] }}-600 dark:text-{{ $config['theme'] }}-400 border border-{{ $config['theme'] }}-500/20">
                                            {{ $isSmk ? 'Siswa SMK' : 'Mahasiswa' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- RIGHT: Data Context & Actions -->
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-8 lg:gap-16 mt-6 lg:mt-0 ml-0 lg:ml-auto">
                                
                                {{-- CONTEXTUAL INFO --}}
                                @if($status == 'pending')
                                    <!-- Application Wait Time -->
                                    <div class="flex flex-col min-w-[140px]">
                                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600 mb-2 opacity-0 group-hover:opacity-100 transition-opacity">Request Date</p>
                                        <div class="text-sm font-black text-slate-700 dark:text-slate-300">
                                            {{ $intern->created_at->format('d M Y') }}
                                        </div>
                                        <div class="text-[10px] font-bold text-slate-400">
                                            Applied {{ $intern->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                @elseif($status == 'active')
                                    <!-- Placement & Remaining Time -->
                                    <div class="flex flex-col min-w-[150px] items-start">
                                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600 mb-2 opacity-0 group-hover:opacity-100 transition-opacity">Placement</p>
                                        <div class="text-[11px] font-black uppercase tracking-widest px-2.5 py-0.5 rounded bg-{{ $divTheme }}-50 dark:bg-{{ $divTheme }}-500/10 text-{{ $divTheme }}-600 dark:text-{{ $divTheme }}-400 border border-{{ $divTheme }}-500/20 mb-1">
                                            {{ $intern->division->code ?? $intern->division->name }}
                                        </div>
                                        <div class="text-[10px] font-bold text-slate-400 truncate max-w-[140px]">
                                            Mentor: {{ $intern->mentor->name }}
                                        </div>
                                    </div>
                                    <div class="flex flex-col min-w-[120px]">
                                        @php
                                            $endDate = \Carbon\Carbon::parse($intern->end_date);
                                            $daysRemaining = max(0, (int) \Carbon\Carbon::now()->diffInDays($endDate, false));
                                        @endphp
                                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600 mb-2 opacity-0 group-hover:opacity-100 transition-opacity">Tenggat Waktu</p>
                                        <div class="text-sm font-black {{ $daysRemaining <= 10 ? 'text-red-500' : 'text-slate-700 dark:text-slate-300' }}">
                                            {{ $endDate->format('d M Y') }}
                                        </div>
                                        <div class="text-[10px] font-bold text-slate-400">
                                            Sisa {{ $daysRemaining }} Hari
                                        </div>
                                    </div>
                                @elseif($status == 'extension')
                                    @php $ext = $intern->extensions->first(); @endphp
                                    <div class="flex flex-col min-w-[150px]">
                                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600 mb-2 opacity-0 group-hover:opacity-100 transition-opacity">Tenggat Baru</p>
                                        <div class="text-sm font-black text-indigo-600 dark:text-indigo-400">
                                            {{ \Carbon\Carbon::parse($ext->new_end_date)->format('d M Y') }}
                                        </div>
                                        <div class="text-[10px] font-bold text-slate-400">
                                            +{{ (int) \Carbon\Carbon::parse($ext->new_start_date)->diffInDays(\Carbon\Carbon::parse($ext->new_end_date)) }} Hari
                                        </div>
                                    </div>
                                @else
                                    <!-- Archived Info -->
                                    <div class="flex flex-col min-w-[150px]">
                                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600 mb-2 opacity-0 group-hover:opacity-100 transition-opacity">Period</p>
                                        <div class="text-sm font-black text-slate-700 dark:text-slate-300">
                                            {{ \Carbon\Carbon::parse($intern->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($intern->end_date)->format('d M Y') }}
                                        </div>
                                        <div class="text-[10px] font-bold text-slate-400">
                                            Archived Node
                                        </div>
                                    </div>
                                @endif

                                {{-- ACTIONS --}}
                                <div class="flex items-center gap-3" onclick="event.stopPropagation()">
                                    @if($intern->status == 'pending')
                                        <button @click="$dispatch('open-review-modal', { 
                                            id: {{ $intern->id }}, 
                                            name: '{{ addslashes($intern->student->name) }}', 
                                            docs: {{ json_encode($intern->documents) }},
                                            photo: '{{ $intern->student->studentProfile && $intern->student->studentProfile->photo ? $intern->student->studentProfile->photo : null }}'
                                        })" class="px-5 py-2.5 bg-[#ed1e28] text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-[#d61b24] transition-all shadow-lg shadow-red-500/20 active:scale-95">
                                            Tinjau
                                        </button>
                                    @elseif($intern->status == 'onboarding')
                                        @php
                                            $signedPact = $intern->documents->where('type', 'pakta_integritas_signed')->first();
                                        @endphp
                                        @if($signedPact)
                                            <button @click="$dispatch('open-activation-modal', { id: {{ $intern->id }}, name: '{{ addslashes($intern->student->name) }}' })" 
                                                    class="px-5 py-2.5 bg-emerald-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 shadow-lg shadow-emerald-500/20 active:scale-95 transition-all">
                                                Aktifkan Akses
                                            </button>
                                        @else
                                            <span class="px-5 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 rounded-2xl text-[10px] font-black uppercase tracking-widest border border-slate-200 dark:border-slate-800">
                                                Tunggu Pakta
                                            </span>
                                        @endif
                                    @elseif($intern->status == 'extension')
                                         <div class="flex items-center gap-2">
                                            <a href="{{ Storage::url($ext->file_path) }}" target="_blank" class="w-11 h-11 flex items-center justify-center bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-2xl border border-indigo-500/20 hover:scale-105 transition-transform active:scale-95">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                            <form id="approve-extension-form-{{ $ext->id }}" action="{{ route('admin.internships.approveExtension', $ext->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="button" onclick="confirmApproveExtension('{{ $ext->id }}')" class="w-11 h-11 flex items-center justify-center bg-emerald-500 text-white rounded-2xl shadow-lg shadow-emerald-500/20 hover:scale-105 transition-transform active:scale-95">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                </button>
                                            </form>
                                         </div>
                                    @elseif($intern->status == 'active')
                                         <div class="w-11 h-11 flex items-center justify-center rounded-2xl text-slate-400 group-hover:text-emerald-500 group-hover:bg-emerald-50 dark:group-hover:bg-emerald-500/10 transition-all border border-transparent group-hover:border-emerald-500/20">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                         </div>
                                    @elseif($intern->status == 'finished')
                                        @php $hasCertificate = $intern->documents->where('type', 'sertifikat_kelulusan')->count() > 0; @endphp
                                        <button @click="$dispatch('open-completion-modal', { id: {{ $intern->id }}, name: '{{ addslashes($intern->student->name) }}', isSmk: {{ $isSmk ? 'true' : 'false' }} })" 
                                                class="px-5 py-2.5 {{ $hasCertificate ? 'bg-slate-200 dark:bg-slate-800 text-slate-600 dark:text-slate-400' : 'bg-blue-500 text-white shadow-blue-500/20' }} rounded-2xl text-[10px] font-black uppercase tracking-widest hover:scale-105 transition-all shadow-lg active:scale-95">
                                            {{ $hasCertificate ? 'Update Docs' : 'Issue Cert' }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-20 text-center">
                            <div class="w-24 h-24 bg-slate-50 dark:bg-slate-950/20 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-[2.5rem] flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-slate-300 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <h5 class="text-xl font-black text-slate-800 dark:text-slate-200 font-jakarta uppercase">No Active Link Detected</h5>
                            <p class="text-sm text-slate-400 mt-2">Tidak ditemukan data intern dengan parameter filter saat ini.</p>
                             <a href="{{ route('admin.internships.index', ['status' => $status]) }}" class="mt-8 px-6 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl text-xs font-black uppercase tracking-widest inline-block hover:scale-105 transition-transform active:scale-95 shadow-xl">
                                Re-Scan Network
                             </a>
                        </div>
                    @endforelse
                </div>

                <!-- 4. PAGINATION HUB -->
                @if($internships->hasPages())
                    <div class="p-8 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/30">
                        {{ $internships->links() }}
                    </div>
                @endif
            </div>

        </div>

        {{-- INCLUDED MODALS --}}
        @include('admin.internships.partials.review-modal')
        @include('admin.internships.partials.completion-modal')
        @include('admin.internships.partials.activation-modal')
        @include('admin.internships.partials.extension-modal')
    </div>

    <!-- CUSTOM HUD PAGINATION -->
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .pagination { display: flex; justify-content: center; gap: 0.5rem; }
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
    </style>

    @push('scripts')
    <script>
        function confirmApproveExtension(id) {
            Swal.fire({
                title: 'SETUJUI PERPANJANGAN?',
                text: "Durasi magang akan diperpanjang sesuai permintaan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'KONFIRMASI',
                cancelButtonText: 'BATAL',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-slate-800 rounded-[2rem] shadow-2xl',
                    title: 'text-slate-900 dark:text-white font-black font-jakarta',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-emerald-500 text-white font-black rounded-xl text-xs uppercase transition-all active:scale-95 shadow-lg shadow-emerald-500/20',
                    cancelButton: 'px-6 py-2.5 mx-2 bg-slate-100 dark:bg-slate-800 text-slate-500 font-black rounded-xl text-xs uppercase'
                }
            }).then((result) => { if (result.isConfirmed) { document.getElementById('approve-extension-form-' + id).submit(); } });
        }
    </script>
    @endpush
</x-app-layout>
