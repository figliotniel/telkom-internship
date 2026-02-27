<div id="permissionModal" class="hidden fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-slate-900/75 dark:bg-slate-950/80 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeModal('permissionModal')"></div>
        
        <div class="relative bg-white dark:bg-slate-900 rounded-[2.5rem] text-left overflow-hidden shadow-2xl dark:shadow-slate-950 transform transition-all w-full max-w-lg border border-slate-100 dark:border-slate-800">
            
            {{-- Modal Header --}}
            <div class="bg-white dark:bg-slate-900 px-8 py-6 flex justify-between items-center border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-xl leading-6 font-black text-slate-800 dark:text-slate-100 tracking-tight">Pengajuan Izin</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-500 font-medium mt-1">Sampaikan alasan ketidakhadiran Anda</p>
                </div>
                <button type="button" onclick="closeModal('permissionModal')" class="text-slate-400 hover:text-red-500 transition-all bg-slate-50 dark:bg-slate-800 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-2xl p-2 border border-slate-200 dark:border-slate-700 hover:border-red-100 dark:hover:border-red-900 shadow-sm active:scale-90">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('attendance.permission') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-5 px-6 pb-6 pt-2">
                    {{-- 1. Date Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Tanggal Pengajuan</label>
                        
                        @php
                            $displayDate = \Carbon\Carbon::now()->hour < 7 ? \Carbon\Carbon::yesterday() : \Carbon\Carbon::today();
                        @endphp

                        {{-- Badge Display --}}
                        <div id="date_badge_container" class="hidden flex items-center justify-center gap-3">
                            <div class="bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 px-5 py-3 rounded-2xl font-black text-2xl border border-red-100 dark:border-red-900/50 shadow-sm ring-1 ring-red-500/10">
                                {{ $displayDate->format('d') }}
                            </div>
                            <div class="bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 px-5 py-3 rounded-2xl font-black text-2xl border border-red-100 dark:border-red-900/50 shadow-sm ring-1 ring-red-500/10">
                                {{ $displayDate->translatedFormat('F') }}
                            </div>
                            <div class="bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 px-5 py-3 rounded-2xl font-black text-2xl border border-red-100 dark:border-red-900/50 shadow-sm ring-1 ring-red-500/10">
                                {{ $displayDate->format('Y') }}
                            </div>
                        </div>

                        <input type="hidden" name="date" value="{{ $displayDate->format('Y-m-d') }}" id="hidden_date_input">

                        {{-- Date Input --}}
                        <div id="date_input_container" class="relative group w-full">
                            <input type="text" name="date" id="permission_date"
                                class="block w-full rounded-xl border-slate-200 dark:border-slate-700 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm bg-white dark:bg-slate-800 py-3 pl-10 transition-all text-left font-semibold text-slate-700 dark:text-slate-200" 
                                placeholder="Pilih tanggal..." required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500 group-focus-within:text-red-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                    <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                                    <path fill-rule="evenodd" d="M6.75 2.25a.75.75 0 01.75.75v.75h9v-.75a.75.75 0 011.5 0v.75h1.5a3 3 0 013 3v15a3 3 0 01-3 3h-15a3 3 0 01-3-3v-15a3 3 0 013-3h1.5v-.75a.75.75 0 01.75-.75zM3.75 6.75a1.5 1.5 0 00-1.5 1.5v12a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-12a1.5 1.5 0 00-1.5-1.5h-15z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                <div class="space-y-6 px-8 pb-8 pt-4">
                    {{-- 2. Permit Type --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-3 ml-1">Pilih Jenis Izin</label>
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Temporary Permit Card -->
                            <label class="cursor-pointer relative group">
                                <input type="radio" name="permit_type" value="temporary" class="peer sr-only" onchange="toggleAttachment()" checked>
                                <div class="p-5 rounded-2xl border-2 border-slate-100 dark:border-slate-800 hover:border-red-100 dark:hover:border-red-900/30 bg-white dark:bg-slate-900 transition-all duration-300 peer-checked:border-red-500 dark:peer-checked:border-red-500 peer-checked:bg-red-50/50 dark:peer-checked:bg-red-500/5 shadow-sm peer-checked:shadow-red-500/10 peer-checked:ring-1 peer-checked:ring-red-500/20">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 peer-checked:bg-red-600 dark:peer-checked:bg-red-600 peer-checked:text-white transition-all shadow-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-black text-slate-800 dark:text-slate-200 peer-checked:text-red-700 dark:peer-checked:text-red-400 transition-colors tracking-tight">Izin Keluar / Setengah Hari</p>
                                            <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-tight">Sementara</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- 3. Time Inputs (Conditional) --}}
                    <div id="time_div" class="hidden space-y-4">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 ml-1">Durasi Waktu</label>
                            <div class="flex items-center gap-4 bg-slate-50 dark:bg-slate-950/50 p-4 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-inner">
                                {{-- Start Time --}}
                                <div class="relative flex-1 text-center">
                                    <span class="text-[10px] text-slate-400 dark:text-slate-600 block uppercase tracking-widest font-black mb-1">Mulai</span>
                                    <input type="text" name="start_time" id="start_time" 
                                        class="block w-full text-center bg-transparent border-0 focus:ring-0 text-slate-800 dark:text-slate-200 font-black text-2xl placeholder-slate-300 p-0"
                                        placeholder="00:00">
                                </div>

                                <div class="text-slate-200 dark:text-slate-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-8 h-8">
                                        <path fill-rule="evenodd" d="M16.72 7.72a.75.75 0 011.06 0l3.75 3.75a.75.75 0 010 1.06l-3.75 3.75a.75.75 0 11-1.06-1.06l2.47-2.47H3a.75.75 0 010-1.5h16.19l-2.47-2.47a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </div>

                                {{-- End Time --}}
                                <div class="relative flex-1 text-center">
                                    <span class="text-[10px] text-slate-400 dark:text-slate-600 block uppercase tracking-widest font-black mb-1">Selesai</span>
                                    <input type="text" name="end_time" id="end_time" 
                                        class="block w-full text-center bg-transparent border-0 focus:ring-0 text-slate-800 dark:text-slate-200 font-black text-2xl placeholder-slate-300 p-0"
                                        placeholder="00:00">
                                </div>
                            </div>
                    </div>

                    {{-- 4. Reason --}}
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 mb-2 ml-1">Alasan Detail</label>
                        <textarea name="note" rows="3" 
                            class="block w-full rounded-2xl border-slate-100 dark:border-slate-800 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-4 px-5 transition-all bg-slate-50 dark:bg-slate-950/50 text-slate-800 dark:text-slate-200 placeholder-slate-400/70 border-2" 
                            required placeholder="Tuliskan alasan izin Anda dengan jelas..."></textarea>
                    </div>
                </div>

                {{-- Footer Buttons --}}
                <div class="pt-2 flex justify-end gap-3 border-t border-slate-100 dark:border-slate-800 mt-6 md:-mx-6 md:bg-slate-50/50 dark:md:bg-slate-800/50 md:px-6 md:py-4 -mb-6 rounded-b-2xl">
                    <button type="button" onclick="closeModal('permissionModal')" 
                        class="bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold py-2.5 px-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm transition-all text-sm">
                        Batal
                    </button>
                    <button type="submit" 
                        class="bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg shadow-red-500/30 transition-all transform hover:-translate-y-0.5 text-sm">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
