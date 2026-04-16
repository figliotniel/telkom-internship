<x-focus-layout>
    <!-- Top Right Nav (Logout & Theme) -->
    <div class="absolute top-6 right-6 flex items-center gap-3 z-50">
        <button @click="toggleTheme()" class="w-10 h-10 flex items-center justify-center rounded-full glass-inner border border-white/50 text-[#55565b] dark:text-slate-300 hover:text-[#EE2A24] dark:hover:text-[#EE2A24] shadow-sm transition-all focus:outline-none">
            <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
            <svg x-cloak x-show="darkMode" class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" /></svg>
        </button>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-5 py-2 glass-inner border border-white/50 text-[#55565b] dark:text-slate-300 hover:text-[#EE2A24] dark:hover:text-red-400 text-sm font-bold rounded-full transition-all shadow-md flex items-center group">
                Keluar
                <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            </button>
        </form>
    </div>
    
    <!-- Branding -->
    <div class="absolute top-8 left-8 flex items-center gap-3 group z-50">
        <div class="relative w-11 h-11 flex items-center justify-center">
            <div class="absolute inset-0 bg-white/50 dark:bg-red-500/20 rounded-xl blur-md group-hover:blur-xl transition-all duration-300 shadow-xl"></div>
            <div class="relative w-full h-full bg-white dark:bg-gradient-to-br dark:from-red-500 dark:to-red-700 rounded-xl overflow-hidden border border-white/50 dark:border-red-400/30 flex items-center justify-center shadow-lg group-hover:-translate-y-1 transition-all duration-300">
                <img src="{{ asset('images/icon-telkom.png') }}" class="w-full h-full object-contain p-1.5 dark:hidden">
                <img src="{{ asset('images/icon-telkom-white.png') }}" class="w-full h-full object-contain p-1.5 hidden dark:block">
            </div>
            <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-white dark:bg-red-400 rounded-full border-[3px] border-slate-100 dark:border-slate-900 group-hover:animate-pulse"></div>
        </div>
        <div class="flex flex-col">
            <span class="font-extrabold text-2xl tracking-tight text-[#EE2A24] leading-none drop-shadow-sm">Magang<span class="text-red-300">.</span></span>
            <span class="text-[9px] font-bold text-[#EE2A24]/70 tracking-[0.2em] uppercase mt-1">Monitoring System</span>
        </div>
    </div>

    <!-- Centered Glass Card -->
    <div class="w-full max-w-2xl glass-card rounded-[2.5rem] p-8 md:p-12 relative z-10 mx-auto mt-12 md:mt-0 animate-fade-in-up">
        
        @if(isset($internship) && $internship->status == 'onboarding')
            @php
                $suratJawaban = $internship->documents->where('type', 'surat_jawaban')->first();
                $paktaTemplate = $internship->documents->where('type', 'pakta_integritas')->first();
                $signedPact = $internship->documents->where('type', 'pakta_integritas_signed')->first();
            @endphp

            <div class="text-center mb-10">
                <h3 class="text-3xl sm:text-4xl font-black text-[#55565b] dark:text-slate-100 mb-4 block tracking-tight">Tahap Terakhir.</h3>
                <p class="text-[#55565b]/80 dark:text-slate-300 leading-relaxed text-sm lg:text-base px-4">
                    Lengkapi Pakta Integritas untuk menyelesaikan administrasi dan membuka akses menuju ekosistem kerja nyata Telkom Indonesia.
                </p>
            </div>

            <!-- Divisi Info -->
            <div class="glass-inner rounded-3xl p-6 flex flex-col sm:flex-row items-center justify-between mb-8 shadow-sm text-center sm:text-left">
                <div>
                    <p class="text-[10px] text-[#55565b]/60 dark:text-slate-400 font-bold uppercase tracking-widest mb-1 mt-0">Divisi Penempatan</p>
                    <p class="font-black text-[#55565b] dark:text-slate-100 text-lg">{{ $internship->division->name ?? '-' }}</p>
                </div>
                <div class="w-full h-px sm:w-px sm:h-12 bg-[#55565b]/10 dark:bg-slate-700 my-4 sm:my-0 mx-4"></div>
                <div>
                    <p class="text-[10px] text-[#55565b]/60 dark:text-slate-400 font-bold uppercase tracking-widest mb-1 mt-0">Mentor Utama</p>
                    <p class="font-black text-[#55565b] dark:text-slate-100 text-lg">{{ $internship->mentor->name ?? '-' }}</p>
                </div>
            </div>

            @if(!$signedPact)
            <!-- Important Note -->
            <div class="glass-inner border border-amber-200/50 dark:border-amber-500/30 p-4 rounded-xl flex items-start gap-3 mb-8 shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] text-left">
                <svg class="w-5 h-5 text-amber-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <p class="font-bold text-amber-700 dark:text-amber-400 text-sm mb-1">Perhatian Khusus</p>
                    <p class="text-[#55565b]/80 dark:text-slate-300 text-xs sm:text-sm">Tulis secara manual nama Divisi: <strong class="text-amber-600 dark:text-amber-300">{{ $internship->division->name ?? '...' }}</strong> pada dokumen cetak sebelum dipindai (scan).</p>
                </div>
            </div>
            @endif

            @if($signedPact)
                <!-- SUCCESS STATE -->
                <div class="glass-inner border border-emerald-200/50 dark:border-emerald-800/50 p-8 rounded-3xl text-center shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)]">
                    <div class="w-16 h-16 bg-emerald-100/50 dark:bg-emerald-800/50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/50">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h4 class="font-black text-xl text-emerald-700 dark:text-emerald-400 mb-2">Unggah Berhasil</h4>
                    <p class="text-sm text-[#55565b]/80 dark:text-slate-300">
                        Pakta Integritas telah diunggah. Mohon tunggu, Admin Telkom Indonesia sedang memverifikasi keabsahan dokumen Anda. Evaluasi ini membutuhkan waktu 1-2 hari kerja.
                    </p>
                </div>
            @else
                <!-- 2 STEP PROCESS -->
                <div class="space-y-6">
                    
                    <!-- Step 1 -->
                    <div class="glass-inner rounded-2xl p-6 relative shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] border border-white/60 dark:border-slate-700/50">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="flex items-center gap-5">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-[#55565b] dark:text-slate-300 flex items-center justify-center font-black flex-shrink-0">1</div>
                                <div>
                                    <h4 class="font-bold text-[#55565b] dark:text-slate-100">Unduh Dokumen Syarat</h4>
                                    <p class="text-xs text-[#55565b]/70 dark:text-slate-400 mt-1">Dapatkan panduan dan formulir isian.</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2 ml-14 sm:ml-0 mt-2 sm:mt-0">
                                @if($suratJawaban)
                                    <a href="{{ Storage::url($suratJawaban->file_path) }}" target="_blank" class="px-4 py-2 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 text-[#55565b] dark:text-slate-300 font-bold text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors shadow-sm whitespace-nowrap">Surat Jawaban</a>
                                @endif
                                @if($paktaTemplate)
                                    @php
                                        $isUrl = Str::startsWith($paktaTemplate->file_path, ['http://', 'https://']);
                                        $paktaLink = $isUrl ? $paktaTemplate->file_path : Storage::url($paktaTemplate->file_path);
                                    @endphp
                                    <a href="{{ $paktaLink }}" target="_blank" class="px-4 py-2 bg-[#EE2A24]/10 dark:bg-[#EE2A24]/20 border border-[#EE2A24]/20 dark:border-[#EE2A24]/30 text-[#EE2A24] font-bold text-[10px] uppercase tracking-widest rounded-xl hover:bg-[#EE2A24]/20 dark:hover:bg-[#EE2A24]/30 transition-colors shadow-sm whitespace-nowrap">Template Pakta</a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="glass-inner rounded-2xl p-6 relative shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] border border-white/60 dark:border-slate-700/50">
                        <div class="flex items-center gap-5 mb-5">
                            <div class="w-10 h-10 rounded-xl bg-[#EE2A24] text-white shadow-lg shadow-[#EE2A24]/30 flex items-center justify-center font-black flex-shrink-0">2</div>
                            <div>
                                <h4 class="font-bold text-[#55565b] dark:text-slate-100">Unggah Pakta Valid</h4>
                                <p class="text-xs text-[#55565b]/70 dark:text-slate-400 mt-1">Upload PDF Max 5MB berserta ttd asli.</p>
                            </div>
                        </div>
                        
                        <form action="{{ route('documents.storePaktaIntegritas') }}" method="POST" enctype="multipart/form-data"
                            x-data="{ 
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
                                            Swal.fire({ icon: 'error', title: 'Invalid', text: 'Hanya format PDF.' });
                                        }
                                    }
                                },
                                clearFile() {
                                    this.fileName = '';
                                    this.$refs.fileInput.value = '';
                                }
                            }">
                            @csrf
                            
                            <div class="ml-0 sm:ml-14">
                                <div 
                                    @dragover.prevent="isDragging = true" 
                                    @dragleave.prevent="isDragging = false" 
                                    @drop.prevent="handleDrop($event)"
                                    :class="{'border-[#EE2A24] bg-white/80 dark:bg-slate-800/80 scale-[1.02]': isDragging, 'border-[#EE2A24]/30 bg-white/50 dark:bg-slate-900/50': !isDragging}"
                                    class="w-full border-2 border-dashed rounded-xl p-8 flex flex-col items-center justify-center relative cursor-pointer hover:bg-white dark:hover:bg-slate-800 transition-all mb-4 group shadow-inner">
                                    
                                    <input type="file" name="file" accept=".pdf" x-ref="fileInput" class="absolute inset-0 opacity-0 cursor-pointer z-10" required @change="fileName = $event.target.files[0].name" :class="{'hidden': fileName}">
                                    
                                    <div class="text-center transition-transform group-hover:scale-105 duration-300">
                                        <div class="inline-flex w-12 h-12 rounded-full bg-white dark:bg-slate-900 shadow-sm border border-slate-100 dark:border-slate-800 items-center justify-center text-[#55565b]/40 dark:text-slate-500 mb-3 group-hover:text-[#EE2A24] transition-colors">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                        </div>
                                        
                                        <div class="text-sm">
                                            <span x-show="!fileName" class="font-bold text-[#55565b]/80 dark:text-slate-300 block">Ketuk untuk Memilih File PDF</span>
                                            
                                            <div x-show="fileName" style="display: none;" class="flex items-center gap-2 bg-slate-900 text-white dark:bg-white dark:text-slate-900 px-4 py-2 rounded-lg relative z-20">
                                                <svg class="w-4 h-4 shrink-0 text-emerald-400 dark:text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                                                <span x-text="fileName" class="font-bold text-xs truncate max-w-[150px]"></span>
                                                <button type="button" @click.stop.prevent="clearFile()" class="ml-2 py-1 px-1 hover:text-red-400 transition-colors">
                                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="w-full flex items-center justify-center py-3.5 bg-gradient-to-r from-[#EE2A24] to-[#C81B15] hover:opacity-90 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-[#EE2A24]/20 active:scale-95">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" /></svg>
                                    Mulai Pengunggahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

        @elseif(isset($internship) && $internship->status == 'rejected')
            {{-- REJECTED STATE --}}
            <div class="text-center">
                <div class="w-20 h-20 bg-red-50/50 dark:bg-red-900/30 text-[#EE2A24] rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner border border-white/50">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                
                <h3 class="text-3xl font-black text-[#55565b] dark:text-slate-100 mb-4 tracking-tight">Mohon Maaf, Kuota Penuh.</h3>
                <p class="text-[#55565b]/80 dark:text-slate-300 leading-relaxed mb-8 max-w-md mx-auto">
                    Terima kasih atas antusiasme Anda untuk bergabung. Keputusan ini karena keterbatasan operasional tempat di lokasi tujuan, dan bukan cerminan kemampuan Anda.
                </p>

                @if($internship->response_letter)
                    <a href="{{ Storage::url($internship->response_letter) }}" target="_blank" class="inline-flex items-center px-6 py-3 glass-inner border border-white/50 dark:border-slate-700/50 rounded-xl font-bold text-xs uppercase tracking-widest text-[#EE2A24] dark:text-red-400 hover:shadow-md transition-all shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Surat Penolakan Resmi
                    </a>
                @endif
            </div>

        @else
            {{-- PENDING / NULL STATE --}}
            <div class="text-center">
                <div class="w-20 h-20 bg-amber-50/50 dark:bg-amber-900/20 text-amber-500 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-inner border border-white/50">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                </div>
                
                @if(!isset($internship))
                    <h3 class="text-3xl font-black text-[#55565b] dark:text-slate-100 mb-4 tracking-tight">Data Belum Tersedia.</h3>
                    <p class="text-[#55565b]/80 dark:text-slate-300 leading-relaxed max-w-md mx-auto">
                        Akun Anda belum terdaftar dalam program magang aktif manapun. Silakan coba kembali nanti atau hubungi Admin.
                    </p>
                @else
                    <h3 class="text-3xl font-black text-[#55565b] dark:text-slate-100 mb-4 tracking-tight">Sedang Diverifikasi.</h3>
                    <p class="text-[#55565b]/80 dark:text-slate-300 leading-relaxed max-w-md mx-auto">
                        Pengajuan magangmu telah masuk sistem dan antrean verifikasi sedang berjalan perlahan. Pantau terus halaman ini untuk mengetahui progresnya.
                    </p>
                @endif
            </div>
        @endif

    </div>

    <!-- Footer snippet -->
    <div class="absolute bottom-6 w-full text-center text-[#55565b]/60 dark:text-slate-500 font-medium text-xs pointer-events-none mt-16">
        &copy; {{ date('Y') }} PT Telkom Indonesia (Persero) Tbk.
    </div>

</x-focus-layout>