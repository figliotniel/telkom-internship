<div x-data="{ show: false }"
     @open-permission-modal.window="show = true"
     x-show="show"
     style="display: none;"
     x-cloak
     class="fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Backdrop -->
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-slate-900/40 dark:bg-slate-950/80 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="show = false"></div>
        
        <!-- Modal Panel Option 2 style (Glassmorphism Clean) -->
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="relative bg-white/95 dark:bg-[#0f172a]/80 backdrop-blur-xl rounded-[24px] text-left overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.1)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] transform transition-all w-full max-w-xl border border-slate-200/60 dark:border-slate-700/50">
            
            <!-- Glow Effect (Light & Dark logic) -->
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3/4 h-24 bg-red-500/5 dark:bg-red-500/10 blur-[40px] rounded-full pointer-events-none"></div>

            <form action="{{ route('attendance.permission') }}" method="POST" enctype="multipart/form-data" class="relative z-10 flex flex-col h-full">
                @csrf
                <input type="hidden" name="permit_type" value="temporary">
                @php
                    $displayDate = \Carbon\Carbon::now()->hour < 7 ? \Carbon\Carbon::yesterday() : \Carbon\Carbon::today();
                @endphp
                <input type="hidden" name="date" value="{{ $displayDate->format('Y-m-d') }}">

                <!-- Header -->
                <div class="px-7 pt-7 pb-4 flex justify-between items-start relative z-10">
                    <div>
                        <h3 class="text-[1.35rem] leading-7 font-black text-slate-800 dark:text-white tracking-tight flex items-center gap-3">
                            Pengajuan Izin 
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 shadow-sm border border-slate-200/50 dark:border-slate-700">Sementara</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 font-medium">Sampaikan alasan ketidakhadiran Anda di jam kerja.</p>
                    </div>
                    <button type="button" @click="show = false" class="w-8 h-8 rounded-full bg-slate-100/80 dark:bg-slate-800/80 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-red-500 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-slate-700 transition-all border border-slate-200/50 dark:border-slate-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="px-7 pb-2 pt-2 flex flex-col gap-5 relative z-10">
                    
                    <!-- Date Row -->
                    <div class="flex items-center gap-4 bg-slate-50/60 dark:bg-slate-800/40 p-1.5 rounded-2xl border border-slate-200/60 dark:border-slate-700/50 shadow-sm">
                        <div class="w-12 h-12 rounded-xl bg-white dark:bg-slate-800/80 border border-slate-200/60 dark:border-slate-700/50 flex flex-col items-center justify-center flex-shrink-0 shadow-inner">
                            <span class="text-[9px] text-red-500 dark:text-red-400 font-bold uppercase">{{ $displayDate->translatedFormat('M') }}</span>
                            <span class="text-base text-slate-800 dark:text-white font-black leading-none mt-0.5">{{ $displayDate->format('d') }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Tanggal Izin</p>
                            <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 mt-0.5">{{ $displayDate->translatedFormat('l, d F Y') }}</p>
                        </div>
                        <div class="mr-3 text-slate-300 dark:text-slate-600 p-2 pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>

                    <!-- Rentang Waktu -->
                    <div class="bg-slate-50/60 dark:bg-slate-800/40 rounded-2xl p-4 border border-slate-200/60 dark:border-slate-700/50 shadow-sm transition-all focus-within:border-red-300 dark:focus-within:border-red-900/50 focus-within:shadow-[0_4px_20px_-5px_rgba(239,68,68,0.1)]">
                        <label class="block text-[10px] font-bold tracking-widest text-slate-500 dark:text-slate-400 uppercase mb-3">Waktu Izin Keluar</label>
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <div class="flex-1 w-full relative">
                                <label class="text-[9px] text-slate-400 dark:text-slate-500 font-bold block mb-1">DARI PUKUL</label>
                                <input type="time" name="start_time" required class="w-full bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/80 rounded-xl px-3 py-2.5 text-slate-800 dark:text-white font-bold focus:ring-1 focus:ring-red-500/50 outline-none shadow-sm dark:[color-scheme:dark]">
                            </div>
                            <div class="text-slate-300 dark:text-slate-600 shrink-0 mt-4 rotate-90 sm:rotate-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                            <div class="flex-1 w-full relative">
                                <label class="text-[9px] text-slate-400 dark:text-slate-500 font-bold block mb-1">SAMPAI PUKUL</label>
                                <input type="time" name="end_time" required class="w-full bg-white dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700/80 rounded-xl px-3 py-2.5 text-slate-800 dark:text-white font-bold focus:ring-1 focus:ring-red-500/50 outline-none shadow-sm dark:[color-scheme:dark]">
                            </div>
                        </div>
                    </div>

                    <!-- Alasan Izin -->
                    <div class="mb-2">
                        <textarea name="note" rows="3" placeholder="Tuliskan tujuan / alasan Anda..." required
                            class="block w-full px-4 py-3.5 bg-slate-50/60 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-700/50 rounded-2xl text-slate-800 dark:text-white text-sm focus:ring-1 focus:ring-red-500/50 focus:bg-white dark:focus:bg-slate-800/80 focus:border-red-300 dark:focus:border-red-500/30 outline-none transition-all resize-none shadow-sm placeholder-slate-400 dark:placeholder-slate-500"></textarea>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-7 py-5 mt-2 flex justify-between items-center relative z-10 bg-slate-50/50 dark:bg-slate-700/10 border-t border-slate-200/60 dark:border-slate-700/50">
                    <button type="button" @click="show = false" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-slate-800 transition-all">
                        Batalkan
                    </button>
                    <button type="submit" class="px-8 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-red-600 to-red-500 hover:from-red-500 hover:to-red-400 shadow-[0_5px_15px_rgba(239,68,68,0.25)] transition-all flex items-center gap-2 group">
                        Kirim Izin
                        <svg class="w-4 h-4 transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
