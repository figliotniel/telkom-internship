@props(['logbooks', 'todayLogbook'])

<div x-data="{ showEvidenceModal: false, evidenceUrl: '', isImage: false }" class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-3xl p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-colors duration-300">
    <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
        <div>
            <h3 class="text-xl font-black text-slate-800 dark:text-slate-100 tracking-tight">Timeline Logbook</h3>
            <p class="text-sm text-slate-400 font-medium">Rekam jejak aktivitas harian Anda</p>
        </div>
        
        <div class="flex gap-2">
            @if(Auth::user()->internship && Auth::user()->internship->status === 'finished')
                <a href="{{ route('logbooks.exportExcel') }}" class="bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 px-4 py-2 rounded-xl text-xs font-bold transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                    Rekap
                </a>
            @endif
            <a href="{{ route('logbooks.index') }}" class="bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 px-4 py-2 rounded-xl text-xs font-bold transition-colors">Lihat Semua</a>
        </div>
    </div>

    <!-- Rich Timeline Layout -->
    <div class="relative wrap overflow-hidden w-full">
        <div class="absolute border-opacity-20 border-slate-300 dark:border-slate-700 h-full border z-0" style="left: 31px"></div>
        
        @if(Auth::user()->internship && Auth::user()->internship->status === 'active' && !$todayLogbook)
        <!-- Logbook Hari Ini (Draft) -->
        <div class="mb-8 flex items-start gap-4 md:gap-6 relative w-full">
            <div class="w-16 h-16 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex flex-col items-center justify-center flex-shrink-0 z-10 text-slate-500 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 w-full h-1 bg-amber-400"></div>
                <span class="text-[10px] font-bold uppercase tracking-widest leading-none mb-1">Hari Ini</span>
                <span class="text-xl font-black leading-none text-slate-800 dark:text-slate-100">{{ \Carbon\Carbon::today()->format('d') }}</span>
            </div>
            <div class="flex-1 min-w-0 bg-amber-50/50 dark:bg-amber-500/5 border border-amber-100/50 dark:border-amber-500/10 rounded-2xl p-4 md:p-5 hover:shadow-md transition-shadow relative z-10">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-1 bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 text-[9px] font-extrabold uppercase tracking-widest rounded-lg">Draft</span>
                    </div>
                </div>
                <h4 class="font-bold text-slate-400 dark:text-slate-500 italic text-base mb-1">Belum diisi...</h4>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 line-clamp-2 font-medium">Bagikan apa yang Anda kerjakan hari ini agar dapat divalidasi oleh mentor pembimbing Anda.</p>
                <a href="{{ route('logbooks.create') }}" class="inline-flex px-6 py-2.5 bg-slate-800 dark:bg-slate-100 hover:bg-slate-900 dark:hover:bg-white text-white dark:text-slate-900 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-[0_4px_14px_0_rgba(0,0,0,0.15)] active:scale-95 items-center justify-center gap-2 w-full sm:w-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Tulis Logbook
                </a>
            </div>
        </div>
        @endif

        <!-- List Logbook Loop -->
        @forelse($logbooks as $logbook)
            @php
                $colorClass = match($logbook->status) {
                    'pending' => 'bg-blue-400',
                    'approved' => 'bg-emerald-400',
                    'rejected' => 'bg-red-400',
                    default => 'bg-slate-300',
                };
                
                $badgeHTML = match($logbook->status) {
                    'pending' => '<span class="px-2.5 py-1 bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20 text-blue-600 dark:text-blue-400 text-[9px] font-extrabold uppercase tracking-widest rounded-lg flex items-center gap-1"><svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Menunggu Validasi</span>',
                    'approved' => '<span class="px-2.5 py-1 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-[9px] font-extrabold uppercase tracking-widest rounded-lg flex items-center gap-1"><svg class="w-2.5 h-2.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg> Approved</span>',
                    'rejected' => '<span class="px-2.5 py-1 bg-red-50 dark:bg-red-500/10 border border-red-100 dark:border-red-500/20 text-red-600 dark:text-red-400 text-[9px] font-extrabold uppercase tracking-widest rounded-lg flex items-center gap-1"><svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg> Revisi Needed</span>',
                    default => '<span class="px-2.5 py-1 bg-slate-50 border border-slate-100 text-slate-500 text-[9px] font-extrabold uppercase tracking-widest rounded-lg">Draft</span>',
                };
            @endphp
            <div class="mb-8 flex items-start gap-4 md:gap-6 relative w-full">
                <div class="w-16 h-16 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex flex-col items-center justify-center flex-shrink-0 z-10 text-slate-500 dark:text-slate-400 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 w-full h-1 {{ $colorClass }}"></div>
                    <span class="text-[10px] font-bold uppercase tracking-widest leading-none mb-1">{{ \Carbon\Carbon::parse($logbook->date)->translatedFormat('D') }}</span>
                    <span class="text-xl font-black leading-none text-slate-800 dark:text-slate-100">{{ \Carbon\Carbon::parse($logbook->date)->format('d') }}</span>
                </div>
                <div class="flex-1 min-w-0 bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-2xl p-4 md:p-5 hover:shadow-md hover:border-slate-300 dark:hover:border-slate-700 transition-all cursor-pointer group relative z-10" onclick="window.location='{{ route('logbooks.index') }}'">
                    <div class="flex items-center gap-2 mb-3 flex-wrap">
                        {!! $badgeHTML !!}
                    </div>
                    <h4 class="font-bold text-slate-800 dark:text-slate-200 text-[15px] sm:text-lg leading-tight mb-1 group-hover:text-red-500 transition-colors w-full break-words truncate" title="{{ strip_tags($logbook->activity) }}">{{ strip_tags($logbook->activity) }}</h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-2 md:line-clamp-3 leading-relaxed w-full">{{ strip_tags($logbook->description ?? 'Tidak ada deskripsi rinci.') }}</p>
                    
                    <!-- Attachments -->
                    @if($logbook->evidence)
                        @php
                            $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $logbook->evidence);
                        @endphp
                        <div class="flex gap-2 mt-3 p-3 bg-slate-50 dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 w-full sm:w-auto sm:inline-flex">
                            <button @click.stop="showEvidenceModal = true; evidenceUrl = '{{ Storage::url($logbook->evidence) }}'; isImage = {{ $isImage ? 'true' : 'false' }}" class="flex items-center gap-2 text-xs font-bold text-red-500 dark:text-red-400 hover:text-red-600 dark:hover:text-red-300 transition-colors w-full justify-center sm:justify-start">
                                <div class="w-8 h-8 rounded-lg bg-red-50 dark:bg-red-500/10 flex items-center justify-center border border-red-100 dark:border-red-500/20">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </div>
                                <span class="uppercase tracking-widest hidden sm:inline-block">Lihat Lampiran</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            @if(Auth::user()->internship && Auth::user()->internship->status === 'finished')
                <div class="px-6 py-8 text-center text-gray-500 dark:text-slate-400 relative z-10 w-full">
                    Belum ada logbook yang diisi.
                </div>
            @endif
        @endforelse
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
                class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-left shadow-xl transition-all sm:my-8 w-full max-w-4xl border border-slate-200 dark:border-slate-800">
                
                <!-- Header -->
                <div class="bg-white dark:bg-slate-900 px-4 pt-5 sm:p-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex justify-between items-center w-full">
                        <h3 class="text-lg font-bold leading-6 text-slate-900 dark:text-slate-100" id="modal-title">Bukti Logbook</h3>
                        <button @click="showEvidenceModal = false" type="button" class="text-slate-400 hover:text-red-500 focus:outline-none transition-colors">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
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
