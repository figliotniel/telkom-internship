@props(['mentorsList'])

<!-- Add Mentor Modal (Premium Glassmorphism Design) -->
<div id="addMentorModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        
    <!-- Modal Container -->
    <div class="bg-white/70 dark:bg-slate-900/75 backdrop-blur-xl border border-white/40 dark:border-white/5 w-full max-w-6xl rounded-[2rem] shadow-2xl transform scale-95 transition-all duration-300 flex flex-col md:flex-row overflow-hidden max-h-[90vh] ring-1 ring-white/20 dark:ring-white/10" id="addMentorModalContent">
        
        <!-- ========================================== -->
        <!-- LEFT SIDE: List of existing mentors -->
        <!-- ========================================== -->
        <div class="w-full md:w-5/12 lg:w-4/12 flex flex-col bg-white/40 dark:bg-slate-900/40 relative border-b md:border-b-0 md:border-r border-slate-200/50 dark:border-slate-700/50">
            
            <!-- Header Left -->
            <div class="px-8 py-6 border-b border-slate-200/50 dark:border-slate-700/50 flex justify-between items-center sticky top-0 backdrop-blur-xl z-20">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-900 dark:text-white tracking-tight">Daftar Mentor</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Pembimbing aktif divisi</p>
                </div>
                <div class="px-3 py-1.5 bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 text-xs font-black rounded-xl border border-red-100 dark:border-red-500/20 shadow-sm">
                    {{ $mentorsList->count() }} Mentor
                </div>
            </div>

            <!-- List Area (Scrollable) -->
            <div class="p-6 overflow-y-auto custom-scrollbar flex-1 space-y-4 max-h-[26rem]">
                @forelse($mentorsList as $mentor)
                    <div class="group relative bg-white dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-4 flex items-center gap-4 hover:shadow-xl hover:shadow-red-500/10 hover:border-red-300 dark:hover:border-red-500/50 hover:-translate-y-1 transition-all duration-300">
                        <div class="w-12 h-12 rounded-[1rem] bg-gradient-to-br from-red-500 to-red-400 flex items-center justify-center text-white font-bold text-lg shadow-inner shrink-0 ring-2 ring-white dark:ring-slate-900">
                            {{ substr($mentor->name, 0, 1) }}
                        </div>
                        <div class="min-w-0 flex-1 relative">
                            <h4 class="font-bold text-slate-900 dark:text-slate-100 text-sm truncate group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">{{ $mentor->name }}</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate mt-0.5">{{ $mentor->email }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-[9px] px-2 py-0.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-md font-bold uppercase tracking-wider">{{ optional($mentor->mentorProfile)->position ?? 'Mentor' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada data mentor.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ========================================== -->
        <!-- RIGHT SIDE: Form Add Mentor -->
        <!-- ========================================== -->
        <div class="w-full md:w-7/12 lg:w-8/12 flex flex-col bg-white dark:bg-slate-900 relative">
            
            <!-- Close Button (Absolute Top Right) -->
            <button type="button" onclick="closeAddMentorModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-700 dark:hover:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-full p-2.5 transition-all focus:outline-none z-30 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Form Header -->
            <div class="px-10 pt-10 pb-6 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-red-50 dark:bg-red-500/10 flex items-center justify-center text-red-600 dark:text-red-400 border border-red-100 dark:border-red-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Tambah Mentor Baru</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Buat akun untuk pembimbing magang dengan kredensial baru.</p>
                    </div>
                </div>
            </div>
            
            <!-- Form Scrollable Area -->
            <div class="px-10 py-8 overflow-y-auto custom-scrollbar flex-1">
                <form action="{{ route('admin.mentors.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Form Grid -->
                    <div class="grid grid-cols-1 gap-6">
                        
                        <!-- Nama Lengkap (Full Width) -->
                        <div class="group/input transition-transform duration-300 focus-within:-translate-y-0.5">
                            <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input type="text" name="name" required placeholder="Masukkan nama lengkap" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 hover:border-slate-300 dark:hover:border-slate-700 transition-all shadow-sm">
                            </div>
                        </div>
                        
                        <!-- Grid Setengah (Email & Password) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div class="group/input transition-transform duration-300 focus-within:-translate-y-0.5">
                                <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2">Email <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <input type="email" name="email" required placeholder="mentor@telkom.co.id" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 hover:border-slate-300 dark:hover:border-slate-700 transition-all shadow-sm">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="group/input transition-transform duration-300 focus-within:-translate-y-0.5">
                                <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2">Password <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full pl-11 pr-4 py-3.5 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 hover:border-slate-300 dark:hover:border-slate-700 transition-all shadow-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Jabatan (Full Width instead of half with NIK) -->
                        <div class="group/input transition-transform duration-300 focus-within:-translate-y-0.5">
                            <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1 mb-2">Jabatan (Posisi) <span class="text-red-500">*</span></label>
                            <input type="text" name="position" required placeholder="Contoh: Officer 2" class="w-full px-5 py-3.5 bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-red-500 focus:ring-4 focus:ring-red-500/10 hover:border-slate-300 dark:hover:border-slate-700 transition-all shadow-sm">
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="pt-8 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-4">
                        <button type="button" onclick="closeAddMentorModal()" class="px-6 py-3.5 text-slate-600 dark:text-slate-400 font-bold hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl transition-colors text-sm">
                            Batal
                        </button>
                        <button type="submit" class="px-8 py-3.5 bg-red-600 text-white rounded-2xl hover:bg-red-700 transition-all font-bold text-sm shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] active:scale-95 flex items-center gap-2">
                            Simpan Data
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                </form>
            </div>
            
        </div>
    </div>
</div>
