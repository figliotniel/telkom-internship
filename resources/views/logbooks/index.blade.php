<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-100 leading-tight">
            {{ __('Activity Log') }}
        </h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Riwayat lengkap aktivitas magang kamu</p>
    </x-slot>

    <div class="py-12" x-data="{ activeTab: 'logbook', showModal: false, modalContent: '', modalDate: '', modalTitle: '', showEvidenceModal: false, evidenceUrl: '', isImage: false }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Tabs Navigation --}}
            <div class="border-b border-slate-200 dark:border-slate-800 mb-6">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="activeTab = 'logbook'" 
                        :class="{ 'border-red-500 text-red-600 dark:text-red-400': activeTab === 'logbook', 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:border-slate-300 dark:hover:border-slate-700': activeTab !== 'logbook' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Logbook Aktivitas
                    </button>
                    <button @click="activeTab = 'permission'" 
                        :class="{ 'border-red-500 text-red-600 dark:text-red-400': activeTab === 'permission', 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:border-slate-300 dark:hover:border-slate-700': activeTab !== 'permission' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Riwayat Izin
                    </button>
                    <button @click="activeTab = 'attendance'" 
                        :class="{ 'border-red-500 text-red-600 dark:text-red-400': activeTab === 'attendance', 'border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:border-slate-300 dark:hover:border-slate-700': activeTab !== 'attendance' }"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        Riwayat Absensi
                    </button>
                </nav>
            </div>

            {{-- Logbook Section --}}
            <div x-show="activeTab === 'logbook'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                            <div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Semua Aktivitas</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Pantau terus perkembangan magangmu</p>
                            </div>
                            @if(Auth::user()->internship && Auth::user()->internship->status === 'active')
                                <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                    <a href="{{ route('logbooks.exportPdf') }}" class="inline-flex items-center gap-2 bg-slate-800 dark:bg-slate-700 text-white px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold hover:bg-slate-900 dark:hover:bg-slate-600 transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                        <span class="hidden xs:inline">Unduh</span> PDF
                                    </a>
                                    <a href="{{ route('logbooks.exportExcel') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold hover:bg-emerald-700 transition-all shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125h-7.5a1.125 1.125 0 0 1-1.125-1.125m0 0h7.5m-7.5 0V5.625m0 12.75v1.5c0 .621-.504 1.125-1.125 1.125M9 5.625v9.75m6-9.75v9.75M3.375 5.625h17.25c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125H3.375a1.125 1.125 0 0 1-1.125-1.125V6.75c0-.621.504-1.125 1.125-1.125Z" />
                                        </svg>
                                        <span class="hidden xs:inline">Unduh</span> Excel
                                    </a>
                                    <a href="{{ route('logbooks.create') }}" class="bg-gradient-to-r from-red-600 to-red-500 text-white px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold hover:shadow-lg hover:shadow-red-500/30 transition-all">
                                        + Isi Logbook
                                    </a>
                                </div>
                            @endif
                        </div>
    
                        <div class="space-y-4 max-w-4xl mt-4">
                            @forelse($logbooks as $logbook)
                            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[1.25rem] p-5 sm:p-6 transition-all shadow-sm hover:shadow-md hover:border-red-300 dark:hover:border-red-500/50 hover:-translate-y-1">
                                <div class="flex flex-col md:flex-row md:items-start gap-5 sm:gap-6">
                                    <!-- Date Block -->
                                    <div class="shrink-0 md:w-32 border-l-4 border-red-500 pl-4 mt-1">
                                        <span class="block text-sm font-black text-slate-800 dark:text-slate-100">{{ \Carbon\Carbon::parse($logbook->date)->translatedFormat('d M Y') }}</span>
                                        <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">{{ \Carbon\Carbon::parse($logbook->date)->translatedFormat('l') }}</span>
                                    </div>
                                    
                                    <!-- Info Block -->
                                    <div class="grow flex flex-col gap-2 border-t md:border-t-0 md:border-l border-slate-100 dark:border-slate-800 pt-4 md:pt-0 md:pl-6">
                                        <div class="flex items-center gap-3">
                                            @if(\Carbon\Carbon::parse($logbook->date)->isToday())
                                                <span class="bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-500 px-2.5 py-1 rounded-md text-[9px] font-black uppercase tracking-widest border border-red-200/50 dark:border-red-500/20 shadow-sm">Hari ini</span>
                                            @endif
                                            <x-status-badge :status="$logbook->status" />
                                        </div>
                                        <h4 class="text-lg font-bold text-slate-800 dark:text-white mt-1">{{ $logbook->title ?? '-' }}</h4>
                                        <div class="text-sm text-slate-600 dark:text-slate-400 mt-1 leading-relaxed line-clamp-2" title="{{ strip_tags($logbook->activity) }}">
                                            {{ Str::limit(strip_tags($logbook->activity), 180) }}
                                        </div>
                                    </div>
                                    
                                    <!-- Action Block -->
                                    <div class="shrink-0 flex items-center md:flex-col md:items-end justify-between md:justify-start gap-3 border-t md:border-t-0 border-slate-100 dark:border-slate-800 pt-4 md:pt-0 w-full md:w-auto mt-2 md:mt-0">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 hidden md:block">Aksi</span>
                                        <div class="flex flex-wrap md:flex-col items-center md:items-end gap-2 w-full md:w-auto">
                                            <button 
                                                @click="showModal = true; modalContent = {{ json_encode($logbook->activity) }}; modalDate = '{{ \Carbon\Carbon::parse($logbook->date)->format('d M Y') }}'; modalTitle = '{{ addslashes($logbook->title) }}'"
                                                class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-[10px] font-bold inline-flex justify-center items-center gap-1.5 transition-colors bg-red-50 dark:bg-red-500/10 px-3 py-1.5 rounded-lg border border-red-100 dark:border-red-500/20 shadow-sm md:w-auto w-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>
                                                Baca Penuh
                                            </button>
                                            @if($logbook->evidence)
                                                @php
                                                    $ext = strtolower(pathinfo($logbook->evidence, PATHINFO_EXTENSION));
                                                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                @endphp
                                                <button type="button" @click="showEvidenceModal = true; evidenceUrl = '{{ Storage::url($logbook->evidence) }}'; isImage = {{ $isImage ? 'true' : 'false' }}" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 text-[10px] font-bold inline-flex justify-center items-center gap-1.5 transition-colors bg-slate-50 dark:bg-slate-800/50 px-3 py-1.5 border border-slate-200 dark:border-slate-700 shadow-sm rounded-lg md:w-auto w-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32m.009-.01l-.01.01m5.699-9.941l-7.81 7.81a1.5 1.5 0 002.112 2.13" /></svg>
                                                    Lihat Bukti
                                                </button>
                                            @endif
                                            @if(in_array($logbook->status, ['pending', 'rejected']))
                                                <a href="{{ route('logbooks.edit', $logbook->id) }}" class="text-amber-600 dark:text-amber-500 hover:text-amber-700 dark:hover:text-amber-400 text-[10px] font-bold inline-flex justify-center items-center gap-1.5 transition-colors bg-amber-50 dark:bg-amber-500/10 px-3 py-1.5 border border-amber-100 dark:border-amber-500/20 shadow-sm rounded-lg md:w-auto w-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" /></svg>
                                                    Edit
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 w-full mt-2 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-3xl">
                                    <div class="flex flex-col items-center justify-center h-full gap-2">
                                        <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                            </svg>
                                        </div>
                                        <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">Belum ada aktivitas yang dicatat.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
    
                        <div class="mt-4">
                            {{ $logbooks->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Riwayat Izin Section --}}
            <div x-show="activeTab === 'permission'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors">
                    <div class="p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Riwayat Pengajuan Izin</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar izin yang telah Anda ajukan</p>
                        </div>
    
                        <div class="space-y-4 max-w-4xl mt-4">
                            @forelse($permissions as $permit)
                            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[1.25rem] p-5 sm:p-6 transition-all shadow-sm hover:shadow-md hover:border-amber-300 dark:hover:border-amber-500/50 hover:-translate-y-1">
                                <div class="flex flex-col md:flex-row md:items-center gap-5 sm:gap-6">
                                    <!-- Date Block -->
                                    <div class="shrink-0 md:w-32 border-l-4 border-amber-500 pl-4 mt-1">
                                        <span class="block text-sm font-black text-slate-800 dark:text-slate-100">{{ \Carbon\Carbon::parse($permit->date)->translatedFormat('d M Y') }}</span>
                                        <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">{{ \Carbon\Carbon::parse($permit->date)->translatedFormat('l') }}</span>
                                    </div>
                                    
                                    <!-- Info Block -->
                                    <div class="grow flex flex-col gap-2 border-t md:border-t-0 md:border-l border-slate-100 dark:border-slate-800 pt-4 md:pt-0 md:pl-6">
                                        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                            <span class="inline-flex items-center w-max px-2.5 py-1 rounded-md bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500 font-black text-[9px] uppercase tracking-widest border border-amber-100 dark:border-amber-500/20 shadow-sm">
                                                {{ match($permit->permit_type) {
                                                    'full' => 'Penuh (Seharian)',
                                                    'half' => 'Setengah Hari',
                                                    'temporary' => 'Sementara',
                                                    default => ucfirst($permit->permit_type ?? 'Izin')
                                                } }}
                                            </span>
                                            @if(in_array($permit->permit_type, ['half', 'temporary']))
                                                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 flex items-center gap-1.5 bg-slate-100 dark:bg-slate-800/50 px-2.5 py-1 rounded-md mb-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    {{ $permit->permit_start_time ? \Carbon\Carbon::parse($permit->permit_start_time)->format('H:i') : '-' }} - 
                                                    {{ $permit->permit_end_time ? \Carbon\Carbon::parse($permit->permit_end_time)->format('H:i') : '-' }}
                                                </span>
                                            @else
                                                <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 flex items-center gap-1.5 bg-slate-100 dark:bg-slate-800/50 px-2.5 py-1 rounded-md uppercase tracking-widest mb-0">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    Seharian Penuh
                                                </span>
                                            @endif
                                        </div>
                                        <h4 class="text-base text-slate-600 dark:text-slate-400 mt-1 leading-relaxed max-w-none">{{ $permit->note ?? '-' }}</h4>
                                    </div>
                                    
                                    <!-- Status Block -->
                                    <div class="shrink-0 flex items-center md:flex-col md:items-end justify-between border-t md:border-t-0 border-slate-100 dark:border-slate-800 pt-4 md:pt-0 mt-2 md:mt-0">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 hidden md:block">Status Kehadiran</span>
                                        <span class="inline-flex w-full md:w-auto items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-black text-[10px] uppercase tracking-widest border border-indigo-100 dark:border-indigo-500/20 shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            Absen Terotorisasi
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 w-full mt-2 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-3xl">
                                    <div class="flex flex-col items-center justify-center h-full gap-2">
                                        <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">Belum ada riwayat izin yang dicatat.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            {{-- Riwayat Absensi Section --}}
            <div x-show="activeTab === 'attendance'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100 dark:border-slate-800 transition-colors">
                    <div class="p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Riwayat Absensi</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Catatan kehadiran check-in dan check-out</p>
                        </div>
    
                        <div class="space-y-4 max-w-4xl mt-4">
                            @forelse($attendances as $attendance)
                            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[1.25rem] p-5 sm:p-6 transition-all shadow-sm hover:shadow-md hover:border-emerald-300 dark:hover:border-emerald-500/50 hover:-translate-y-1">
                                <div class="flex flex-col md:flex-row md:items-start gap-5 sm:gap-6">
                                    <!-- Date Block -->
                                    <div class="shrink-0 md:w-32 border-l-4 {{ $attendance->status === 'late' ? 'border-orange-500' : 'border-emerald-500' }} pl-4 mt-1">
                                        <span class="block text-sm font-black text-slate-800 dark:text-slate-100">{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('d M Y') }}</span>
                                        <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mt-1">{{ \Carbon\Carbon::parse($attendance->date)->translatedFormat('l') }}</span>
                                    </div>
                                    
                                    <!-- Info Block -->
                                    <div class="grow flex flex-col gap-3 border-t md:border-t-0 md:border-l border-slate-100 dark:border-slate-800 pt-4 md:pt-0 md:pl-6 w-full">
                                        <div class="flex flex-wrap items-center justify-between gap-3">
                                            @if($attendance->status === 'late')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-500 font-black text-[9px] uppercase tracking-widest border border-orange-100 dark:border-orange-500/20 shadow-sm">
                                                    Telat
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-500 font-black text-[9px] uppercase tracking-widest border border-emerald-100 dark:border-emerald-500/20 shadow-sm">
                                                    Hadir
                                                </span>
                                            @endif
                                            @if($attendance->check_in_time && $attendance->check_out_time)
                                                @php
                                                    $start = \Carbon\Carbon::parse($attendance->check_in_time);
                                                    $end = \Carbon\Carbon::parse($attendance->check_out_time);
                                                    $diff = $start->diff($end);
                                                @endphp
                                                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider block">{{ $diff->h }} Jam {{ $diff->i }} Menit</span>
                                            @endif
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 text-sm mt-1 border border-slate-100 dark:border-slate-800 rounded-xl p-3 sm:p-4 bg-slate-50/50 dark:bg-slate-900/50">
                                            <div class="flex flex-col pl-3 border-l-2 border-emerald-500">
                                                <span class="text-[10px] font-black text-emerald-600 dark:text-emerald-500 uppercase tracking-widest">Waktu Masuk</span>
                                                <span class="text-lg font-bold text-slate-800 dark:text-slate-200 font-mono leading-none mt-1.5">{{ $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') : '--:--' }}</span>
                                            </div>
                                            <div class="flex flex-col pl-3 border-l-2 border-rose-500">
                                                <span class="text-[10px] font-black text-rose-600 dark:text-rose-500 uppercase tracking-widest">Waktu Pulang</span>
                                                <span class="text-lg font-bold text-slate-800 dark:text-slate-200 font-mono leading-none mt-1.5">{{ $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i') : '--:--' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Status Block -->
                                    <div class="shrink-0 flex items-center md:flex-col md:items-end justify-between border-t md:border-t-0 border-slate-100 dark:border-slate-800 pt-4 md:pt-0 h-full w-full md:w-auto mt-2 md:mt-0">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 hidden md:block">Lokasi & GPS</span>
                                        @if($attendance->check_in_lat && $attendance->check_in_long)
                                            <a href="https://www.google.com/maps?q={{ $attendance->check_in_lat }},{{ $attendance->check_in_long }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 font-black text-[9px] uppercase tracking-widest border border-blue-100 dark:border-blue-500/20 hover:bg-blue-100 dark:hover:bg-blue-500/20 transition-colors w-full md:w-auto md:mt-2 shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-3.5 h-3.5">
                                                    <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.62.829.799 1.654 1.38 2.274 1.766a11.267 11.267 0 00.758.433l.017.007.006.003.002.001.309.066zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                                </svg>
                                                Peta Lokasi
                                            </a>
                                        @else
                                            <span class="inline-flex flex-1 justify-center text-[9px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 dark:bg-slate-800/50 px-3 py-1.5 rounded-lg border border-slate-100 dark:border-slate-800 w-full md:w-auto">Tidak ada info GPS</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @empty
                                <div class="px-6 py-12 text-center text-gray-500 dark:text-slate-400 w-full mt-2 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-3xl">
                                    <div class="flex flex-col items-center justify-center h-full gap-2">
                                        <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800/50 rounded-[2rem] flex items-center justify-center mb-2 transition-colors shadow-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-slate-300 dark:text-slate-600 transition-colors">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-base font-bold text-slate-500 dark:text-slate-500 transition-colors">Belum ada riwayat absensi yang dicatat.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Activity Detail Modal -->
            <div x-show="showModal" 
                class="fixed inset-0 z-[1000] overflow-y-auto" 
                aria-labelledby="modal-title" 
                role="dialog" 
                aria-modal="true"
                style="display: none;">
                
                <!-- Backdrop -->
                <div x-show="showModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" 
                    @click="showModal = false"></div>

                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="showModal"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl w-full border border-slate-200 dark:border-slate-800">
                        
                        <!-- Header -->
                        <div class="bg-white dark:bg-slate-900 px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-slate-100 dark:border-slate-800">
                            <div class="sm:flex sm:items-start justify-between">
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="text-lg font-bold leading-6 text-slate-900 dark:text-slate-100" id="modal-title" x-text="modalTitle || 'Detail Aktivitas'">
                                                Detail Aktivitas
                                            </h3>
                                            <div class="mt-1 text-sm text-slate-500 dark:text-slate-400" x-text="modalDate"></div>
                                        </div>
                                        <button @click="showModal = false" type="button" class="text-slate-400 hover:text-red-500 focus:outline-none transition-colors">
                                            <span class="sr-only">Close</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="bg-white dark:bg-slate-900 px-4 py-6 sm:p-6 max-h-[60vh] overflow-y-auto">
                            <div class="prose prose-sm dark:prose-invert max-w-none text-slate-700 dark:text-slate-300" x-html="modalContent"></div>
                        </div>
                        
                        <!-- Footer -->
                        <div class="bg-slate-50 dark:bg-slate-800/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100 dark:border-slate-800">
                            <button type="button" 
                                class="inline-flex w-full justify-center rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-5 py-2.5 text-sm font-bold shadow-sm hover:bg-slate-800 dark:hover:bg-slate-100 sm:ml-3 sm:w-auto transition-all"
                                @click="showModal = false">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evidence Detail Modal -->
            <div x-show="showEvidenceModal" 
                class="fixed inset-0 z-[1000] overflow-y-auto" 
                aria-labelledby="modal-title" 
                role="dialog" 
                aria-modal="true"
                style="display: none;">
                
                <!-- Backdrop -->
                <div x-show="showEvidenceModal"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" 
                    @click="showEvidenceModal = false"></div>

                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="showEvidenceModal"
                        x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl w-full border border-slate-200 dark:border-slate-800">
                        
                        <!-- Header -->
                        <div class="bg-white dark:bg-slate-900 px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-slate-100 dark:border-slate-800">
                            <div class="sm:flex sm:items-start justify-between">
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="text-lg font-bold leading-6 text-slate-900 dark:text-slate-100" id="modal-title">
                                                Bukti Logbook
                                            </h3>
                                        </div>
                                        <button @click="showEvidenceModal = false" type="button" class="text-slate-400 hover:text-red-500 focus:outline-none transition-colors">
                                            <span class="sr-only">Close</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="bg-slate-50 dark:bg-slate-950 p-4 flex justify-center items-center overflow-hidden min-h-[50vh] max-h-[85vh]">
                            <template x-if="evidenceUrl">
                                <div class="w-full h-full flex justify-center items-center">
                                    <template x-if="isImage">
                                        <img :src="evidenceUrl" alt="Bukti Logbook" class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-sm border border-slate-200 dark:border-slate-800">
                                    </template>
                                    <template x-if="!isImage">
                                        <iframe :src="evidenceUrl" class="w-full h-[75vh] border-0 rounded-lg shadow-sm" title="Bukti Attachment"></iframe>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</x-app-layout>
