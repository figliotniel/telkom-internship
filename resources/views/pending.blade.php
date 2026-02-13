<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Status Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Status Card --}}
            @if(isset($internship) && $internship->status == 'onboarding')
                @php
                    $suratJawaban = $internship->documents->where('type', 'surat_jawaban')->first();
                    $paktaTemplate = $internship->documents->where('type', 'pakta_integritas')->first();
                    $signedPact = $internship->documents->where('type', 'pakta_integritas_signed')->first();
                @endphp

                {{-- ONBOARDING STATE --}}
                <div class="max-w-4xl mx-auto bg-white border border-emerald-100 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                    
                    <div class="p-10 text-center">
                        {{-- Icon Check --}}
                        <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-12 h-12 text-emerald-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>
                        
                        <h3 class="text-3xl font-bold text-gray-900 mb-3 tracking-tight">Selamat Datang di Telkom Internship!</h3>
                        <p class="text-gray-500 max-w-lg mx-auto mb-10 text-lg leading-relaxed">
                            Pengajuan magang Anda telah diterima (Onboarding). Silakan ikuti langkah-langkah berikut untuk aktivasi akun sepenuhnya.
                        </p>

                        {{-- Division & Mentor Info Card --}}
                        <div class="bg-indigo-50/60 border border-indigo-100 rounded-2xl p-8 mb-8 max-w-3xl mx-auto relative text-left">
                            <div class="absolute top-0 left-12 -translate-y-1/2 bg-white border border-indigo-100 px-4 py-1 rounded-full text-xs font-bold text-indigo-600 uppercase tracking-wider shadow-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Informasi Penempatan
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-2">
                                <div>
                                    <p class="text-xs text-indigo-400 uppercase font-bold tracking-wider mb-1">Divisi</p>
                                    <p class="font-bold text-gray-900 text-xl">{{ $internship->division->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-indigo-400 uppercase font-bold tracking-wider mb-1">Mentor</p>
                                    <p class="font-bold text-gray-900 text-xl">{{ $internship->mentor->name ?? '-' }}</p>
                                </div>
                            </div>
                            
                            {{-- Important Note --}}
                            <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <div>
                                    <p class="font-bold text-yellow-800 text-sm mb-1">PENTING</p>
                                    <p class="text-yellow-700 text-sm">Mohon pastikan Anda mengisi <strong>Divisi: <span class="text-yellow-900 font-extrabold">{{ $internship->division->name ?? '...' }}</span></strong> pada dokumen Pakta Integritas yang akan Anda unggah.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Action Area --}}
                        @if($signedPact)
                             {{-- Signed State --}}
                            <div class="bg-blue-50 border border-blue-100 text-blue-800 px-8 py-6 rounded-2xl max-w-3xl mx-auto flex flex-col items-center justify-center">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h4 class="font-bold text-lg mb-1">Menunggu Verifikasi Admin</h4>
                                <p class="text-blue-600/80">Anda telah mengunggah Pakta Integritas. Admin sedang memverifikasi dokumen Anda.</p>
                            </div>
                        @else
                             {{-- Upload State --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-4xl mx-auto text-left">
                                {{-- Step 1 --}}
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-md transition-all duration-300">
                                    <h4 class="font-bold text-gray-900 mb-5 flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold">1</span>
                                        Unduh Dokumen
                                    </h4>
                                    <div class="space-y-4">
                                        @if($suratJawaban)
                                            <a href="{{ Storage::url($suratJawaban->file_path) }}" target="_blank" class="flex items-center p-4 bg-white rounded-xl border border-gray-100 hover:border-emerald-300 hover:shadow-sm transition-all group">
                                                <div class="w-10 h-10 rounded-lg bg-red-50 text-red-500 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-800 text-sm group-hover:text-emerald-700">Surat Jawaban</p>
                                                    <p class="text-xs text-gray-400">Penerimaan Magang</p>
                                                </div>
                                            </a>
                                        @endif

                                        @if($paktaTemplate)
                                             @php
                                                $isUrl = Str::startsWith($paktaTemplate->file_path, ['http://', 'https://']);
                                                $paktaLink = $isUrl ? $paktaTemplate->file_path : Storage::url($paktaTemplate->file_path);
                                            @endphp
                                            <a href="{{ $paktaLink }}" target="_blank" class="flex items-center p-4 bg-white rounded-xl border border-gray-100 hover:border-emerald-300 hover:shadow-sm transition-all group">
                                                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-800 text-sm group-hover:text-emerald-700">Template Pakta Integritas</p>
                                                    <p class="text-xs text-gray-400">{{ $isUrl ? 'Google Docs / PDF' : 'Unduh File' }}</p>
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                {{-- Step 2 --}}
                                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-md transition-all duration-300">
                                    <h4 class="font-bold text-gray-900 mb-5 flex items-center gap-3">
                                        <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold">2</span>
                                        Upload Pakta Integritas
                                    </h4>
                                    
                                    <form action="{{ route('documents.storePaktaIntegritas') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">File Ditandatangani</label>
                                            <input type="file" name="file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors">
                                            <p class="text-xs text-gray-400 mt-2 ml-1">Format: PDF, Maks 5MB</p>
                                        </div>
                                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-emerald-200 hover:shadow-emerald-300 transition-all transform hover:-translate-y-0.5">
                                            Kirim Dokumen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            @elseif(isset($internship) && $internship->status == 'rejected')
                {{-- REJECTED STATE (QUOTA FULL) --}}
                <div class="max-w-4xl mx-auto bg-white border border-red-100 rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden relative">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-400 to-pink-500"></div>
                    
                    <div class="p-10 text-center">
                        {{-- Icon --}}
                        <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 text-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm6.75-.75c-.207 0-.375.336-.375.75s.168.75.375.75.375-.336.375-.75-.168-.75-.375-.75z" />
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-4 tracking-tight">Mohon Maaf, Kuota Magang Penuh</h3>
                        
                        <div class="max-w-2xl mx-auto space-y-4 text-gray-600 leading-relaxed">
                            <p>
                                Terima kasih atas antusiasme Anda untuk bergabung dengan Telkom Internship. 
                                Namun, dengan berat hati kami sampaikan bahwa saat ini <strong>kuota magang untuk posisi/lokasi yang Anda tuju sudah terpenuhi</strong>.
                            </p>
                            
                            {{-- Encouraging Message --}}
                            <div class="bg-orange-50/50 border border-orange-100 rounded-2xl p-6 mt-6">
                                <h4 class="font-bold text-orange-800 mb-2 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Tetap Semangat!
                                </h4>
                                <p class="text-gray-600 text-sm">
                                    Keputusan ini semata-mata karena keterbatasan tempat dan <strong>bukan cerminan kemampuan Anda</strong>. 
                                    Profil Anda sangat potensial! Jangan berkecil hati, teruslah belajar, berkarya, dan silakan mencoba kembali di kesempatan berikutnya.
                                </p>
                            </div>
                        </div>

                        @if($internship->response_letter)
                            <div class="mt-8">
                                <a href="{{ Storage::url($internship->response_letter) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-white border border-gray-200 rounded-xl font-semibold text-gray-700 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all shadow-sm group">
                                    <svg class="w-5 h-5 mr-2 text-gray-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Lihat Surat Penolakan Resmi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            @else
                {{-- Default Pending/No Data --}}
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 shadow-sm rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            @if(!isset($internship))
                                <h3 class="text-sm font-medium text-yellow-800">Data Magang Belum Tersedia</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Akun Anda belum terdaftar dalam program magang aktif. Silakan hubungi Administrator.</p>
                                </div>
                            @elseif($internship->status == 'pending')
                                <h3 class="text-sm font-medium text-yellow-800">Menunggu Verifikasi</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Pengajuan magang Anda telah diterima dan sedang dalam proses verifikasi oleh Admin.</p>
                                    <p class="mt-1">Mohon cek email Anda secara berkala untuk info selanjutnya.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="mt-6 text-center">
                 <p class="text-gray-500 text-sm">Butuh bantuan?</p>
                 <a href="{{ route('help.index') }}" class="mt-1 inline-block text-indigo-600 hover:text-indigo-900 underline text-sm">
                     Hubungi Pusat Bantuan
                 </a>
            </div>
        </div>
    </div>
</x-app-layout>