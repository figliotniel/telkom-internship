<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight transition-colors">
            {{ __('Intern Bimbingan') }}
        </h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm transition-colors">Kelola data dan pantau progres intern bimbingan Anda</p>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-slate-950 min-h-screen transition-colors duration-300"> 
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-none sm:rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors duration-300">
                <div class="p-8">
                    {{-- Tabs Navigation & Filters --}}
                    <div class="border-b border-slate-200 dark:border-slate-800 mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 transition-colors">
                        <nav class="-mb-px flex space-x-10 overflow-x-auto w-full md:w-auto" aria-label="Tabs">
                            {{-- Active Tab --}}
                            <a href="{{ route('mentor.students.index', ['status' => 'active']) }}" 
                               class="{{ $status === 'active' ? 'border-red-500 text-red-600 dark:text-red-400' : 'border-transparent text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-700' }} 
                                      whitespace-nowrap py-5 px-1 border-b-2 font-black text-sm flex items-center transition-all">
                                Active Intern
                                <span class="{{ $status === 'active' ? 'bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-500' }} ml-3 py-0.5 px-3 rounded-full text-[10px] font-black inline-block transition-colors">
                                    {{ $activeCount }}
                                </span>
                            </a>

                            {{-- Finished Tab --}}
                            <a href="{{ route('mentor.students.index', ['status' => 'finished']) }}" 
                               class="{{ $status === 'finished' ? 'border-red-500 text-red-600 dark:text-red-400' : 'border-transparent text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 hover:border-slate-300 dark:hover:border-slate-700' }} 
                                      whitespace-nowrap py-5 px-1 border-b-2 font-black text-sm flex items-center transition-all">
                                Intern Selesai
                                <span class="{{ $status === 'finished' ? 'bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-500' }} ml-3 py-0.5 px-3 rounded-full text-[10px] font-black inline-block transition-colors">
                                    {{ $finishedCount }}
                                </span>
                            </a>
                        </nav>

                        {{-- Sub Filter (Only for Active Tab) --}}
                        @if($status === 'active')
                            <div class="inline-flex bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-1" role="group">
                                 <a href="{{ route('mentor.students.index', ['status' => 'active', 'type' => 'all']) }}" 
                                    class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all 
                                    {{ $type === 'all' 
                                       ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 shadow-sm' 
                                       : 'text-gray-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' }}">
                                    Semua
                                 </a>
                                 <a href="{{ route('mentor.students.index', ['status' => 'active', 'type' => 'mahasiswa']) }}" 
                                    class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all 
                                    {{ $type === 'mahasiswa' 
                                       ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 shadow-sm' 
                                       : 'text-gray-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' }}">
                                    Mahasiswa ({{ $activeMahasiswaCount }})
                                 </a>
                                 <a href="{{ route('mentor.students.index', ['status' => 'active', 'type' => 'smk']) }}" 
                                    class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all 
                                    {{ $type === 'smk' 
                                       ? 'bg-red-50 dark:bg-red-500/10 text-red-700 dark:text-red-400 shadow-sm' 
                                       : 'text-gray-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700' }}">
                                    SMK ({{ $activeSmkCount }})
                                 </a>
                            </div>
                        @endif
                    </div>
                <!-- Merged container padding applies naturally here -->
                    
                    <!-- Modern Stacked List -->
                    <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-sm mt-6">
                        <div class="divide-y divide-slate-100 dark:divide-slate-800/60">
                            @forelse($internships as $index => $data)
                                @php
                                    $isSmk = optional($data->student->studentProfile)->student_type === 'siswa' || optional($data->student->studentProfile)->education_level === 'SMK';
                                    $colorStyles = $isSmk ? 'from-amber-400/20 to-orange-500/20 text-amber-600 dark:text-amber-400 ring-amber-100 dark:ring-amber-500/20' : 'from-emerald-400/20 to-teal-500/20 text-emerald-600 dark:text-emerald-400 ring-emerald-100 dark:ring-emerald-500/20';
                                    $accentColor = $isSmk ? 'amber' : 'emerald';
                                @endphp

                                <div onclick="window.location='{{ route('mentor.students.show', $data->id) }}'" 
                                     class="p-5 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors group relative cursor-pointer">
                                    
                                    <!-- Edge Hover Indicator -->
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-{{ $accentColor }}-500 rounded-r-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                    <!-- Name & Avatar -->
                                    <div class="flex items-center gap-4 min-w-[280px] z-10">
                                        <div class="relative flex-shrink-0">
                                            @if($data->student->studentProfile && $data->student->studentProfile->photo)
                                                <img class="h-12 w-12 rounded-full object-cover shadow-inner ring-4 ring-white dark:ring-slate-900 group-hover:scale-105 transition-transform" 
                                                     src="{{ asset('storage/' . $data->student->studentProfile->photo) }}" 
                                                     alt="{{ $data->student->name }}">
                                            @else
                                                <div class="h-12 w-12 rounded-full bg-gradient-to-tr {{ $colorStyles }} flex items-center justify-center font-black text-xl shadow-inner ring-4 ring-white dark:ring-slate-900 group-hover:scale-105 transition-transform">
                                                    {{ strtoupper(substr($data->student->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full ring-2 ring-white dark:ring-slate-900 bg-{{ $status === 'active' ? 'emerald-500' : 'slate-400' }}"></span>
                                        </div>
                                        <div class="min-w-0 pr-4">
                                            <h3 class="font-bold text-slate-800 dark:text-white text-base leading-tight group-hover:text-{{ $accentColor }}-600 dark:group-hover:text-{{ $accentColor }}-400 transition-colors truncate" title="{{ $data->student->name }}">
                                                {{ $data->student->name }}
                                            </h3>
                                            <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400 mt-0.5 truncate" title="{{ $data->student->email }}">
                                                {{ $data->student->email }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Contextual Information -->
                                    <div class="flex-1 flex flex-col sm:flex-row items-start sm:items-center justify-start lg:justify-end gap-4 lg:gap-8 w-full lg:w-auto mt-2 lg:mt-0">
                                        
                                        <!-- Education & Major -->
                                        <div class="min-w-[150px] hidden md:flex flex-col text-left">
                                            <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                                Instansi & Jurusan
                                            </p>
                                            <div class="text-[13px] font-black text-slate-700 dark:text-slate-200 leading-tight truncate max-w-[200px]" title="{{ $data->student->studentProfile->university ?? 'Belum Lengkap' }}">
                                                {{ $data->student->studentProfile->university ?? 'Belum Lengkap' }}
                                            </div>
                                            <div class="flex items-center gap-2 mt-1">
                                                @php
                                                    $eduLevel = optional($data->student->studentProfile)->education_level ?? '-';
                                                    $eduClasses = ($eduLevel === 'SMK' || $eduLevel === 'Siswa')
                                                        ? 'bg-amber-100/50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20' 
                                                        : 'bg-emerald-100/50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20';
                                                @endphp
                                                <span class="px-2 py-0.5 inline-flex text-[9px] uppercase tracking-widest font-black rounded-md border {{ $eduClasses }}">
                                                    {{ $eduLevel }}
                                                </span>
                                                <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest truncate max-w-[120px]" title="{{ $data->student->studentProfile->major ?? '-' }}">
                                                    {{ $data->student->studentProfile->major ?? '-' }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Division -->
                                        <div class="min-w-[100px] hidden sm:block relative text-left">
                                            <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                Divisi
                                            </p>
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 transition-colors">
                                                {{ $data->division->name ?? '-' }}
                                            </span>
                                        </div>

                                        <!-- Date Period -->
                                        <div class="min-w-[130px] hidden sm:block relative text-right lg:text-left">
                                            <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest font-bold mb-1.5 flex items-center lg:justify-start justify-end gap-1 opacity-100 lg:opacity-0 group-hover:opacity-100 transition-opacity">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                Periode Magang
                                            </p>
                                            <div class="flex flex-col gap-1 items-end lg:items-start">
                                                <div class="text-[11px] font-black text-slate-700 dark:text-slate-200 leading-tight">
                                                    {{ \Carbon\Carbon::parse($data->start_date)->translatedFormat('d M Y') }}
                                                </div>
                                                <div class="text-[10px] font-medium text-slate-400 dark:text-slate-500">
                                                    s/d {{ \Carbon\Carbon::parse($data->end_date)->translatedFormat('d M Y') }}
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
                                <div class="px-6 py-20 text-center text-slate-500 dark:text-slate-400">
                                    <div class="flex flex-col items-center justify-center h-full gap-3">
                                        <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700 rounded-3xl flex items-center justify-center mb-1 shadow-sm">
                                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-lg font-bold text-slate-600 dark:text-slate-300">Belum ada intern</p>
                                            <p class="text-sm font-medium text-slate-400 mt-0.5">Tidak ditemukan intern bimbingan pada status ini.</p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>