<div id="fullDayPermissionModal" class="hidden fixed inset-0 z-[1000] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-slate-900/75 dark:bg-slate-950/80 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="closeModal('fullDayPermissionModal')"></div>
        
        <div class="relative bg-[#e6e6e6] dark:bg-slate-900 rounded-[2rem] text-left overflow-hidden shadow-2xl dark:shadow-slate-950 transform transition-all w-full max-w-2xl border border-white/20 dark:border-slate-800">
            
            {{-- Modal Header --}}
            <div class="px-8 py-6 flex justify-between items-center border-b border-white/50 dark:border-slate-800">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full border border-slate-400 dark:border-slate-600 flex items-center justify-center text-slate-700 dark:text-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100 tracking-tight">Pengajuan Izin Full Day</h3>
                </div>
                <button type="button" onclick="closeModal('fullDayPermissionModal')" class="text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 transition-colors">
                    <span class="sr-only">Close</span>
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('attendance.permission') }}" method="POST" enctype="multipart/form-data" id="fullDayPermissionForm">
                @csrf
                <input type="hidden" name="permit_type" value="full">
                <input type="hidden" name="date" id="full_day_date_range" required>

                <div class="px-8 py-6 flex flex-col md:flex-row gap-8">
                    {{-- Calendar Section --}}
                    <div class="w-full md:w-1/2">
                        <div class="bg-[#9e9b98] dark:bg-slate-800 rounded-[1.5rem] p-4 shadow-inner">
                            <input type="text" id="inline_calendar" class="hidden">
                        </div>
                    </div>

                    {{-- Dates Info Section --}}
                    <div class="w-full md:w-1/2 flex flex-col justify-center space-y-6">
                        <div>
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-300 mb-2">Tanggal Mulai</p>
                            <div class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 font-bold px-6 py-3 rounded-full shadow-sm text-center" id="display_start_date">
                                -
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-300 mb-2">Tanggal Selesai</p>
                            <div class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 font-bold px-6 py-3 rounded-full shadow-sm text-center" id="display_end_date">
                                -
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-300 mb-2">Alasan Izin</p>
                            <textarea name="note" rows="2" 
                                class="w-full rounded-2xl border-white/50 dark:border-slate-700 shadow-sm focus:border-slate-500 focus:ring-slate-500 sm:text-sm py-3 px-4 bg-white/50 dark:bg-slate-800/50 text-slate-800 dark:text-slate-200" 
                                required placeholder="Tuliskan alasan..."></textarea>
                        </div>
                    </div>
                </div>

                {{-- Footer Section --}}
                <div class="px-8 py-6 border-t border-white/50 dark:border-slate-800 flex justify-between items-center">
                    <div class="text-slate-800 dark:text-slate-300 font-bold text-lg">
                        Durasi Izin: <span id="display_duration">0</span> Hari
                    </div>
                    <button type="submit" 
                        class="bg-white hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-100 font-bold py-3 px-6 rounded-full shadow-sm transition-all transform hover:-translate-y-0.5">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Override default flatpickr styles for this specific inline calendar */
#inline_calendar .flatpickr-calendar {
    background: transparent !important;
    box-shadow: none !important;
    border: none !important;
    width: 100% !important;
}
#inline_calendar .flatpickr-months {
    background: white !important;
    border-radius: 9999px !important;
    margin-bottom: 10px !important;
    padding: 5px !important;
}
.dark #inline_calendar .flatpickr-months {
    background: #1e293b !important;
}
#inline_calendar .flatpickr-month {
    color: #1e293b !important;
}
.dark #inline_calendar .flatpickr-month {
    color: #f1f5f9 !important;
}
#inline_calendar .flatpickr-current-month {
    padding-top: 0 !important;
    font-size: 1rem !important;
}
#inline_calendar .flatpickr-weekday {
    color: #1e293b !important;
    font-weight: 600 !important;
}
.dark #inline_calendar .flatpickr-weekday {
    color: #cbd5e1 !important;
}
#inline_calendar .flatpickr-day {
    color: #1e293b !important;
    font-weight: 500 !important;
    border-radius: 50% !important;
}
.dark #inline_calendar .flatpickr-day {
    color: #cbd5e1 !important;
}
#inline_calendar .flatpickr-day.selected, 
#inline_calendar .flatpickr-day.startRange, 
#inline_calendar .flatpickr-day.endRange, 
#inline_calendar .flatpickr-day.selected.inRange, 
#inline_calendar .flatpickr-day.startRange.inRange, 
#inline_calendar .flatpickr-day.endRange.inRange, 
#inline_calendar .flatpickr-day.selected:focus, 
#inline_calendar .flatpickr-day.startRange:focus, 
#inline_calendar .flatpickr-day.endRange:focus, 
#inline_calendar .flatpickr-day.selected:hover, 
#inline_calendar .flatpickr-day.startRange:hover, 
#inline_calendar .flatpickr-day.endRange:hover, 
#inline_calendar .flatpickr-day.selected.prevMonthDay, 
#inline_calendar .flatpickr-day.startRange.prevMonthDay, 
#inline_calendar .flatpickr-day.endRange.prevMonthDay, 
#inline_calendar .flatpickr-day.selected.nextMonthDay, 
#inline_calendar .flatpickr-day.startRange.nextMonthDay, 
#inline_calendar .flatpickr-day.endRange.nextMonthDay {
    background: #3b82f6 !important;
    border-color: #3b82f6 !important;
    color: white !important;
}
#inline_calendar .flatpickr-day.inRange,
#inline_calendar .flatpickr-day.prevMonthDay.inRange,
#inline_calendar .flatpickr-day.nextMonthDay.inRange,
#inline_calendar .flatpickr-day.today.inRange,
#inline_calendar .flatpickr-day.prevMonthDay.today.inRange,
#inline_calendar .flatpickr-day.nextMonthDay.today.inRange,
#inline_calendar .flatpickr-day:hover,
#inline_calendar .flatpickr-day.prevMonthDay:hover,
#inline_calendar .flatpickr-day.nextMonthDay:hover,
#inline_calendar .flatpickr-day:focus,
#inline_calendar .flatpickr-day.prevMonthDay:focus,
#inline_calendar .flatpickr-day.nextMonthDay:focus {
    background: rgba(255, 255, 255, 0.3) !important;
    border-color: transparent !important;
}
.dark #inline_calendar .flatpickr-day.inRange {
    background: rgba(59, 130, 246, 0.2) !important;
}
</style>
