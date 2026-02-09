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
                {{-- GREEN THEME FOR ONBOARDING --}}
                <div class="bg-gradient-to-br from-emerald-50 to-white border border-emerald-200 rounded-2xl p-8 shadow-sm text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-emerald-100/50 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mb-6 animate-bounce">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-emerald-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-emerald-900 mb-2">Selamat Datang di Telkom Internship!</h3>
                        <p class="text-emerald-700 max-w-lg mx-auto mb-6">
                            Pengajuan magang Anda telah diterima (Onboarding). Silakan unduh surat penerimaan di bawah ini dan tunggu instruksi selanjutnya dari Admin/Mentor untuk aktivasi akun sepenuhnya.
                        </p>

                        @if($internship->response_letter)
                            <a href="{{ Storage::url($internship->response_letter) }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-emerald-600/20 transition-all duration-300 transform hover:-translate-y-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Unduh Surat Penerimaan Magang
                            </a>
                        @else
                            <div class="bg-yellow-50 text-yellow-800 px-4 py-2 rounded-lg text-sm border border-yellow-200">
                                Surat penerimaan sedang diproses oleh Admin. Silakan cek berkala.
                            </div>
                        @endif
                    </div>
                </div>

            @elseif(isset($internship) && $internship->status == 'rejected')
                 <div class="bg-red-50 border-l-4 border-red-400 p-6 shadow-sm rounded-r-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-red-800">Pengajuan Ditolak</h3>
                            <div class="mt-2 text-sm text-red-700 space-y-2">
                                <p>Mohon maaf, pengajuan magang Anda belum dapat diterima saat ini.</p>
                                @if($internship->response_letter)
                                    <a href="{{ Storage::url($internship->response_letter) }}" target="_blank" class="text-red-900 font-semibold underline hover:text-red-950">
                                        Lihat Surat Penolakan
                                    </a>
                                @endif
                            </div>
                        </div>
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