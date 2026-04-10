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
                    <div class="bg-white dark:bg-[#0B1120] rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-slate-100 dark:border-slate-800 overflow-hidden flex flex-col group/mentees transition-all duration-300 mt-6 p-3">
                        <div class="flex flex-col gap-1.5">
                            @forelse($internships as $index => $data)
                                @php
                                    $isSmk = optional(optional($data->student)->studentProfile)->student_type === 'siswa' || optional(optional($data->student)->studentProfile)->education_level === 'SMK';
                                    $accentColor = $isSmk ? 'amber' : 'emerald';
                                @endphp

                                <div onclick="window.location='{{ route('mentor.students.show', $data->id) }}'" 
                                    class="p-4 mx-2 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-5 lg:gap-6 bg-transparent hover:bg-white dark:hover:bg-slate-800/60 rounded-[1.25rem] transition-all duration-300 group cursor-pointer border border-transparent hover:border-{{ $accentColor }}-200/50 dark:hover:border-slate-700/60 hover:shadow-[0_12px_40px_-10px_rgb(0,0,0,0.1)] dark:hover:shadow-none hover:-translate-y-0.5 relative z-10 overflow-hidden">
                                    
                                    <!-- Light Mode Hover Effect Layer -->
                                    <div class="absolute inset-0 bg-gradient-to-r from-{{ $accentColor }}-50/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10 rounded-[1.25rem] dark:hidden"></div>
                                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0 w-[4px] bg-gradient-to-b from-{{ $accentColor }}-400 to-{{ $accentColor }}-600 rounded-r-full group-hover:h-3/5 transition-all duration-500 opacity-0 group-hover:opacity-100 dark:hidden"></div>
                                    
                                    <!-- Container Kiri: Avatar & Nama -->
                                    <div class="flex items-center gap-4 lg:gap-5 w-full lg:w-[35%] min-w-[260px]">
                                        <div class="relative flex-shrink-0">
                                            @if($data->student->avatar_url)
                                                <img class="h-[52px] w-[52px] rounded-full object-cover shadow-inner ring-1 ring-slate-200 dark:ring-slate-700/50 group-hover:scale-105 group-hover:ring-{{ $accentColor }}-500/50 transition-all duration-300" 
                                                     src="{{ $data->student->avatar_url }}" 
                                                     alt="{{ $data->student->name }}">
                                            @else
                                                <div class="h-[52px] w-[52px] rounded-full bg-slate-100 dark:bg-[#1E293B] flex items-center justify-center font-black text-xl text-{{ $accentColor }}-600 dark:text-{{ $accentColor }}-500 border border-slate-200 dark:border-slate-700/80 shadow-inner group-hover:scale-105 group-hover:border-{{ $accentColor }}-500/50 transition-all duration-300">
                                                    {{ strtoupper(substr($data->student->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            
                                            @if($status == 'active')
                                                <div class="absolute bottom-0 right-0.5 flex h-3.5 w-3.5 items-center justify-center">
                                                    <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 animate-ping"></span>
                                                    <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-emerald-500 ring-[2.5px] ring-white dark:ring-[#0B1120] shadow-[0_0_10px_rgba(16,185,129,0.8)]"></span>
                                                </div>
                                            @else
                                                <div class="absolute bottom-0 right-0.5 flex h-3.5 w-3.5 items-center justify-center">
                                                    <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-slate-400 ring-[2.5px] ring-white dark:ring-[#0B1120] shadow-sm"></span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0 pr-2">
                                            <h3 class="font-bold text-slate-800 dark:text-gray-100 text-[15px] leading-tight group-hover:text-{{ $accentColor }}-600 dark:group-hover:text-{{ $accentColor }}-400 transition-colors truncate" title="{{ $data->student->name }}">
                                                {{ $data->student->name }}
                                            </h3>
                                            <p class="text-[12px] font-medium text-slate-500 dark:text-slate-400 mt-1 truncate" title="{{ $data->student->email }}">
                                                {{ $data->student->email }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Container Tengah: Instansi & Jurusan -->
                                    <div class="w-full lg:w-[25%] hidden md:flex flex-col">
                                        <div class="text-[13px] font-black text-slate-700 dark:text-slate-200 leading-tight truncate max-w-[200px]" title="{{ $data->student->studentProfile->university ?? 'Belum Lengkap' }}">
                                            {{ $data->student->studentProfile->university ?? 'Belum Lengkap' }}
                                        </div>
                                        <div class="flex items-center gap-2 mt-1.5">
                                            @php
                                                $eduLevel = optional($data->student->studentProfile)->education_level ?? '-';
                                                $eduClasses = ($eduLevel === 'SMK' || $eduLevel === 'Siswa')
                                                    ? 'bg-amber-100/50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20' 
                                                    : 'bg-emerald-100/50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20';
                                            @endphp
                                            <span class="px-2 py-0.5 inline-flex text-[9px] uppercase tracking-widest font-black rounded-md border shadow-sm {{ $eduClasses }}">
                                                {{ $eduLevel }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest truncate max-w-[120px]" title="{{ $data->student->studentProfile->major ?? '-' }}">
                                                {{ $data->student->studentProfile->major ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Container Tengah: Division -->
                                    <div class="w-full lg:w-[15%] hidden sm:block">
                                        <span class="inline-flex py-2 px-3.5 rounded-xl text-[9px] font-black uppercase tracking-widest bg-slate-50 dark:bg-[#151E32] text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700/60 shadow-sm leading-snug max-w-[150px] line-clamp-2">
                                            {{ $data->division->name ?? '-' }}
                                        </span>
                                    </div>

                                    <!-- Container Kanan: Periode -->
                                    <div class="w-full lg:w-[25%] flex items-center justify-end gap-5 border-t border-slate-100 dark:border-slate-800/60 lg:border-t-0 pt-4 lg:pt-0">
                                        <div class="flex flex-col gap-1 items-end text-right">
                                            <div class="text-[12px] font-black text-slate-700 dark:text-slate-200 leading-tight">
                                                {{ \Carbon\Carbon::parse($data->start_date)->translatedFormat('d M Y') }}
                                            </div>
                                            <div class="text-[11px] font-medium text-slate-400 dark:text-slate-500">
                                                s/d {{ \Carbon\Carbon::parse($data->end_date)->translatedFormat('d M Y') }}
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
                                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-lg font-black text-slate-700 dark:text-slate-200 tracking-tight">Belum ada intern</p>
                                            <p class="text-sm font-medium text-slate-400 mt-1 max-w-sm mx-auto leading-relaxed">Tidak ditemukan intern bimbingan pada status ini.</p>
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