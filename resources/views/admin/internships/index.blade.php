<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Monitoring Intern</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Monitor and manage all internship applications and active interns.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-[#f8fafc] dark:bg-slate-950 min-h-screen transition-colors duration-300" x-data="{
        init() {
            if (!document.getElementById('alpine-search-script')) {
                const script = document.createElement('script');
                script.id = 'alpine-search-script';
                script.src = 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js';
                script.defer = true;
                document.head.appendChild(script);
            }
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Main Container -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-[0_4px_24px_rgba(0,0,0,0.02)] border border-slate-100 dark:border-slate-800 overflow-hidden transition-colors duration-300">
                <div class="p-8">
                    
                    <!-- Controls Row: Tabs & Actions -->
                    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-6 border-b border-slate-100 dark:border-slate-800 pb-6 mb-6">
                        
                        <!-- Premium Tabs -->
                        <nav class="flex space-x-2 overflow-x-auto w-full xl:w-auto pb-2 xl:pb-0" aria-label="Tabs" style="-ms-overflow-style: none; scrollbar-width: none;">
                            {{-- Pending --}}
                            <a href="{{ route('admin.internships.index', ['status' => 'pending']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap
                               {{ $status === 'pending' ? 'bg-telkom-50 dark:bg-telkom-500/10 text-telkom-700 dark:text-telkom-400 border border-telkom-100 dark:border-telkom-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Pending
                                <span class="ml-2 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm
                                    {{ $status === 'pending' ? 'bg-white dark:bg-telkom-500/20 text-telkom-600 dark:text-telkom-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                                    {{ $pendingCount }}
                                </span>
                            </a>


                            {{-- Active --}}
                            <a href="{{ route('admin.internships.index', ['status' => 'active']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap
                               {{ $status === 'active' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Aktif
                                <span class="ml-2 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm
                                    {{ $status === 'active' ? 'bg-white dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                                    {{ $activeCount }}
                                </span>
                            </a>

                            {{-- Finished --}}
                            <a href="{{ route('admin.internships.index', ['status' => 'finished']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap
                               {{ $status === 'finished' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Selesai
                                <span class="ml-2 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm
                                    {{ $status === 'finished' ? 'bg-white dark:bg-blue-500/20 text-blue-600 dark:text-blue-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                                    {{ $finishedCount }}
                                </span>
                            </a>

                            {{-- Extended --}}
                            @if($extensionCount > 0)
                            <a href="{{ route('admin.internships.index', ['status' => 'extension']) }}" 
                               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all flex items-center whitespace-nowrap
                               {{ $status === 'extension' ? 'bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/30 shadow-sm' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}">
                                Extended
                                <span class="ml-2 py-0.5 px-2.5 rounded-full text-[10px] font-black shadow-sm animate-pulse
                                    {{ $status === 'extension' ? 'bg-white dark:bg-amber-500/30 text-amber-600 dark:text-amber-300' : 'bg-amber-100/50 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400' }}">
                                    {{ $extensionCount }}
                                </span>
                            </a>
                            @endif
                        </nav>

                        <!-- Actions & Filters -->
                        <div class="flex flex-col sm:flex-row flex-wrap items-center justify-end gap-4 w-full xl:w-auto">
                            @if($status !== 'pending')
                            <div class="inline-flex bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-1 shrink-0" role="group">
                                <a href="{{ route('admin.internships.index', array_merge(request()->query(), ['student_type' => request('student_type') == 'mahasiswa' ? null : 'mahasiswa', 'page' => null])) }}" 
                                   class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all flex items-center gap-2
                                   {{ request('student_type') == 'mahasiswa' 
                                      ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 shadow-sm' 
                                      : 'text-gray-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-red-600 dark:hover:text-red-400' }}">
                                    MHS ({{ $internMahasiswaCount }})
                                </a>
                                <a href="{{ route('admin.internships.index', array_merge(request()->query(), ['student_type' => request('student_type') == 'smk' ? null : 'smk', 'page' => null])) }}" 
                                   class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all flex items-center gap-2
                                   {{ request('student_type') == 'smk' 
                                      ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 shadow-sm' 
                                      : 'text-gray-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-red-600 dark:hover:text-red-400' }}">
                                    SMK ({{ $internSmkCount }})
                                </a>
                            </div>
                            @endif

                            <!-- Search -->
                            <form action="{{ route('admin.internships.index') }}" method="GET" class="relative w-full sm:w-64" x-data x-ref="form">
                                @if(request('status'))
                                    <input type="hidden" name="status" value="{{ request('status') }}">
                                @endif
                                @if(request('student_type'))
                                    <input type="hidden" name="student_type" value="{{ request('student_type') }}">
                                @endif
                                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Cari Intern..." 
                                    @input.debounce.500ms="$refs.form.submit()"
                                    x-init="$el.focus(); $el.setSelectionRange($el.value.length, $el.value.length);"
                                    class="pl-9 pr-4 py-2.5 w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 outline-none transition-all placeholder-slate-400 font-medium text-slate-700 dark:text-slate-300">
                            </form>
                        </div>
                    </div>

                    <!-- Modern Stacked List (Option B) -->
                    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm">
                        <div class="divide-y divide-slate-100 dark:divide-slate-800/60">
                            @forelse ($internships as $internship)
                                @php
                                    $isClickableRow = in_array($status, ['active', 'finished']);
                                    $rowUrl = route('admin.internships.show', $internship->id);
                                    
                                    // Determine accent color based on status
                                    $accentColor = 'slate';
                                    if ($internship->status === 'active') $accentColor = 'emerald';
                                    elseif ($internship->status === 'finished') $accentColor = 'blue';
                                    elseif (in_array($internship->status, ['pending', 'onboarding'])) $accentColor = 'amber';
                                    elseif ($internship->status === 'extension') $accentColor = 'purple';
                                @endphp
                                
                                <div class="p-5 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors group relative {{ $isClickableRow ? 'cursor-pointer' : '' }}"
                                     {!! $isClickableRow ? 'onclick="window.location=\'' . $rowUrl . '\'"' : '' !!}>
                                    
                                    <!-- Edge Hover Indicator -->
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-{{ $accentColor }}-500 dark:bg-{{ $accentColor }}-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                    <!-- Name & Avatar -->
                                    <div class="flex items-center gap-4 min-w-[300px]">
                                        <div class="relative flex-shrink-0 z-10">
                                            @if($internship->student && $internship->student->studentProfile && $internship->student->studentProfile->photo)
                                                <img src="{{ asset('storage/' . $internship->student->studentProfile->photo) }}" class="w-12 h-12 rounded-full border border-slate-200 dark:border-slate-700 shadow-sm object-cover ring-4 ring-white dark:ring-slate-900">
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-{{ $accentColor }}-400/20 to-teal-500/20 dark:from-{{ $accentColor }}-500/10 dark:to-teal-400/10 flex items-center justify-center text-{{ $accentColor }}-600 dark:text-{{ $accentColor }}-400 font-black text-xl shadow-inner border border-{{ $accentColor }}-100 dark:border-{{ $accentColor }}-500/20 ring-4 ring-white dark:ring-slate-900 group-hover:scale-105 transition-transform">
                                                    {{ substr($internship->student->name, 0, 1) }}
                                                </div>
                                            @endif
                                            
                                            <!-- Status Dot -->
                                            <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full ring-2 ring-white dark:ring-slate-900 bg-{{ $accentColor }}-500"></span>
                                        </div>
                                        <div class="min-w-0 pr-4">
                                            <h3 class="font-bold text-slate-800 dark:text-white text-base leading-tight group-hover:text-{{ $accentColor }}-600 dark:group-hover:text-{{ $accentColor }}-400 transition-colors truncate max-w-[200px]" title="{{ $internship->student->name }}">
                                                {{ $internship->student->name }}
                                            </h3>
                                            <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400 mt-0.5 truncate max-w-[200px]" title="{{ $internship->student->email }}">
                                                {{ $internship->student->email }}
                                            </p>

                                            @if($status === 'pending')
                                                <div class="mt-1.5 flex items-center gap-1.5">
                                                    @if($internship->status === 'pending')
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-widest bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 border border-red-100 dark:border-red-500/20">
                                                            New Applicant
                                                        </span>
                                                    @elseif($internship->status === 'onboarding')
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-widest bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-100 dark:border-amber-500/20">
                                                            Onboarding
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Contextual Information based on Status -->
                                    <div class="flex-1 flex flex-col sm:flex-row items-start sm:items-center justify-start lg:justify-end gap-4 lg:gap-8 w-full lg:w-auto mt-2 lg:mt-0">
                                        @if($status === 'pending')
                                            <!-- Application Date / Context for Pending -->
                                            <div class="min-w-[150px] hidden md:block text-left relative group/info opacity-100 lg:opacity-60 group-hover:opacity-100 transition-opacity">
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Waktu Pengajuan
                                                </p>
                                                <div class="text-[13px] font-bold text-slate-700 dark:text-slate-200">
                                                    {{ $internship->created_at->format('d M Y') }}
                                                </div>
                                                <div class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 font-medium">
                                                    {{ $internship->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        @else
                                            <!-- Division & Mentor -->
                                            <div class="min-w-[150px] hidden md:block text-left relative group/info">
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                    Penempatan
                                                </p>
                                                <div class="text-[13px] font-bold text-slate-700 dark:text-slate-200 truncate w-40" title="{{ $internship->division?->name ?? '-' }}">
                                                    {{ $internship->division?->code ?? ($internship->division?->name ?? '-') }}
                                                </div>
                                                <div class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5 truncate w-40 font-medium">
                                                    Mentor: <span class="text-slate-700 dark:text-slate-300 font-bold max-w-[100px] truncate inline-block align-bottom">{{ $internship->mentor?->name ?? '-' }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Date / Status Duration Info -->
                                        <div class="min-w-[160px] hidden sm:block relative">
                                            @if($status === 'active')
                                                @php
                                                    $endDate = \Carbon\Carbon::parse($internship->end_date)->endOfDay();
                                                    $now = \Carbon\Carbon::now()->startOfDay();
                                                    $diff = $now->diff($endDate);
                                                    $isExpired = $now->gt($endDate);
                                                    $remainingDays = $now->diffInDays($endDate, false);
                                                @endphp
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    Masa Berakhir
                                                </p>
                                                @if(!$isExpired)
                                                    <div class="text-[13px] font-black text-slate-700 dark:text-slate-200 leading-tight transition-colors">
                                                        {{ $endDate->format('d M y') }}
                                                    </div>
                                                    <div class="text-[10px] font-bold {{ $remainingDays > 10 ? 'text-slate-400 dark:text-slate-500' : 'text-orange-600 dark:text-orange-400' }} mt-0.5 px-1.5 py-0.5 inline-block rounded border border-transparent {{ $remainingDays <= 10 ? 'bg-orange-50 border-orange-200 dark:bg-orange-500/10 dark:border-orange-500/20' : '' }}">
                                                        Sisa: @if($diff->y > 0) {{ $diff->y }}th @endif @if($diff->m > 0) {{ $diff->m }}bln @endif @if($diff->d > 0) {{ $diff->d }}hr @elseif($remainingDays > 0 && $diff->y == 0 && $diff->m == 0) {{ $remainingDays }}hr @endif
                                                    </div>
                                                @elseif($remainingDays == 0)
                                                    <div class="text-[13px] font-black text-orange-600 dark:text-orange-400 leading-tight">Hari Terakhir</div>
                                                    <div class="text-[10px] font-medium text-slate-400 dark:text-slate-500 mt-0.5">Hari ini</div>
                                                @else
                                                    <div class="text-[13px] font-black text-slate-400 dark:text-slate-600 leading-tight">Selesai</div>
                                                @endif

                                            @elseif($status === 'extension')
                                                @php
                                                    $extension = $internship->extensions->first();
                                                @endphp
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Perpanjangan
                                                </p>
                                                <div class="text-[13px] font-black text-emerald-600 dark:text-emerald-400 leading-tight">
                                                    Ke {{ \Carbon\Carbon::parse($extension->new_end_date)->format('d M Y') }}
                                                </div>
                                                <div class="text-[10px] font-bold text-slate-500 mt-0.5 flex items-center gap-1.5">
                                                    <span>(+{{ \Carbon\Carbon::parse($extension->new_start_date)->diffInDays(\Carbon\Carbon::parse($extension->new_end_date)->addDay()) }}h)</span>
                                                </div>

                                            @else
                                                <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    Periode Magang
                                                </p>
                                                <div class="text-[13px] font-black text-slate-700 dark:text-slate-200 leading-tight">
                                                    {{ \Carbon\Carbon::parse($internship->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($internship->end_date)->format('d M y') }}
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex items-center gap-3 w-full sm:w-auto pt-2 lg:pt-0" {!! $isClickableRow ? 'onclick="event.stopPropagation()"' : '' !!}>
                                            @if(!in_array($status, ['active', 'finished']))
                                                <!-- Action Buttons for Non-Clickable Rows -->
                                                @if($status === 'pending')
                                                    @if($internship->status === 'pending')
                                                        <button @click="$dispatch('open-review-modal', { 
                                                            id: {{ $internship->id }}, 
                                                            name: '{{ addslashes($internship->student->name) }}', 
                                                            docs: {{ json_encode($internship->documents) }},
                                                            photo: '{{ $internship->student->studentProfile && $internship->student->studentProfile->photo ? $internship->student->studentProfile->photo : null }}'
                                                        })" 
                                                            class="min-w-[100px] flex justify-center px-4 py-2.5 text-[11px] uppercase tracking-wider font-extrabold rounded-xl text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 hover:bg-indigo-100 dark:hover:bg-indigo-500/20 shadow-sm transition-all shadow-indigo-500/10 active:scale-95 border border-indigo-200 dark:border-indigo-500/30">
                                                            Review
                                                        </button>
                                                    @elseif($internship->status === 'onboarding')
                                                        @php
                                                            $signedPact = $internship->documents->where('type', 'pakta_integritas_signed')->first();
                                                        @endphp
                                                        @if($signedPact)
                                                            <div class="flex items-center gap-2">
                                                                <a href="{{ Storage::url($signedPact->file_path) }}" target="_blank" class="p-2.5 rounded-xl text-slate-500 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 transition-colors border border-slate-200 dark:border-slate-700/80">
                                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                                </a>
                                                                <button @click="$dispatch('open-activation-modal', { id: {{ $internship->id }}, name: '{{ addslashes($internship->student->name) }}' })" 
                                                                    class="flex justify-center px-4 py-2.5 text-[10px] uppercase tracking-widest font-black rounded-xl text-white bg-emerald-500 hover:bg-emerald-600 shadow-md shadow-emerald-500/20 active:scale-95 transition-all">
                                                                    Activate
                                                                </button>
                                                            </div>
                                                        @else
                                                            <span class="inline-flex justify-center px-4 py-2.5 rounded-xl text-[10px] uppercase tracking-widest font-bold bg-slate-100 dark:bg-slate-800/50 text-slate-400 dark:text-slate-500 border border-slate-200 dark:border-slate-800/50">
                                                                Menunggu
                                                            </span>
                                                        @endif
                                                    @endif

                                                @elseif($status === 'extension')
                                                    @php $extension = $internship->extensions->first(); @endphp
                                                    <div class="flex items-center gap-2">
                                                        <a href="{{ Storage::url($extension->file_path) }}" target="_blank" class="p-2.5 rounded-xl text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 hover:text-indigo-900 transition-all shadow-sm border border-indigo-200 dark:border-indigo-500/30">
                                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                                        </a>
                                                        <form id="approve-extension-form-{{ $extension->id }}" action="{{ route('admin.internships.approveExtension', $extension->id) }}" method="POST">
                                                            @csrf @method('PATCH')
                                                            <button type="button" onclick="confirmApproveExtension('{{ $extension->id }}')" class="p-2.5 rounded-xl text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 hover:text-emerald-900 shadow-sm border border-emerald-200 dark:border-emerald-500/30 transition-all active:scale-95">
                                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path></svg>
                                                            </button>
                                                        </form>
                                                        <form id="reject-extension-form-{{ $extension->id }}" action="{{ route('admin.internships.rejectExtension', $extension->id) }}" method="POST">
                                                            @csrf @method('PATCH')
                                                            <button type="button" onclick="confirmRejectExtension('{{ $extension->id }}')" class="p-2.5 rounded-xl text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-500/10 hover:text-red-900 shadow-sm border border-red-200 dark:border-red-500/30 transition-all active:scale-95">
                                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            @else
                                                <!-- Contextual Badges -->
                                                @if($status === 'active')
                                                    <span class="inline-flex justify-center items-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest text-[#059669] dark:text-emerald-400 bg-[#ecfdf5] dark:bg-emerald-500/10 border border-[#d1fae5] dark:border-emerald-500/20 mr-2 shadow-sm">
                                                        ACTIVE
                                                    </span>
                                                @elseif($status === 'finished')
                                                    @php
                                                        $isSmk = optional($internship->student->studentProfile)->education_level === 'SMK';
                                                        $hasCertificate = $internship->documents->where('type', 'sertifikat_kelulusan')->count() > 0;
                                                    @endphp
                                                    <button @click="$dispatch('open-completion-modal', { id: {{ $internship->id }}, name: '{{ addslashes($internship->student->name) }}', isSmk: {{ $isSmk ? 'true' : 'false' }} })" 
                                                        class="inline-flex justify-center items-center px-4 py-2 text-[10px] uppercase tracking-wider font-extrabold rounded-xl border {{ $hasCertificate ? 'text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-500/10 border-indigo-200 dark:border-indigo-500/20 hover:bg-indigo-100' : 'text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-500/10 border-blue-200 dark:border-blue-500/20 hover:bg-blue-100' }} transition-all shadow-sm active:scale-95 mr-2">
                                                        {{ $hasCertificate ? 'Update Docs' : 'Send Certificate' }}
                                                    </button>
                                                @endif
                                                
                                                <!-- Details Link Arrow -->
                                                <div class="hidden sm:flex w-9 h-9 rounded-full items-center justify-center text-slate-400 group-hover:text-{{ $accentColor }}-500 group-hover:bg-{{ $accentColor }}-50 dark:group-hover:bg-{{ $accentColor }}-500/10 transition-all border border-transparent group-hover:border-{{ $accentColor }}-200 dark:group-hover:border-{{ $accentColor }}-500/20" title="Ke Detail Magang">
                                                    <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                                </div>
                                            @endif
                                        </div>
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
                                            <p class="text-lg font-bold text-slate-600 dark:text-slate-300">Tidak ada data terdaftar</p>
                                            <p class="text-sm font-medium text-slate-400 mt-0.5">Tidak ditemukan data peserta intern dengan status ini.</p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                     <div class="mt-8">
                        {{ $internships->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
        
        @include('admin.internships.partials.review-modal')
        @include('admin.internships.partials.completion-modal')
        @include('admin.internships.partials.activation-modal')
        @include('admin.internships.partials.extension-modal')

    </div>
    @push('scripts')
    <script>
        function confirmApproveExtension(id) {
            Swal.fire({
                title: 'Setujui Perpanjangan?',
                text: "Durasi magang akan diperbarui sesuai tanggal yang diajukan.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('approve-extension-form-' + id).submit();
                }
            })
        }

        function confirmRejectExtension(id) {
            Swal.fire({
                title: 'Tolak Perpanjangan?',
                text: "Pengajuan perpanjangan akan ditolak dan status kembali menjadi aktif.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reject-extension-form-' + id).submit();
                }
            })
        }

        function submitExtensionModalApprove() {
            const dateInput = document.getElementById('new_end_date');
            if (!dateInput.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Mohon isi tanggal selesai baru.',
                    buttonsStyling: false,
                    customClass: {
                        popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                        title: 'text-slate-900 dark:text-slate-100 font-bold',
                        htmlContainer: 'text-slate-600 dark:text-slate-400',
                        confirmButton: 'px-6 py-2.5 mx-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition-all active:scale-95',
                    }
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Persetujuan',
                text: "Apakah Anda yakin ingin menyetujui perpanjangan ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('extension-modal-approve-form').submit();
                }
            })
        }

        function submitExtensionModalReject() {
            Swal.fire({
                title: 'Konfirmasi Penolakan',
                text: "Apakah Anda yakin ingin menolak perpanjangan ini? Dokumen akan dihapus.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('extension-modal-reject-form').submit();
                }
            })
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
            });
        @endif
    </script>
    @endpush
</x-app-layout>
