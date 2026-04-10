<x-app-layout>
    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 w-full">
            <div class="rounded-xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 p-4 mb-4 flex items-start gap-3 shadow-sm transition-colors duration-300" role="alert">
                <div class="shrink-0 text-emerald-500 dark:text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <strong class="block text-sm font-bold text-emerald-800 dark:text-emerald-300">Berhasil!</strong>
                    <span class="text-sm text-emerald-700 dark:text-emerald-400/90">{{ session('success') }}</span>
                </div>
            </div>
        </div>
    @endif

    {{-- Pesan Error --}}
    @if(session('error') || $errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 w-full">
            <div class="rounded-xl bg-red-50 dark:bg-red-500/10 border border-red-100 dark:border-red-500/20 p-4 mb-4 flex items-start gap-3 shadow-sm transition-colors duration-300" role="alert">
                <div class="shrink-0 text-red-500 dark:text-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <strong class="block text-sm font-bold text-red-800 dark:text-red-300">Perhatian!</strong>
                    <span class="text-sm text-red-700 dark:text-red-400/90">{{ session('error') ?? $errors->first() }}</span>
                </div>
            </div>
        </div>
    @endif

    @if($internship->status !== 'finished')
        <!-- 1. Immersive Hero Section -->
        <div class="relative bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 overflow-hidden pt-8 md:pt-12 pb-24 md:pb-32 px-4 sm:px-6 lg:px-10 w-full block transition-colors duration-300">
            <!-- Abstract Background Elements -->
            <div class="absolute inset-0 z-0 opacity-20 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmZmZmYiLz48L3N2Zz4=')] [mask-image:linear-gradient(to_bottom,white,transparent)]"></div>
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-500/10 rounded-full blur-[100px] -mr-32 -mt-32 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-red-500/10 rounded-full blur-[100px] -ml-20 -mb-20 pointer-events-none"></div>
            
            <!-- Bottom Fade Overlay -->
            <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-slate-50 dark:from-slate-950 to-transparent pointer-events-none z-0"></div>

            <div class="max-w-7xl mx-auto relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-8 md:gap-16">
                <div class="flex-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 dark:bg-white/5 border border-emerald-100 dark:border-white/10 rounded-full text-[10px] font-bold uppercase tracking-widest text-emerald-600 dark:text-emerald-400 mb-6 backdrop-blur-md transition-colors duration-300">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.5)] dark:shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span>
                        Internship Aktif
                    </div>
                    <h1 class="text-3xl md:text-5xl font-black tracking-tight text-slate-800 dark:text-white mb-3 transition-colors duration-300">{{ __('Hello,') }} <span class="text-red-600 dark:text-red-500">{{ explode(' ', Auth::user()->name)[0] }}!</span></h1>
                    <p class="text-slate-600 dark:text-slate-400 text-sm md:text-base font-medium max-w-xl leading-relaxed transition-colors duration-300">
                        Tetap semangat! Anda telah berhasil menyelesaikan rangkaian misi magang Anda sejauh ini. Mari selesaikan hari ini dengan produktif.
                    </p>
                </div>
                
                @if(isset($internship) && $internship->end_date)
                    @php
                        $endDate = \Carbon\Carbon::parse($internship->end_date);
                        $now = \Carbon\Carbon::now();
                        $diff = $now->diff($endDate);
                        
                        $totalWorkingDays = $internship->start_date && $internship->end_date 
                            ? \Carbon\Carbon::parse($internship->start_date)->diffInDaysFiltered(function (\Carbon\Carbon $date) {
                                return true; // Just simple days count for progress bar
                            }, $endDate) : 1;
                        $daysPassed = $internship->start_date 
                            ? \Carbon\Carbon::parse($internship->start_date)->diffInDaysFiltered(function (\Carbon\Carbon $date) {
                                return true;
                            }, $now) : 0;
                            
                        $progressPercent = $totalWorkingDays > 0 ? min(100, round(($daysPassed / $totalWorkingDays) * 100)) : 0;
                    @endphp
                    <!-- Circular Progressive Timeline Widget (HUD Style) -->
                    <div class="w-full md:w-auto shrink-0 flex flex-col md:flex-row items-center gap-6 md:gap-10 relative z-20 bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-slate-200/50 dark:border-slate-700/50 p-6 md:p-8 rounded-[2rem] shadow-xl dark:shadow-2xl transition-colors duration-300">
                        <!-- Circular Progress -->
                        <div class="relative w-36 h-36 flex-shrink-0">
                            <svg class="w-full h-full transform -rotate-90 overflow-visible" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="45" fill="none" class="stroke-slate-200 dark:stroke-white/10 transition-colors duration-300" stroke-width="6" />
                                <circle cx="50" cy="50" r="45" fill="none" stroke="currentColor" stroke-width="6" stroke-dasharray="282.6" stroke-dashoffset="{{ 282.6 - (282.6 * $progressPercent / 100) }}" stroke-linecap="round" class="text-emerald-500 dark:text-emerald-400 drop-shadow-[0_0_8px_rgba(16,185,129,0.4)] dark:drop-shadow-[0_0_8px_rgba(52,211,153,0.8)] transition-all duration-1000 ease-out" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-4xl font-black text-slate-800 dark:text-white transition-colors duration-300 tracking-tighter">{{ $progressPercent }}<span class="text-xl">%</span></span>
                                <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest mt-1">Capaian</span>
                            </div>
                        </div>

                        <!-- Context Info -->
                        <div class="space-y-5">
                            <div>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 uppercase tracking-widest font-bold mb-1.5 flex items-center gap-1.5 transition-colors duration-300">
                                    <svg class="w-3.5 h-3.5 text-emerald-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    Sisa Waktu
                                </p>
                                <div class="flex flex-wrap items-baseline gap-3">
                                    @php
                                        $totalMonths = $diff->m + ($diff->y * 12);
                                    @endphp
                                    @if($totalMonths > 0)
                                        <div class="flex items-baseline gap-1.5">
                                            <span class="text-5xl font-black tracking-tighter text-slate-800 dark:text-white transition-colors duration-300 leading-none">{{ $totalMonths }}</span>
                                            <span class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Bulan</span>
                                        </div>
                                    @endif
                                    @if($diff->d > 0 || $totalMonths === 0)
                                        <div class="flex items-baseline gap-1.5">
                                            <span class="text-5xl font-black tracking-tighter text-slate-800 dark:text-white transition-colors duration-300 leading-none">{{ $diff->d }}</span>
                                            <span class="text-sm font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Hari</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-8 border-t border-slate-200 dark:border-white/10 pt-4 transition-colors duration-300">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-slate-500 uppercase tracking-widest font-bold mb-0.5">Mulai</span>
                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 transition-colors duration-300">{{ \Carbon\Carbon::parse($internship->start_date)->translatedFormat('M Y') }}</span>
                                </div>
                                <div class="w-px bg-slate-200 dark:bg-slate-700/50"></div>
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-slate-500 uppercase tracking-widest font-bold mb-0.5">Selesai</span>
                                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 transition-colors duration-300">{{ \Carbon\Carbon::parse($internship->end_date)->translatedFormat('M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- 2. Main Content Grid (Overlapping Hero) -->
        <div class="w-full block pb-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 md:-mt-16 relative z-20 space-y-6">
            
            <!-- KPI Bento Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8 mt-2">
                
                <!-- Kehadiran -->
                <div class="relative bg-emerald-50/50 dark:bg-[#0d1424] rounded-[2rem] p-7 border border-emerald-100/80 dark:border-slate-800 shadow-[0_8px_30px_rgb(0,0,0,0.02)] dark:shadow-xl overflow-hidden group hover:bg-emerald-50 dark:hover:bg-[#0d1424] hover:dark:border-emerald-500/30 transition-colors duration-500">
                    <div class="absolute right-[-5%] dark:right-[-10%] top-[-10%] text-emerald-100 dark:text-emerald-500 opacity-60 dark:opacity-5 group-hover:dark:opacity-10 group-hover:rotate-12 transition-all duration-700 transform scale-[2.2] dark:scale-[2]">
                        <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    
                    <div class="relative z-10 flex flex-col justify-between h-full space-y-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-bold text-emerald-600/70 dark:text-slate-400 uppercase tracking-widest mb-1">Total Kehadiran</p>
                                <h3 class="text-4xl font-light text-emerald-950 dark:text-white tracking-wide">{{ str_pad($totalPresent, 2, '0', STR_PAD_LEFT) }} <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-400 px-2 py-1 bg-white/60 dark:bg-emerald-500/10 rounded-lg ml-1 shadow-sm dark:shadow-none backdrop-blur-sm">HARI</span></h3>
                            </div>
                            <div class="w-10 h-10 rounded-full border border-emerald-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-sm dark:shadow-inner group-hover:scale-110 dark:group-hover:scale-100 group-hover:dark:bg-emerald-500/10 group-hover:dark:border-emerald-500/30 transition-all">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>
                        
                        <div class="w-full bg-emerald-100 dark:bg-slate-800/80 rounded-full h-1.5 overflow-hidden border border-transparent">
                            @php
                                $totalWorkingDays = isset($totalWorkingDays) && $totalWorkingDays > 0 ? $totalWorkingDays : 1;
                                $presentPercentage = min(100, ($totalPresent / $totalWorkingDays) * 100);
                            @endphp
                            <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-1.5 rounded-full shadow-[0_0_10px_rgba(52,211,153,0.5)]" style="width: {{ $presentPercentage > 0 ? max(2, $presentPercentage) : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Izin / Sakit -->
                <div class="relative bg-amber-50/50 dark:bg-[#0d1424] rounded-[2rem] p-7 border border-amber-100/80 dark:border-slate-800 shadow-[0_8px_30px_rgb(0,0,0,0.02)] dark:shadow-xl overflow-hidden group hover:bg-amber-50 dark:hover:bg-[#0d1424] hover:dark:border-amber-500/30 transition-colors duration-500">
                    <div class="absolute right-[-5%] dark:right-[-10%] top-[-20%] text-amber-100 dark:text-amber-500 opacity-60 dark:opacity-5 group-hover:dark:opacity-10 group-hover:rotate-12 transition-all duration-700 transform scale-[2.2] dark:scale-[2]">
                        <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    
                    <div class="relative z-10 flex flex-col justify-between h-full space-y-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-bold text-amber-600/70 dark:text-slate-400 uppercase tracking-widest mb-1">Izin / Sakit / Cuti</p>
                                <h3 class="text-4xl font-light text-amber-950 dark:text-white tracking-wide">{{ str_pad($totalPermit + $totalSick, 2, '0', STR_PAD_LEFT) }} <span class="text-[11px] font-bold text-amber-700 dark:text-amber-400 px-2 py-1 bg-white/60 dark:bg-amber-500/10 rounded-lg ml-1 shadow-sm dark:shadow-none backdrop-blur-sm">KALI</span></h3>
                            </div>
                            <div class="w-10 h-10 rounded-full border border-amber-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 flex items-center justify-center text-amber-500 dark:text-amber-400 shadow-sm dark:shadow-inner group-hover:scale-110 dark:group-hover:scale-100 group-hover:dark:bg-amber-500/10 group-hover:dark:border-amber-500/30 transition-all">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                        </div>
                        
                        <div class="w-full bg-amber-100 dark:bg-slate-800/80 rounded-full h-1.5 overflow-hidden border border-transparent">
                            @php
                                $leavePercentage = min(100, (($totalPermit + $totalSick) / max(1, $totalWorkingDays)) * 100);
                            @endphp
                            <div class="bg-gradient-to-r from-amber-500 to-amber-400 h-1.5 rounded-full shadow-[0_0_10px_rgba(251,191,36,0.5)]" style="width: {{ $leavePercentage > 0 ? max(2, $leavePercentage) : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Logbook -->
                <div class="relative bg-blue-50/50 dark:bg-[#0d1424] rounded-[2rem] p-7 border border-blue-100/80 dark:border-slate-800 shadow-[0_8px_30px_rgb(0,0,0,0.02)] dark:shadow-xl overflow-hidden group hover:bg-blue-50 dark:hover:bg-[#0d1424] hover:dark:border-blue-500/30 transition-colors duration-500">
                    <div class="absolute right-[-5%] dark:right-[-10%] top-[-10%] text-blue-100 dark:text-blue-500 opacity-60 dark:opacity-5 group-hover:dark:opacity-10 group-hover:-rotate-12 transition-all duration-700 transform scale-[2.2] dark:scale-[2]">
                        <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    
                    @php
                        $validLogbooks = \App\Models\DailyLogbook::where('internship_id', $internship->id)->where('status', 'approved')->count();
                    @endphp
                    <div class="relative z-10 flex flex-col justify-between h-full space-y-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-bold text-blue-600/70 dark:text-slate-400 uppercase tracking-widest mb-1">Logbook Diterima</p>
                                <h3 class="text-4xl font-light text-blue-950 dark:text-white tracking-wide">{{ str_pad($validLogbooks, 2, '0', STR_PAD_LEFT) }} <span class="text-[11px] font-bold text-blue-700 dark:text-blue-400 px-2 py-1 bg-white/60 dark:bg-blue-500/10 rounded-lg ml-1 shadow-sm dark:shadow-none backdrop-blur-sm">DATA</span></h3>
                            </div>
                            <div class="w-10 h-10 rounded-full border border-blue-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 flex items-center justify-center text-blue-500 dark:text-blue-400 shadow-sm dark:shadow-inner group-hover:scale-110 dark:group-hover:scale-100 group-hover:dark:bg-blue-500/10 group-hover:dark:border-blue-500/30 transition-all">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                            </div>
                        </div>
                        
                        <div class="w-full bg-blue-100 dark:bg-slate-800/80 rounded-full h-1.5 overflow-hidden border border-transparent">
                            @php
                                $logbookPercentage = min(100, ($validLogbooks / max(1, $totalWorkingDays)) * 100);
                            @endphp
                            <div class="bg-gradient-to-r from-blue-500 to-blue-400 h-1.5 rounded-full shadow-[0_0_10px_rgba(59,130,246,0.5)]" style="width: {{ $logbookPercentage > 0 ? max(2, $logbookPercentage) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
    @else
        <div class="pb-8 pt-8 w-full block">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Graduation Showcase / Banner Kelulusan --}}
            @if($internship->status === 'finished')
                <div class="bg-gradient-to-tr from-slate-900 to-slate-800 rounded-[2rem] p-8 md:p-12 text-white relative overflow-hidden flex flex-col md:flex-row items-center gap-8 shadow-2xl transition-all border border-slate-700/50 hover:border-slate-600">
                    <!-- abstract geometry -->
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-red-500/20 rounded-full blur-3xl opacity-50 backdrop-blur-3xl animate-pulse"></div>
                    <div class="absolute bottom-0 left-0 w-full h-1.5 bg-gradient-to-r from-red-500 to-orange-500"></div>

                    <div class="flex-shrink-0 relative z-10 w-24 h-24 md:w-32 md:h-32 bg-white/10 backdrop-blur-md border border-white/20 rounded-full flex items-center justify-center text-5xl md:text-6xl shadow-inner group-hover:rotate-12 transition-transform duration-500">
                        🎓
                    </div>
                    
                    <div class="text-center md:text-left relative z-10 flex-1">
                        <p class="text-[10px] md:text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Program Telah Berakhir</p>
                        <h3 class="font-black text-3xl md:text-4xl text-white mb-3 tracking-tight">Selamat, Anda berhasil lulus!</h3>
                        <p class="text-slate-300 text-sm md:text-base max-w-2xl leading-relaxed mb-6 font-medium">
                            Anda telah resmi menyelesaikan program magang di <strong class="text-white">Telkom Witel Semarang Jateng Utara</strong>. Terima kasih atas dedikasi dan kontribusi Anda. Semoga ilmu dan pengalaman yang didapatkan membawa manfaat bagi masa depan karir Anda.
                        </p>
                        
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4">
                            {{-- Transkrip Nilai --}}
                            @php
                                $transcriptDoc = $internship->documents->where('type', 'transcript')->first();
                                $gradDocs = $internship->documents->whereIn('type', ['sertifikat_kelulusan', 'laporan_penilaian_pkl', 'dokumen_kelulusan']);
                            @endphp
                            
                            @if($transcriptDoc)
                                <a href="{{ Storage::url($transcriptDoc->file_path) }}" target="_blank" class="px-5 py-3 bg-red-500 hover:bg-red-600 border border-red-400 text-white rounded-xl text-[11px] font-black uppercase tracking-widest shadow-lg shadow-red-500/20 active:scale-95 transition-all flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                    Transkrip Nilai
                                </a>
                            @else
                                <div class="px-5 py-3 bg-white/10 backdrop-blur-sm border border-white/20 text-white/50 rounded-xl text-[11px] font-bold uppercase tracking-widest flex items-center gap-2 cursor-not-allowed">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg> Transkrip Diproses...
                                </div>
                            @endif

                            @foreach($gradDocs as $doc)
                                <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="px-5 py-3 bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-white/20 text-white rounded-xl text-[11px] font-black uppercase tracking-widest active:scale-95 transition-all flex items-center gap-2 shadow-sm">
                                    {{ str_contains(strtolower($doc->name), 'sertifikat') ? '🎖️' : '📄' }} {{ Str::limit($doc->name, 20) }}
                                </a>
                            @endforeach

                            {{-- Laporan Akhir Upload Button --}}
                            <button @click="$dispatch('open-final-report-modal')" class="px-5 py-3 bg-purple-500/20 backdrop-blur-sm border border-purple-400/30 hover:bg-purple-500/40 hover:border-purple-400/50 text-purple-100 hover:text-white rounded-xl text-[11px] font-black uppercase tracking-widest active:scale-95 transition-all flex items-center gap-2 shadow-sm group">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                                Upload Laporan
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Transcript and Other Alumni Content --}}
                @if($internship->evaluation)
                    {{-- 1. Transcript Display --}}
                    <div x-data="{ show: false }" class="bg-white dark:bg-slate-900 overflow-hidden shadow-md sm:rounded-2xl border border-slate-200 dark:border-slate-800 transition-colors duration-300">
                        <div class="px-6 py-4 bg-slate-50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-lg text-slate-800 dark:text-slate-200">Transkrip Nilai Internal</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Hasil evaluasi akhir kegiatan magang Anda</p>
                            </div>
                            <div class="flex gap-3">
                                <button @click="show = !show" class="text-sm font-semibold text-slate-600 dark:text-slate-400 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 px-4 py-2 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors shadow-sm flex items-center gap-2">
                                    <span x-text="show ? 'Sembunyikan' : 'Lihat Detail'"></span>
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                                </button>
                                <a href="{{ route('documents.transcript') }}" target="_blank" class="text-sm font-semibold text-white bg-red-600 border border-red-600 px-4 py-2 rounded-lg hover:bg-red-700 transition-colors shadow-sm flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015-1.837-2.175a48.041 48.041 0 00-1.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" /></svg>
                                    Cetak PDF
                                </a>
                            </div>
                        </div>
                        <div x-show="show" x-transition class="border-t border-slate-100 dark:border-slate-800">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-800">
                                    <thead class="bg-gray-50 dark:bg-slate-950/50 transition-colors">
                                        <tr>
                                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors w-12">No</th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors">Komponen Penilaian</th>
                                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors w-32">Nilai Angka</th>
                                            <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-widest transition-colors w-32">Predikat</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-900 divide-y divide-gray-200 dark:divide-slate-800 transition-colors mb-0 border-b border-gray-200 dark:border-slate-800">
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center">1</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">Kedisiplinan & Etika Kerja</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center font-medium">{{ $internship->evaluation->discipline_score }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center">{{ $internship->evaluation->discipline_score >= 85 ? 'A' : ($internship->evaluation->discipline_score >= 70 ? 'B' : 'C') }}</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center">2</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">Kemampuan Teknis & Hasil Kerja</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center font-medium">{{ $internship->evaluation->technical_score }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center">{{ $internship->evaluation->technical_score >= 85 ? 'A' : ($internship->evaluation->technical_score >= 70 ? 'B' : 'C') }}</td>
                                        </tr>
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center">3</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors">Komunikasi & Kerjasama Tim</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center font-medium">{{ $internship->evaluation->soft_skill_score }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300 transition-colors text-center">{{ $internship->evaluation->soft_skill_score >= 85 ? 'A' : ($internship->evaluation->soft_skill_score >= 70 ? 'B' : 'C') }}</td>
                                        </tr>
                                        <tr class="bg-red-50/30 dark:bg-red-500/5 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                                            <td colspan="2" class="px-6 py-4 whitespace-nowrap text-sm text-slate-800 dark:text-slate-100 transition-colors text-right font-bold w-full">Nilai Akhir Rata-Rata</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-red-600 dark:text-red-400 transition-colors text-center font-bold text-lg border-x border-red-100 dark:border-red-500/10">{{ $internship->evaluation->final_score }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-red-600 dark:text-red-400 transition-colors text-center font-bold text-lg">{{ $internship->evaluation->final_score >= 85 ? 'A' : ($internship->evaluation->final_score >= 70 ? 'B' : 'C') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @endif


            {{-- Main Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Left Column: Logbook List (Takes 2/3 width on large screens) --}}
                <div class="lg:col-span-2 space-y-6">
                    <x-logbook-history :logbooks="$logbooks" :todayLogbook="$todayLogbook" />
                </div> {{-- End Left Column --}}

                {{-- Right Column: Absensi & Mentor --}}
                <div class="space-y-6 relative">
                    <div class="sticky top-6 space-y-6">
                    {{-- Absensi Card --}}
                    @if($internship->status !== 'finished')
                    <!-- Typography Minimalist Attendance Card (Opsi 3) -->
                    <div class="bg-white dark:bg-[#131418] rounded-[2.5rem] p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-200/60 dark:border-slate-800/80 transition-all duration-500 relative flex flex-col mb-6 hover:shadow-xl hover:border-red-100 dark:hover:border-red-900/30">
                        <div class="flex flex-col h-full">

                            <!-- HEADER -->
                            <div class="mb-6 flex justify-between items-center">
                                <div class="w-10 h-10 bg-red-50 dark:bg-[#ed1e28]/10 text-[#ed1e28] dark:text-red-400 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" /></svg>
                                </div>
                                <span class="px-3 py-1 bg-[#ed1e28] text-white rounded-full text-[10px] font-bold uppercase tracking-widest shadow-sm">Absensi</span>
                            </div>

                            <!-- TYPOGRAPHY / DATE -->
                            <div class="mb-10">
                                <p class="text-slate-400 dark:text-slate-500 text-sm font-semibold mb-1 uppercase tracking-wider">{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</p>
                                
                                <!-- EXTREME TYPOGRAPHY LOGIC -->
                                @if(!$todayAttendance)
                                    <h4 class="font-light text-[2.5rem] leading-[1.1] text-slate-900 dark:text-white tracking-tight">Belum<br><span class="font-bold text-[#ed1e28] dark:text-red-500">Check-In</span></h4>
                                @elseif($todayAttendance->permit_type === 'temporary' && !$todayAttendance->check_in_time)
                                    @php
                                        $permitEndTime = \Carbon\Carbon::parse($todayAttendance->date . ' ' . $todayAttendance->permit_end_time);
                                        $isLocked = \Carbon\Carbon::now()->lt($permitEndTime);
                                    @endphp
                                    @if($isLocked)
                                        <h4 class="font-light text-[2.5rem] leading-[1.1] text-slate-900 dark:text-white tracking-tight">Izin<br><span class="font-bold text-amber-500">Sementara</span></h4>
                                        <p class="text-xs text-slate-500 font-bold mt-2 bg-slate-50 dark:bg-slate-800/50 inline-block px-2 py-1 rounded-md">Buka pukul {{ $permitEndTime->format('H:i') }}</p>
                                    @else
                                        <h4 class="font-light text-[2.5rem] leading-[1.1] text-slate-900 dark:text-white tracking-tight">Izin<br><span class="font-bold text-emerald-500">Selesai</span></h4>
                                    @endif
                                @elseif($todayAttendance->permit_type === 'full')
                                    <h4 class="font-light text-[2.5rem] leading-[1.1] text-slate-900 dark:text-white tracking-tight">Izin<br><span class="font-bold text-indigo-500">Full Day</span></h4>
                                @elseif(!$todayAttendance->check_out_time)
                                    <h4 class="font-light text-[2.5rem] leading-[1.1] text-slate-900 dark:text-white tracking-tight">Sedang<br><span class="font-bold text-emerald-500">Hadir</span></h4>
                                    <p class="text-xs text-slate-500 font-bold mt-2 bg-slate-50 dark:bg-slate-800/50 inline-block px-2 py-1 rounded-md">Masuk: {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }}</p>
                                @else
                                    <h4 class="font-light text-[2.5rem] leading-[1.1] text-slate-900 dark:text-white tracking-tight">Selesai<br><span class="font-bold text-slate-500">Hari Ini</span></h4>
                                    <div class="flex gap-2 text-xs text-slate-500 font-bold mt-2">
                                        <span class="bg-slate-50 dark:bg-slate-800/50 px-2 py-1 rounded-md">M: {{ \Carbon\Carbon::parse($todayAttendance->check_in_time)->format('H:i') }}</span>
                                        <span class="bg-slate-50 dark:bg-slate-800/50 px-2 py-1 rounded-md">P: {{ \Carbon\Carbon::parse($todayAttendance->check_out_time)->format('H:i') }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- MAIN BUTTON LOGIC -->
                            @if(!$todayAttendance)
                                @if($isCheckInTime)
                                    <form action="{{ route('attendance.checkIn') }}" method="POST" id="checkInForm" class="w-full mt-auto">
                                        @csrf
                                        <input type="hidden" name="latitude" id="lat_in">
                                        <input type="hidden" name="longitude" id="long_in">
                                        <button type="button" onclick="confirmCheckIn()" class="w-full bg-slate-900 hover:bg-slate-800 dark:bg-white dark:hover:bg-slate-100 text-white dark:text-slate-900 font-semibold py-4 rounded-full transition-all duration-300 shadow-[0_8px_20px_rgba(0,0,0,0.1)] flex justify-between items-center px-6 group">
                                            <span>Lakukan Presensi</span>
                                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </button>
                                    </form>
                                @else
                                    <div class="w-full mt-auto bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 text-slate-400 font-semibold py-4 rounded-full text-center flex flex-col justify-center items-center cursor-not-allowed">
                                        <span class="text-sm">Check-In Ditutup (07:00-09:00)</span>
                                    </div>
                                @endif
                                
                            @elseif($todayAttendance->permit_type === 'temporary' && !$todayAttendance->check_in_time)
                                @if(!\Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($todayAttendance->date . ' ' . $todayAttendance->permit_end_time)))
                                    <form action="{{ route('attendance.checkIn') }}" method="POST" id="checkInForm" class="w-full mt-auto">
                                        @csrf
                                        <input type="hidden" name="latitude" id="lat_in">
                                        <input type="hidden" name="longitude" id="long_in">
                                        <button type="button" onclick="confirmCheckIn()" class="w-full bg-slate-900 hover:bg-slate-800 dark:bg-white dark:hover:bg-slate-100 text-white dark:text-slate-900 font-semibold py-4 rounded-full transition-all duration-300 shadow-[0_8px_20px_rgba(0,0,0,0.1)] flex justify-between items-center px-6 group">
                                            <span>Check-In Kembali</span>
                                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </button>
                                    </form>
                                @else
                                    <div class="w-full mt-auto bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 text-amber-600 dark:text-amber-400 font-semibold py-4 rounded-full text-center flex flex-col justify-center items-center cursor-not-allowed">
                                        <span class="text-sm">Dalam Waktu Izin</span>
                                    </div>
                                @endif
                                
                            @elseif($todayAttendance->permit_type === 'full')
                                <div class="w-full mt-auto bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-200 dark:border-indigo-500/20 text-indigo-600 dark:text-indigo-400 font-semibold py-4 rounded-full text-center flex flex-col justify-center items-center cursor-not-allowed">
                                    <span class="text-sm">Izin Diberikan</span>
                                </div>
                                
                            @elseif(!$todayAttendance->check_out_time)
                                @if($isCheckOutTime)
                                    <form action="{{ route('attendance.checkOut') }}" method="POST" id="checkOutForm" class="w-full mt-auto">
                                        @csrf
                                        <button type="button" onclick="confirmCheckOut()" class="w-full bg-slate-900 hover:bg-slate-800 dark:bg-white dark:hover:bg-slate-100 text-white dark:text-slate-900 font-semibold py-4 rounded-full transition-all duration-300 shadow-[0_8px_20px_rgba(0,0,0,0.1)] flex justify-between items-center px-6 group">
                                            <span>Check-Out Pulang</span>
                                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </button>
                                    </form>
                                @else
                                    <div class="w-full mt-auto bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 text-slate-400 font-semibold py-4 rounded-full text-center flex flex-col justify-center items-center cursor-not-allowed">
                                        <span class="text-sm">Belum Waktu Pulang (17:00-19:00)</span>
                                    </div>
                                @endif
                                
                            @else
                                <div class="w-full mt-auto bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-semibold py-4 rounded-full text-center flex flex-col justify-center items-center cursor-not-allowed">
                                    <span class="text-sm">Kehadiran Selesai ✓</span>
                                </div>
                            @endif

                            <!-- SECONDARY LINKS LOGIC (Izin) -->
                            <div class="flex flex-col gap-3 mt-6 border-t border-slate-100 dark:border-slate-800/80 pt-5">
                                @if((!$todayAttendance || ($todayAttendance && !$todayAttendance->check_out_time)) && (!isset($todayAttendance->permit_type) || $todayAttendance->permit_type !== 'full'))
                                    
                                    <button type="button" @click="{{ $hasTemporaryPermitToday ? 'showDuplicatePermitError()' : '$dispatch(\'open-permission-modal\')' }}" class="flex justify-between items-center text-sm font-medium {{ $hasTemporaryPermitToday ? 'text-slate-300 dark:text-slate-700 cursor-not-allowed' : 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 group/link' }} transition-colors py-1">
                                        <span>Ajukan Izin Sementara</span>
                                        @if(!$hasTemporaryPermitToday)
                                        <svg class="w-3.5 h-3.5 opacity-0 group-hover/link:opacity-100 transform -translate-x-2 group-hover/link:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                                        @endif
                                    </button>
                                    
                                    @if(!$todayAttendance)
                                    <button type="button" @click="$dispatch('open-full-day-permission-modal')" class="flex justify-between items-center text-sm font-medium text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 transition-colors group/link py-1">
                                        <span>Ajukan Izin Seharian</span>
                                        <svg class="w-3.5 h-3.5 opacity-0 group-hover/link:opacity-100 transform -translate-x-2 group-hover/link:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                    @endif
                                @endif
                            </div>

                        </div>
                    </div>
                    @endif

                    {{-- Premium Mentor Card --}}
                    @if($internship->mentor)
                        <div class="bg-white border text-center border-slate-200/60 dark:border-slate-800 dark:bg-slate-900 rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden group">
                            <div class="absolute top-0 right-0 p-4 text-slate-800 dark:text-slate-100 opacity-5 group-hover:opacity-10 transition-opacity">
                                <svg class="w-24 h-24 text-slate-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                            </div>

                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-rose-600 text-white rounded-[1.25rem] flex items-center justify-center text-3xl font-black shadow-[0_8px_20px_rgba(225,29,72,0.3)] mb-4 rotate-3 group-hover:rotate-0 transition-transform">
                                    {{ substr($internship->mentor->name, 0, 1) }}
                                </div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Mentor Pendamping</p>
                                <h4 class="font-black text-slate-800 dark:text-slate-200 text-xl tracking-tight leading-none mb-1">{{ $internship->mentor->name }}</h4>
                                <p class="text-sm font-medium text-slate-500 mb-6">{{ $internship->division->name ?? 'Digital Service Division' }}</p>
                                
                                <div class="flex justify-center gap-3 w-full">
                                    <a href="mailto:{{ $internship->mentor->email }}" class="flex-1 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 px-4 py-2.5 rounded-xl text-[11px] font-bold uppercase tracking-widest transition-colors flex items-center justify-center gap-2 border border-slate-200/60 dark:border-slate-700" title="Kirim Email">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        Email
                                    </a>
                                    
                                    @if($internship->mentor->mentorProfile && $internship->mentor->mentorProfile->phone_number)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $internship->mentor->mentorProfile->phone_number) }}" target="_blank" class="w-12 bg-slate-50 dark:bg-slate-800 hover:bg-emerald-50 hover:text-emerald-500 dark:hover:bg-emerald-500/10 dark:hover:text-emerald-400 hover:border-emerald-200 dark:hover:border-emerald-500/30 text-slate-400 rounded-xl flex items-center justify-center transition-colors border border-slate-200/60 dark:border-slate-700" title="Chat WhatsApp">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6zm-2 0l-8 5-8-5v12h16V6z" /></svg>
                                    </a>
                                    @endif

                                    @if($internship->mentor->mentorProfile && $internship->mentor->mentorProfile->telegram_username)
                                    <a href="https://t.me/{{ $internship->mentor->mentorProfile->telegram_username }}" target="_blank" class="w-12 bg-slate-50 dark:bg-slate-800 hover:bg-blue-50 hover:text-blue-500 dark:hover:bg-blue-500/10 dark:hover:text-blue-400 hover:border-blue-200 dark:hover:border-blue-500/30 text-slate-400 rounded-xl flex items-center justify-center transition-colors border border-slate-200/60 dark:border-slate-700" title="Chat Telegram">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.508-.163-.911-.247-.872-.516.02-.14.24-.28.665-.42 2.607-1.134 4.346-1.884 5.216-2.25 2.478-1.042 2.992-1.22 3.328-1.228z"/></svg>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                    </div>
                </div> {{-- End Right Column --}}

            </div> {{-- End Grid --}}
        </div> {{-- End Max Width Container --}}
    </div> {{-- End Padding Wrapper --}}


    {{-- MODALS --}}

    {{-- 1. Permission Modal --}}
    <x-permission-modal />

    {{-- 1b. Full Day Permission Modal --}}
    <x-full-day-permission-modal />

    {{-- 2. Final Report Modal --}}
    <div x-data="{ show: false }"
         @open-final-report-modal.window="show = true"
         x-show="show"
         style="display: none;"
         x-cloak
         class="fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="show = false"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 dark:border-slate-800">
                <form action="{{ route('documents.storeFinalReport') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf
                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-4">Upload Laporan Akhir</h3>
                    <div class="mb-8 relative" x-data="{ 
                        fileName: '', 
                        isDragging: false,
                        handleDrop(e) {
                            this.isDragging = false;
                            if (e.dataTransfer.files.length > 0) {
                                const file = e.dataTransfer.files[0];
                                if (file.type === 'application/pdf') {
                                    this.$refs.fileInput.files = e.dataTransfer.files;
                                    this.fileName = file.name;
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Format Tidak Sesuai',
                                        text: 'Harap unggah file dalam format PDF.',
                                    });
                                }
                            }
                        },
                        clearFile() {
                            this.fileName = '';
                            this.$refs.fileInput.value = '';
                        }
                    }">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-3 ml-1">File Laporan (PDF)</label>
                        <div 
                            @dragover.prevent="isDragging = true" 
                            @dragleave.prevent="isDragging = false" 
                            @drop.prevent="handleDrop($event)"
                            :class="{'border-purple-500 bg-purple-50/50 dark:bg-purple-500/10 scale-105': isDragging, 'border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/20': !isDragging}"
                            class="mt-1 flex justify-center px-6 pt-10 pb-10 border-2 border-dashed rounded-3xl group transition-all hover:bg-purple-50 dark:hover:bg-purple-500/5 hover:border-purple-400 relative cursor-pointer shadow-inner">
                            <input type="file" name="file" accept=".pdf" x-ref="fileInput" class="absolute inset-0 opacity-0 cursor-pointer z-10" required @change="fileName = $event.target.files[0].name" :class="{'hidden': fileName}">
                            <div class="text-center space-y-3 transition-transform group-hover:scale-105 duration-300">
                                <div class="inline-flex items-center justify-center w-14 h-14 bg-white dark:bg-slate-800 rounded-2xl text-slate-400 dark:text-slate-600 group-hover:text-purple-500 transition-all shadow-sm">
                                     <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                </div>
                                <div class="text-xs text-slate-600 dark:text-slate-400 relative z-20">
                                    <span x-show="!fileName" class="font-bold block text-slate-800 dark:text-slate-200">Klik atau seret file ke sini</span>
                                    
                                    {{-- Selected File State --}}
                                    <div x-show="fileName" style="display: none;" class="flex flex-col items-center gap-2">
                                        <div class="flex items-center gap-2 bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-300 px-3 py-1.5 rounded-lg border border-purple-200 dark:border-purple-500/30">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                            <span x-text="fileName" class="font-bold truncate max-w-[200px]"></span>
                                            <button type="button" @click.stop.prevent="clearFile()" class="p-1 hover:bg-purple-200 dark:hover:bg-purple-500/40 rounded-md transition-colors text-purple-600 hover:text-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <p class="mt-1 opacity-60 font-medium" x-show="!fileName">Format: PDF (Max. 10MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="show = false" class="py-2 px-4 border dark:border-slate-700 rounded-md text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors">Batal</button>
                        <button type="submit" class="py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white rounded-md shadow-lg shadow-purple-500/20 transition-all">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    {{-- Scripts --}}
    <script>
    function showDuplicatePermitError() {
        Swal.fire({
            icon: 'error',
            title: 'Satu Kali Sehari',
            text: 'Anda sudah mengajukan Izin Sementara hari ini. Batas pengajuan adalah 1 kali per hari.',
            buttonsStyling: false,
            customClass: {
                popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                title: 'text-slate-900 dark:text-slate-100 font-bold',
                htmlContainer: 'text-slate-600 dark:text-slate-400',
                confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
            }
        });
    }

    // 1. Fungsi Konfirmasi CHECK-IN

    function confirmCheckIn() {
        Swal.fire({
            title: 'Siap untuk Check-In?',
            text: "Pastikan kamu sudah berada di lokasi kantor!",
            icon: 'question',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonText: 'Ya, Check In!',
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
                Swal.fire({
                    title: 'Mengambil Lokasi...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    buttonsStyling: false,
                    customClass: {
                        popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                        title: 'text-slate-900 dark:text-slate-100 font-bold',
                        htmlContainer: 'text-slate-600 dark:text-slate-400',
                    }
                });
                getLocationAndSubmit();
            }
        });
    }

    // 2. Fungsi Ambil Lokasi & Submit Otomatis
    function getLocationAndSubmit() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('lat_in').value = position.coords.latitude;
                    document.getElementById('long_in').value = position.coords.longitude;
                    document.getElementById('checkInForm').submit();
                },
                function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengambil lokasi. Pastikan GPS aktif.',
                        buttonsStyling: false,
                        customClass: {
                            popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                            title: 'text-slate-900 dark:text-slate-100 font-bold',
                            htmlContainer: 'text-slate-600 dark:text-slate-400',
                            confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                        }
                    });
                }
            );
        } else { 
            Swal.fire({
                title: 'Error',
                text: 'Browser tidak mendukung Geolocation.',
                icon: 'error',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
            });
        }
    }

    // 3. Fungsi Konfirmasi CHECK-OUT
    function confirmCheckOut() {
        Swal.fire({
            title: 'Mau pulang sekarang?',
            text: 'Pastikan pekerjaan hari ini sudah selesai ya!',
            icon: 'warning',
            showCancelButton: true,
            reverseButtons: true,
            confirmButtonText: 'Ya, Check Out',
            cancelButtonText: 'Masih lembur',
            buttonsStyling: false,
            customClass: {
                popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                title: 'text-slate-900 dark:text-slate-100 font-bold',
                htmlContainer: 'text-slate-600 dark:text-slate-400',
                confirmButton: 'px-6 py-2.5 mx-2 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl transition-all active:scale-95',
                cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('checkOutForm').submit();
            }
        });
    }

    // GPS Helper for legacy/debugging
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const latEl = document.getElementById('lat_in');
                const longEl = document.getElementById('long_in');
                if (latEl && longEl) {
                    latEl.value = position.coords.latitude;
                    longEl.value = position.coords.longitude;
                }
            });
        }
    }
    // Call once on load
    getLocation(); 

    // Init Flatpickr for Permission Date
    document.addEventListener('turbo:load', function() {
        // Date Picker
        flatpickr("#permission_date", {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd F Y',
            locale: 'id',
            disableMobile: true,
            minDate: "today",
            onReady: function(selectedDates, dateStr, instance) {
                instance.calendarContainer.classList.add('theme-modern-glow');
            }
        });


        // Inline Range Calendar for Full Day Permission Modal
        const msPerDay = 1000 * 60 * 60 * 24;
        flatpickr("#inline_calendar", {
            mode: "range",
            inline: true,
            minDate: "today",
            locale: {
                firstDayOfWeek: 1, // Starts week on Monday
                weekdays: {
                    shorthand: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
                    longhand: ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"]
                }
            },
            dateFormat: "Y-m-d",
            showMonths: 1,
            onChange: function(selectedDates, dateStr, instance) {
                const startDateEl = document.getElementById('display_start_date');
                const endDateEl = document.getElementById('display_end_date');
                const durationEl = document.getElementById('display_duration');
                const hiddenRangeEl = document.getElementById('full_day_date_range');

                if (selectedDates.length === 0) {
                    startDateEl.innerText = "-";
                    endDateEl.innerText = "-";
                    durationEl.innerText = "0";
                    hiddenRangeEl.value = "";
                } else if (selectedDates.length === 1) {
                    const formatted = instance.formatDate(selectedDates[0], "d F Y");
                    startDateEl.innerText = formatted;
                    endDateEl.innerText = formatted; // end date is same day initially
                    durationEl.innerText = "1";
                    
                    // The hidden input should ideally have the range even if it's 1 day
                    hiddenRangeEl.value = instance.formatDate(selectedDates[0], "Y-m-d"); 
                } else if (selectedDates.length === 2) {
                    const d1 = selectedDates[0];
                    const d2 = selectedDates[1];
                    startDateEl.innerText = instance.formatDate(d1, "d F Y");
                    endDateEl.innerText = instance.formatDate(d2, "d F Y");
                    
                    // Inclusive duration calculation
                    const diffTime = Math.abs(d2 - d1);
                    const diffDays = Math.ceil(diffTime / msPerDay) + 1; 
                    durationEl.innerText = diffDays;
                    
                    hiddenRangeEl.value = dateStr; // e.g., "2026-02-16 to 2026-02-20"
                }
            },
            onReady: function(selectedDates, dateStr, instance) {
                instance.calendarContainer.classList.add('theme-modern-glow');
            }
        });
    });
    </script>
</x-app-layout>