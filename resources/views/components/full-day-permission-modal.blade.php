<div x-data="{ show: false }"
     @open-full-day-permission-modal.window="show = true"
     x-show="show"
     style="display: none;"
     x-cloak
     class="fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        
        <!-- Backdrop -->
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-slate-900/40 dark:bg-slate-950/80 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="show = false"></div>
        
        <!-- Modal Panel Option 2 Style -->
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="relative w-full max-w-4xl">
            
            <!-- Background Glow Effect  -->
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-4/5 h-32 bg-red-500/10 blur-[60px] rounded-full pointer-events-none z-0"></div>

            <div class="relative z-10 bg-white/95 dark:bg-[#0f172a]/90 backdrop-blur-2xl rounded-[32px] overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.1)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white dark:border-slate-700/50 flex flex-col md:flex-row">
                
                <form action="{{ route('attendance.permission') }}" method="POST" enctype="multipart/form-data" id="fullDayPermissionForm" class="flex flex-col md:flex-row w-full h-full m-0">
                    @csrf
                    <input type="hidden" name="permit_type" value="full">
                    <input type="hidden" name="date" id="full_day_date_range" required>

                    <!-- Left: Calendar Section -->
                    <div class="w-full md:w-[420px] bg-slate-50/50 dark:bg-slate-900/50 p-6 md:p-8 border-b md:border-b-0 md:border-r border-slate-200/50 dark:border-slate-800/80 flex flex-col items-center justify-center">
                        <div class="w-full h-auto min-h-[360px] relative rounded-2xl bg-white dark:bg-slate-800 border border-slate-200/50 dark:border-slate-700/50 shadow-sm flex flex-col items-center justify-center group overflow-hidden p-2">
                             <!-- This is where flatpickr attaches via ID -->
                             <input type="text" id="inline_calendar" class="hidden">
                        </div>
                    </div>

                    <!-- Right: Form Section -->
                    <div class="flex-1 p-6 md:p-10 flex flex-col justify-between">
                        <div>
                            <!-- Header -->
                            <div class="mb-8 relative flex justify-between items-start">
                                <div>
                                    <span class="px-3 py-1 bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 text-[10px] font-bold uppercase tracking-widest rounded-md border border-red-200/50 dark:border-red-500/20 mb-3 inline-block shadow-sm">Full Day Leave</span>
                                    <h3 class="text-2xl md:text-[2rem] leading-tight font-black text-slate-800 dark:text-white tracking-tight">Pengajuan Izin <br>Ketidakhadiran</h3>
                                </div>
                                <button type="button" @click="show = false" class="w-9 h-9 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-red-500 transition-colors border border-slate-200 dark:border-slate-700">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Date Mirrors -->
                            <div class="flex flex-col xl:flex-row gap-4 mb-6">
                                <div class="flex-1 bg-white/50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-700/50 relative overflow-hidden group">
                                    <div class="absolute right-0 bottom-0 text-red-500/10 dark:text-red-500/5 transform translate-y-1/4 translate-x-1/4">
                                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest block mb-1">Mulai</span>
                                    <span id="display_start_date" class="font-bold text-slate-800 dark:text-white text-lg xl:text-base relative z-10">-</span>
                                </div>
                                <div class="flex-1 bg-white/50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-700/50 relative overflow-hidden">
                                    <div class="absolute right-0 bottom-0 text-red-500/10 dark:text-red-500/5 transform translate-y-1/4 translate-x-1/4">
                                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest block mb-1">Berakhir</span>
                                    <span id="display_end_date" class="font-bold text-slate-800 dark:text-white text-lg xl:text-base relative z-10">-</span>
                                </div>
                            </div>

                            <!-- Reason -->
                            <div class="mb-6 flex flex-col">
                                <label class="text-[10px] text-slate-500 font-bold uppercase tracking-widest block mb-2 ml-1">Penjelasan Alasan</label>
                                <textarea id="note_full" name="note" rows="3" required class="w-full bg-slate-50/60 dark:bg-[#0f172a]/50 border border-slate-200/60 dark:border-slate-700/50 rounded-2xl px-5 py-4 text-sm focus:ring-1 focus:ring-red-500/50 focus:border-red-400 outline-none resize-none shadow-sm text-slate-800 dark:text-white backdrop-blur-sm transition-all focus:bg-white dark:focus:bg-slate-800" placeholder="Tuliskan tujuan / alasan ketidakhadiran Anda..."></textarea>
                            </div>
                        </div>

                        <!-- Action Bar -->
                        <div class="flex justify-between items-center sm:flex-row flex-col gap-4 sm:gap-0 mt-auto pt-2">
                            <div class="flex items-center gap-3 bg-red-50/50 dark:bg-slate-800/50 px-4 py-2.5 rounded-xl border border-red-100 dark:border-slate-700/50 w-full sm:w-auto justify-center">
                                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Durasi</span>
                                <div class="flex items-center justify-center bg-white dark:bg-slate-900 border border-red-200 dark:border-slate-700 rounded-lg px-3 py-1 shadow-sm">
                                    <span class="text-red-500 dark:text-red-400 font-black text-sm"><span id="display_duration">0</span> Hari</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-white bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-400 shadow-[0_5px_15px_rgba(239,68,68,0.3)] transition-all flex items-center justify-center gap-2 group transform active:scale-95">
                                Kirim Pengajuan
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
