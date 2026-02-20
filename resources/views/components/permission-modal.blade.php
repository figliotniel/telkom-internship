<div id="permissionModal" class="hidden fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeModal('permissionModal')"></div>
        
        <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all w-full max-w-lg border border-slate-100">
            
            {{-- Modal Header --}}
            <div class="bg-white px-6 py-4 flex justify-between items-center border-b border-slate-100">
                <h3 class="text-lg leading-6 font-bold text-slate-800">Pengajuan Izin</h3>
                <button type="button" onclick="closeModal('permissionModal')" class="text-slate-400 hover:text-red-500 transition-colors bg-white hover:bg-red-50 rounded-lg p-1.5 border border-transparent hover:border-red-100">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('attendance.permission') }}" method="POST" enctype="multipart/form-data" class="px-6 pb-6 pt-2">
                @csrf
                
                <div class="space-y-5">
                    {{-- 1. Date Section --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Tanggal Pengajuan</label>
                        
                        @php
                            $displayDate = \Carbon\Carbon::now()->hour < 7 ? \Carbon\Carbon::yesterday() : \Carbon\Carbon::today();
                        @endphp

                        {{-- Badge Display --}}
                        <div id="date_badge_container" class="hidden flex items-center justify-center gap-2">
                            <div class="bg-red-50 text-red-600 px-4 py-2 rounded-xl font-bold text-xl border border-red-100 shadow-sm">
                                {{ $displayDate->format('d') }}
                            </div>
                            <div class="bg-red-50 text-red-600 px-4 py-2 rounded-xl font-bold text-xl border border-red-100 shadow-sm">
                                {{ $displayDate->translatedFormat('F') }}
                            </div>
                            <div class="bg-red-50 text-red-600 px-4 py-2 rounded-xl font-bold text-xl border border-red-100 shadow-sm">
                                {{ $displayDate->format('Y') }}
                            </div>
                        </div>

                        <input type="hidden" name="date" value="{{ $displayDate->format('Y-m-d') }}" id="hidden_date_input">

                        {{-- Date Input --}}
                        <div id="date_input_container" class="relative group w-full">
                            <input type="text" name="date" id="permission_date"
                                class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm bg-white py-3 pl-10 transition-all text-left font-semibold text-slate-700" 
                                placeholder="Pilih tanggal..." required>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 group-focus-within:text-red-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                    <path d="M12.75 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM7.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM8.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM9.75 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM10.5 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM12.75 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM14.25 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 15.75a.75.75 0 100-1.5.75.75 0 000 1.5zM15 12.75a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM16.5 13.5a.75.75 0 100-1.5.75.75 0 000 1.5z" />
                                    <path fill-rule="evenodd" d="M6.75 2.25a.75.75 0 01.75.75v.75h9v-.75a.75.75 0 011.5 0v.75h1.5a3 3 0 013 3v15a3 3 0 01-3 3h-15a3 3 0 01-3-3v-15a3 3 0 013-3h1.5v-.75a.75.75 0 01.75-.75zM3.75 6.75a1.5 1.5 0 00-1.5 1.5v12a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-12a1.5 1.5 0 00-1.5-1.5h-15z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Permit Type --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Jenis Izin</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Temporary Permit Card -->
                            <label class="cursor-pointer relative">
                                <input type="radio" name="permit_type" value="temporary" class="peer sr-only" onchange="toggleAttachment()" checked>
                                <div class="p-4 rounded-xl border-2 border-slate-200 hover:border-red-200 bg-white transition-all peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:ring-1 peer-checked:ring-red-500">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 rounded-lg bg-red-100 text-red-600 peer-checked:bg-red-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-700 peer-checked:text-red-700">Izin Keluar</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-2 right-2 peer-checked:block hidden text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </label>

                            <!-- Full Day Permit Card -->
                            <label class="cursor-pointer relative" id="full_permit_label">
                                <input type="radio" name="permit_type" value="full" class="peer sr-only" onchange="toggleAttachment()">
                                <div class="p-4 rounded-xl border-2 border-slate-200 hover:border-red-200 bg-white transition-all peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:ring-1 peer-checked:ring-red-500 peer-disabled:opacity-50 peer-disabled:cursor-not-allowed">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 rounded-lg bg-slate-100 text-slate-600 peer-checked:bg-red-200 peer-checked:text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0118 9.375v9.375a3 3 0 003-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 00-.673-.05A3 3 0 0015 1.5h-1.5a3 3 0 00-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6zM13.5 1.5h-3c-1.103 0-2 .897-2 2s.897 2 2 2h3c1.103 0 2-.897 2-2s-.897-2-2-2z" clip-rule="evenodd" />
                                                <path d="M4.5 9h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9A2.25 2.25 0 012.25 20.25v-9A2.25 2.25 0 014.5 9z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-700 peer-checked:text-red-700">Izin Full / Sakit</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute top-2 right-2 peer-checked:block hidden text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- 3. Time Inputs (Conditional) --}}
                    <div id="time_div" class="hidden space-y-3">
                            <label class="block text-sm font-semibold text-slate-700">Durasi Izin</label>
                            <div class="flex items-center gap-2 bg-slate-50 p-2 rounded-xl border border-slate-200">
                                {{-- Start Time --}}
                                <div class="relative flex-1">
                                    <input type="text" name="start_time" id="start_time" 
                                        class="block w-full text-center bg-transparent border-0 focus:ring-0 text-slate-800 font-bold text-lg placeholder-slate-400 p-0"
                                        placeholder="Jam Mulai">
                                    <span class="text-xs text-slate-400 block text-center uppercase tracking-wider font-semibold">Mulai</span>
                                </div>

                                <div class="text-slate-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path fill-rule="evenodd" d="M16.72 7.72a.75.75 0 011.06 0l3.75 3.75a.75.75 0 010 1.06l-3.75 3.75a.75.75 0 11-1.06-1.06l2.47-2.47H3a.75.75 0 010-1.5h16.19l-2.47-2.47a.75.75 0 010-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </div>

                                {{-- End Time --}}
                                <div class="relative flex-1">
                                    <input type="text" name="end_time" id="end_time" 
                                        class="block w-full text-center bg-transparent border-0 focus:ring-0 text-slate-800 font-bold text-lg placeholder-slate-400 p-0"
                                        placeholder="Jam Selesai">
                                    <span class="text-xs text-slate-400 block text-center uppercase tracking-wider font-semibold">Selesai</span>
                                </div>
                            </div>
                    </div>

                    {{-- 4. Reason --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Alasan Izin</label>
                        <textarea name="note" rows="3" 
                            class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-3 px-3 transition-all" 
                            required placeholder="Jelaskan alasan izin Anda secara detail..."></textarea>
                    </div>
                </div>

                {{-- Footer Buttons --}}
                <div class="pt-2 flex justify-end gap-3 border-t border-slate-100 mt-6 md:-mx-6 md:bg-slate-50/50 md:px-6 md:py-4 -mb-6 rounded-b-2xl">
                    <button type="button" onclick="closeModal('permissionModal')" 
                        class="bg-white hover:bg-slate-50 text-slate-700 font-semibold py-2.5 px-5 rounded-xl border border-slate-200 shadow-sm transition-all text-sm">
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
