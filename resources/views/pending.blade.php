<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col w-full md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="font-bold text-2xl text-slate-800 dark:text-slate-200 leading-tight transition-colors">
                {{ __('Status Onboarding Magang') }}
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">
                Selesaikan tahapan onboarding Anda untuk memulai magang
            </p>
        </div>
    </x-slot>

    <div class="py-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex justify-center">

            @if(isset($internship) && $internship->status == 'onboarding')
                @php
                    $suratJawaban = $internship->documents->where('type', 'surat_jawaban')->first();
                    $paktaTemplate = $internship->documents->where('type', 'pakta_integritas')->first();
                    $signedPact = $internship->documents->where('type', 'pakta_integritas_signed')->first();
                @endphp

                <div class="w-full max-w-4xl space-y-6">
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-[2rem] shadow-sm overflow-hidden relative transition-colors">
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-amber-400 to-orange-500"></div>
                        
                        <div class="p-8 md:p-12 pb-8 text-center animate-fade-in">
                            <div class="w-20 h-20 bg-amber-50 dark:bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner text-amber-500 dark:text-amber-400">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </div>
                            
                            <h3 class="text-2xl font-black text-slate-800 dark:text-slate-100 mb-2">Lengkapi Dokumen Magang</h3>
                            <p class="text-slate-500 dark:text-slate-400 max-w-lg mx-auto mb-8 text-sm leading-relaxed">
                                Pengajuan Anda diterima. Silakan unduh format Pakta Integritas, tandatangani, dan unggah kembali untuk mengaktifkan akun Anda sepenuhnya.
                            </p>

                            <!-- Penempatan Info -->
                            <div class="bg-slate-50/50 dark:bg-slate-800/30 border border-slate-100 dark:border-slate-700/50 rounded-2xl p-6 text-left max-w-2xl mx-auto flex items-center justify-between mb-8">
                                <div>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest mb-1 mt-0">Divisi Penempatan</p>
                                    <p class="font-black text-slate-700 dark:text-slate-200">{{ $internship->division->name ?? '-' }}</p>
                                </div>
                                <div class="w-px h-8 bg-slate-200 dark:bg-slate-700 mx-4"></div>
                                <div class="text-right">
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest mb-1 mt-0">Mentor Pendamping</p>
                                    <p class="font-black text-slate-700 dark:text-slate-200">{{ $internship->mentor->name ?? '-' }}</p>
                                </div>
                            </div>
                            
                             <!-- Important Note -->
                             <div class="max-w-2xl mx-auto mb-8">
                                <div class="bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700/50 p-4 rounded-xl flex items-start gap-3 text-left transition-colors">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-500 mt-0.5 flex-shrink-0 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    <div>
                                        <p class="font-bold text-yellow-800 dark:text-yellow-400 text-sm mb-1 transition-colors">PENTING</p>
                                        <p class="text-yellow-700 dark:text-yellow-200/80 text-sm transition-colors">Mohon pastikan Anda menulis <strong>Divisi: <span class="text-yellow-900 dark:text-yellow-300 font-extrabold transition-colors">{{ $internship->division->name ?? '...' }}</span></strong> pada dokumen Pakta Integritas yang akan diunggah.</p>
                                    </div>
                                </div>
                            </div>

                            @if($signedPact)
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 text-blue-800 dark:text-blue-300 px-8 py-6 rounded-2xl max-w-2xl mx-auto flex flex-col items-center justify-center transition-colors">
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-800/50 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center mb-3 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h4 class="font-bold text-lg mb-1">Menunggu Verifikasi Admin</h4>
                                    <p class="text-blue-600/80 dark:text-blue-300/80 transition-colors text-sm">Anda telah mengunggah Pakta Integritas. Admin sedang memverifikasi dokumen Anda.</p>
                                </div>
                            @else
                                <!-- Steps (Stacked List Style) -->
                                <div class="max-w-2xl mx-auto text-left space-y-4">
                                    
                                    <!-- Step 1 -->
                                    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl flex flex-col md:flex-row items-start md:items-center justify-between p-4 px-6 hover:border-slate-300 dark:hover:border-slate-600 transition-colors shadow-sm group">
                                        <div class="flex items-center gap-5 mb-4 md:mb-0">
                                            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-900/50 flex flex-shrink-0 items-center justify-center font-black text-slate-400 dark:text-slate-500 group-hover:bg-amber-100 dark:group-hover:bg-amber-900/30 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">1</div>
                                            <div>
                                                <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm">Surat Jawaban & Template Pakta</h4>
                                                <p class="text-xs font-medium text-slate-400 dark:text-slate-500 mt-0.5">Unduh dokumen persyaratan magang</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap sm:flex-nowrap gap-2 justify-start sm:justify-end w-full md:w-auto mt-2 md:mt-0 pl-14 md:pl-0">
                                            @if($suratJawaban)
                                                <a href="{{ Storage::url($suratJawaban->file_path) }}" target="_blank" class="px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors whitespace-nowrap">Surat Jawaban</a>
                                            @endif
                                            @if($paktaTemplate)
                                                @php
                                                    $isUrl = Str::startsWith($paktaTemplate->file_path, ['http://', 'https://']);
                                                    $paktaLink = $isUrl ? $paktaTemplate->file_path : Storage::url($paktaTemplate->file_path);
                                                @endphp
                                                <a href="{{ $paktaLink }}" target="_blank" class="px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors whitespace-nowrap">Template Pakta</a>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl flex flex-col items-center justify-between p-4 px-6 relative overflow-hidden group">
                                        <!-- left indicator -->
                                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-400 transition-colors"></div>
                                        
                                        <div class="flex items-center gap-5 w-full mb-4">
                                            <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex flex-shrink-0 items-center justify-center font-black shadow-inner">2</div>
                                            <div>
                                                <h4 class="font-bold text-slate-800 dark:text-slate-200 text-sm">Unggah Pakta Integritas</h4>
                                                <p class="text-xs font-medium text-slate-500 mt-0.5">Format PDF max 5MB (bertanda tangan)</p>
                                            </div>
                                        </div>
                                        
                                        <div class="w-full">
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
                                                @csrf
                                                <div class="relative w-full">
                                                    <div 
                                                        @dragover.prevent="isDragging = true" 
                                                        @dragleave.prevent="isDragging = false" 
                                                        @drop.prevent="handleDrop($event)"
                                                        :class="{'border-amber-500 bg-amber-50/50 dark:bg-amber-500/10 scale-[1.02]': isDragging, 'border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/30': !isDragging}"
                                                        class="flex justify-center px-4 py-8 border-2 border-dashed rounded-2xl group/upload transition-all hover:bg-amber-50/50 dark:hover:bg-amber-500/5 hover:border-amber-400 relative cursor-pointer shadow-sm">
                                                        <input type="file" name="file" accept=".pdf" x-ref="fileInput" class="absolute inset-0 opacity-0 cursor-pointer z-10" required @change="fileName = $event.target.files[0].name" :class="{'hidden': fileName}">
                                                        
                                                        <div class="text-center space-y-2 transition-transform group-hover/upload:scale-105 duration-300 w-full">
                                                            <div class="inline-flex items-center justify-center w-10 h-10 bg-white dark:bg-slate-800 rounded-xl text-slate-400 dark:text-slate-500 group-hover/upload:text-amber-500 transition-all shadow-sm">
                                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                                            </div>
                                                            <div class="text-xs text-slate-600 dark:text-slate-400 relative z-20">
                                                                <span x-show="!fileName" class="font-bold block text-slate-800 dark:text-slate-200">Klik atau seret file PDF ke sini</span>
                                                                
                                                                <div x-show="fileName" style="display: none;" class="flex flex-col items-center gap-2 mt-1">
                                                                    <div class="flex items-center gap-2 bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300 px-3 py-1.5 rounded-lg border border-amber-200 dark:border-amber-500/30 w-full justify-center max-w-[250px] overflow-hidden">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                                                        <span x-text="fileName" class="font-bold truncate" style="max-width: 150px;"></span>
                                                                        <button type="button" @click.stop.prevent="clearFile()" class="p-1 hover:bg-amber-200 dark:hover:bg-amber-500/40 rounded-md transition-colors text-amber-600 hover:text-red-500 shrink-0">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 w-full flex justify-end">
                                                    <button type="submit" class="flex items-center justify-center gap-2 px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-[11px] font-black uppercase tracking-widest transition-all shadow-lg shadow-amber-500/20 active:scale-95">
                                                        Unggah Sekarang &rarr;
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            @elseif(isset($internship) && $internship->status == 'rejected')
                {{-- REJECTED STATE (QUOTA FULL) --}}
                <div class="max-w-4xl mx-auto bg-white dark:bg-slate-900 border border-red-100 dark:border-slate-800 rounded-[2rem] shadow-sm overflow-hidden relative transition-colors">
                    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-red-400 to-pink-500"></div>
                    
                    <div class="p-10 text-center">
                        {{-- Icon --}}
                        <div class="w-20 h-20 bg-red-50 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-red-500 dark:text-red-400 transition-colors">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm6.75-.75c-.207 0-.375.336-.375.75s.168.75.375.75.375-.336.375-.75-.168-.75-.375-.75z" />
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-4 tracking-tight transition-colors">Mohon Maaf, Kuota Magang Penuh</h3>
                        
                        <div class="max-w-2xl mx-auto space-y-4 text-gray-600 dark:text-slate-400 leading-relaxed transition-colors">
                            <p>
                                Terima kasih atas antusiasme Anda untuk bergabung dengan Telkom Internship. 
                                Namun, dengan berat hati kami sampaikan bahwa saat ini <strong class="dark:text-slate-200">kuota magang untuk posisi/lokasi yang Anda tuju sudah terpenuhi</strong>.
                            </p>
                            
                            {{-- Encouraging Message --}}
                            <div class="bg-orange-50/50 dark:bg-orange-900/20 border border-orange-100 dark:border-orange-800/50 rounded-2xl p-6 mt-6 transition-colors">
                                <h4 class="font-bold text-orange-800 dark:text-orange-400 mb-2 flex items-center justify-center gap-2 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Tetap Semangat!
                                </h4>
                                <p class="text-gray-600 dark:text-slate-400 text-sm transition-colors">
                                    Keputusan ini semata-mata karena keterbatasan tempat dan <strong class="dark:text-slate-200">bukan cerminan kemampuan Anda</strong>. 
                                    Profil Anda sangat potensial! Jangan berkecil hati, teruslah belajar, berkarya, dan silakan mencoba kembali di kesempatan berikutnya.
                                </p>
                            </div>
                        </div>

                        @if($internship->response_letter)
                            <div class="mt-8 flex justify-center">
                                <a href="{{ Storage::url($internship->response_letter) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl font-bold text-[11px] uppercase tracking-widest text-slate-600 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-400 hover:border-red-200 dark:hover:border-red-500/50 hover:bg-red-50 dark:hover:bg-red-900/30 transition-all shadow-sm active:scale-95 group">
                                    <svg class="w-4 h-4 mr-2 text-slate-400 dark:text-slate-500 group-hover:text-red-500 dark:group-hover:text-red-400 transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Lihat Surat Penolakan Resmi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            @else
                {{-- Default Pending/No Data --}}
                <div class="max-w-2xl w-full mx-auto">
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-8 shadow-sm flex flex-col sm:flex-row items-center sm:items-start gap-6 text-center sm:text-left transition-colors">
                        <div class="w-16 h-16 bg-yellow-50 dark:bg-yellow-500/10 text-yellow-500 flex shrink-0 items-center justify-center rounded-2xl shadow-inner border border-yellow-100 dark:border-yellow-500/20 transition-colors">
                            <svg class="h-8 w-8 text-yellow-400 dark:text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div>
                            @if(!isset($internship))
                                <h3 class="text-xl font-black text-slate-800 dark:text-slate-100 transition-colors">Data Magang Belum Tersedia</h3>
                                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 transition-colors leading-relaxed">
                                    Akun Anda belum terdaftar dalam program magang aktif. Silakan hubungi Administrator jika ini adalah sebuah kesalahan.
                                </p>
                            @elseif($internship->status == 'pending')
                                <h3 class="text-xl font-black text-slate-800 dark:text-slate-100 transition-colors">Menunggu Verifikasi Persetujuan</h3>
                                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 transition-colors leading-relaxed">
                                    Pengajuan magang Anda telah diterima dan sedang dalam antrean proses verifikasi oleh tim Admin/HR Telkom.
                                </p>
                                <p class="mt-2 text-sm font-bold text-slate-600 dark:text-slate-300 transition-colors">Mohon cek status halaman ini secara berkala untuk info selanjutnya.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>