<x-app-layout>
    {{-- Dashboard Main Area (New Layout Structure Matching HTML Reference) --}}
    <div class="p-6 lg:p-10 max-w-7xl mx-auto space-y-10 w-full flex-1">
        
        {{-- Welcome Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Selamat Datang, {{ Auth::user()->name }} 👋</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Berikut ringkasan hari ini, {{ \Carbon\Carbon::now()->translatedFormat('l, d M Y') }}.</p>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="openAddMentorModal()" class="px-5 py-2.5 bg-red-600 dark:bg-red-600 text-white rounded-xl hover:bg-red-700 dark:hover:bg-red-700 transition-all font-semibold text-sm shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] active:scale-95 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Mentor
                </button>
            </div>
        </div>

        {{-- 1. Stats Grid (Elevasi, Hierarki Tipografi, Hover, Aksen Ikon) 
             Using grid-cols-1 md:grid-cols-3 since the HTML reference 4-columns layout drops the 4th item (Logbook Rate) per your instruction 
        --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            {{-- Stat 1: Total Interns --}}
            <div class="flex flex-col group p-6 rounded-[2rem] border transition-all duration-500 hover:scale-[1.03] hover-glint glass-card-light dark:bg-slate-900 border-red-500/30 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-400 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="flex items-start justify-between mb-2">
                    <div class="relative z-10 text-left">
                        <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Total Siswa/Mahasiswa</p>
                        <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">{{ $totalStudents }}</h3>
                    </div>
                    <div class="p-4 bg-red-500/10 dark:bg-red-500/10 rounded-2xl text-[#ed1e28] dark:text-red-400 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 border border-red-500/20 relative z-10 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                
                <div class="mt-4 flex items-center text-sm relative z-10">
                    @if($studentGrowth > 0)
                        <span class="flex items-center text-emerald-600 dark:text-emerald-400 font-black bg-emerald-500/10 px-2.5 py-1 rounded-lg text-[10px] border border-emerald-500/20 shadow-sm uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            +{{ $studentGrowth }} Baru
                        </span>
                        <span class="text-slate-400 dark:text-slate-500 ml-2 text-[10px] font-bold uppercase tracking-wider">Bulan ini</span>
                    @else
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-md">Data stabil</span>
                    @endif
                </div>
                <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="absolute inset-0 z-20 focus:outline-none"></a>
            </div>

            {{-- Stat 2: Active Interns --}}
            <div class="flex flex-col group p-6 rounded-[2rem] border transition-all duration-500 hover:scale-[1.03] hover-glint glass-card-light dark:bg-slate-900 border-emerald-500/30 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="flex items-start justify-between mb-2">
                    <div class="relative z-10 text-left">
                        <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Peserta Aktif</p>
                        <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">{{ $activeInternships }}</h3>
                    </div>
                    <div class="p-4 bg-emerald-500/10 dark:bg-emerald-500/10 rounded-2xl text-emerald-600 dark:text-emerald-400 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 border border-emerald-500/20 relative z-10 shadow-sm">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                
                <div class="mt-4 flex items-center relative z-10">
                    <span class="flex items-center text-emerald-600 dark:text-emerald-400 font-black bg-emerald-500/10 px-3 py-1 rounded-lg text-[10px] border border-emerald-500/20 shadow-sm uppercase tracking-wider">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse mr-2 shadow-[0_0_8px_#10b981]"></div>
                        Sedang Aktif
                    </span>
                </div>
                <a href="{{ route('admin.internships.index', ['status' => 'active']) }}" class="absolute inset-0 z-20 focus:outline-none"></a>
            </div>

            {{-- Stat 3: Total Mentors --}}
            <div class="flex flex-col group p-6 rounded-[2rem] border transition-all duration-500 hover:scale-[1.03] hover-glint glass-card-light dark:bg-slate-900 border-blue-500/30 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <div class="flex items-start justify-between mb-2">
                    <div class="relative z-10 text-left">
                        <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1.5">Total Mentor</p>
                        <h3 class="text-4xl font-black text-slate-800 dark:text-white tracking-tight">{{ $totalMentors }}</h3>
                    </div>
                    <div class="p-4 bg-blue-500/10 dark:bg-blue-500/10 rounded-2xl text-blue-600 dark:text-blue-400 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-500 border border-blue-500/20 relative z-10 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
                
                <div class="mt-4 flex items-center text-sm relative z-10">
                    @if($mentorGrowth > 0)
                        <span class="flex items-center text-blue-600 dark:text-blue-400 font-black bg-blue-500/10 px-2.5 py-1 rounded-lg text-[10px] border border-blue-500/20 shadow-sm uppercase tracking-wider">
                            <svg class="w-3.5 h-3.5 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            {{ $mentorGrowth }} Baru
                        </span>
                        <span class="text-slate-400 dark:text-slate-500 ml-2 text-[10px] font-bold uppercase tracking-wider">Bulan ini</span>
                    @else
                        <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-md">Data stabil</span>
                    @endif
                </div>
                 <a href="{{ route('admin.users.index', ['role' => 'mentor']) }}" class="absolute inset-0 z-20 focus:outline-none"></a>
            </div>

        </div>

        {{-- 2. Content Sections Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left: Recent Activities (2 columns wide) --}}
            <div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] dark:shadow-none border border-slate-100 dark:border-slate-800">
                <div class="px-7 py-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-transparent relative z-10">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Pendaftaran Magang Terbaru</h3>
                    <a href="{{ route('admin.internships.index') }}" class="text-sm font-semibold text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 flex items-center gap-1 group">
                        Lihat Semua
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="divide-y divide-slate-100/80 dark:divide-slate-800/80 custom-scrollbar">
                    @forelse($recentInternships as $internship)
                    <div class="px-7 py-6 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between group cursor-pointer {{ $loop->last ? 'rounded-b-2xl' : '' }}" onclick="window.location='{{ route('admin.internships.show', $internship->id) }}'">
                        
                        <div class="flex items-center gap-4">
                            <div class="relative flex-shrink-0">
                                @if($internship->student->studentProfile && $internship->student->studentProfile->photo)
                                    <img src="{{ asset('storage/' . $internship->student->studentProfile->photo) }}" class="w-11 h-11 rounded-full border-2 border-white dark:border-slate-800 shadow-sm object-cover">
                                @else
                                    <div class="w-11 h-11 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold border-2 border-white dark:border-slate-800 shadow-sm">
                                        {{ substr(optional($internship->student)->name ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                                
                                @if($internship->status == 'active')
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white dark:border-slate-800 rounded-full"></div>
                                @elseif($internship->status == 'pending')
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-amber-500 border-2 border-white dark:border-slate-800 rounded-full"></div>
                                @elseif($internship->status == 'finished')
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-blue-500 border-2 border-white dark:border-slate-800 rounded-full"></div>
                                @else
                                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-slate-300 dark:bg-slate-600 border-2 border-white dark:border-slate-800 rounded-full"></div>
                                @endif
                            </div>
                            
                            <div class="flex flex-col">
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-200 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">
                                    {{ optional($internship->student)->name ?? 'Pengguna Tidak Dikenal' }}
                                    <span class="text-slate-400 dark:text-slate-500 font-medium ml-1">
                                        @if($internship->status == 'active') aktif @elseif($internship->status == 'pending') mendaftar @else berada di @endif
                                    </span>
                                </p>
                                <p class="text-xs text-slate-500 mt-0.5 font-medium">Divisi {{ $internship->division->name ?? '-' }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-2 sm:mt-0 flex sm:flex-col items-center sm:items-end justify-between sm:justify-center w-full sm:w-auto pl-15 sm:pl-0">
                             <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] sm:hidden font-bold border shadow-sm transition-colors uppercase tracking-wider
                                    {{ $internship->status == 'active' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800/50' : 
                                        ($internship->status == 'pending' ? 'bg-red-50 dark:bg-red-500/10 text-[#ed1e28] dark:text-red-400 border-red-200 dark:border-red-800/50' : 
                                        ($internship->status == 'finished' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-200 dark:border-blue-800/50' : 'bg-slate-50 dark:bg-slate-800/50 text-slate-600 dark:text-slate-400 border-slate-200 dark:border-slate-700/50')) }}">
                                    {{ $internship->status }}
                             </span>
                            <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">
                                {{ $internship->created_at ? $internship->created_at->diffForHumans() : '-' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="px-7 py-12 text-center">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-2">
                                <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <p class="text-sm font-bold text-slate-500 dark:text-slate-400">Tidak ada aktivitas terbaru.</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Right: Quick Actions / Need Attention (Vertical HUD Sidebar Hub) -->
            <div class="space-y-4 relative">
                <div class="px-1 py-0.5 flex items-center justify-between">
                    <h3 class="text-sm font-black text-slate-800 dark:text-slate-200 tracking-tight uppercase">Perlu Perhatian</h3>
                    <div class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></div>
                </div>

                <!-- CARD 1: PENDING APPLICANTS -->
                <a href="{{ $pendingApplicants > 0 ? route('admin.internships.index', ['status' => 'pending']) : '#' }}" 
                   class="flex flex-col group p-5 rounded-[2rem] border transition-all duration-500 hover:scale-[1.03] hover-glint {{ $pendingApplicants > 0 ? 'glass-card-light dark:bg-slate-900 border-red-500/30' : 'bg-slate-50 dark:bg-slate-900 border-slate-100 dark:border-slate-800 opacity-60' }}">
                    <div class="flex items-start justify-between mb-4">
                        <div class="p-3 rounded-2xl bg-red-500/10 border border-red-500/20 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 {{ $pendingApplicants > 0 ? 'animate-float' : '' }}">
                            <svg class="w-5 h-5 text-[#ed1e28]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 01-9-3.876m5.94-2.285A6.707 6.707 0 0121 8.252"></path></svg>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 bg-red-500/10 text-[#ed1e28] dark:text-red-400 text-[9px] font-black rounded-lg border border-red-500/20 uppercase tracking-widest shadow-sm">{{ $pendingApplicants }} Menunggu</span>
                            @if($pendingApplicants > 0) <div class="w-1.5 h-1.5 rounded-full bg-[#ed1e28] animate-pulse shadow-[0_0_10px_#ed1e28]"></div> @endif
                        </div>
                    </div>
                    <div class="space-y-0.5">
                        <h3 class="font-black text-base uppercase tracking-tight text-slate-900 dark:text-white group-hover:text-[#ed1e28] transition-colors">Pusat Pendaftaran</h3>
                        <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 leading-relaxed">Otorisasi akses diperlukan untuk node baru.</p>
                    </div>
                    <div class="mt-5 py-2.5 w-full bg-red-500/10 hover:bg-[#ed1e28] text-[#ed1e28] hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest text-center border border-red-500/20 hover:border-[#ed1e28] transition-all duration-300 shadow-sm group-hover:shadow-red-500/20 group-hover:shadow-lg">Tinjau Pendaftar</div>
                </a>

                <!-- CARD 2: FINISHED INTERNSHIPS -->
                <a href="{{ $finishedInternsCount > 0 ? route('admin.internships.index', ['status' => 'finished']) : '#' }}" 
                   class="flex flex-col group p-5 rounded-[2rem] border transition-all duration-500 hover:scale-[1.03] hover-glint {{ $finishedInternsCount > 0 ? 'glass-card-light dark:bg-slate-900 border-blue-500/30' : 'bg-slate-50 dark:bg-slate-900 border-slate-100 dark:border-slate-800 opacity-60' }}">
                    <div class="flex items-start justify-between mb-4">
                        <div class="p-3 rounded-2xl bg-blue-500/10 border border-blue-500/20 group-hover:scale-110 group-hover:-rotate-6 transition-all duration-500 {{ $finishedInternsCount > 0 ? 'animate-float' : '' }}" style="animation-delay: 0.5s">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path></svg>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 bg-blue-500/10 text-blue-600 dark:text-blue-400 text-[9px] font-black rounded-lg border border-blue-500/20 uppercase tracking-widest shadow-sm">{{ $finishedInternsCount }} Berakhir</span>
                            @if($finishedInternsCount > 0) <div class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse shadow-[0_0_10px_#3b82f6]"></div> @endif
                        </div>
                    </div>
                    <div class="space-y-0.5">
                        <h3 class="font-black text-base uppercase tracking-tight text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors">Proses Pengarsipan</h3>
                        <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 leading-relaxed">Pengarsipan sertifikat digital telah siap.</p>
                    </div>
                    <div class="mt-5 py-2.5 w-full bg-blue-500/10 hover:bg-blue-600 text-blue-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest text-center border border-blue-500/20 hover:border-blue-600 transition-all duration-300 shadow-sm group-hover:shadow-blue-500/20 group-hover:shadow-lg">Siapkan Dokumen</div>
                </a>

                <!-- CARD 3: EXTENSIONS -->
                <a href="{{ route('admin.internships.index', ['status' => 'extension']) }}" 
                   class="flex flex-col group p-5 rounded-[2rem] border transition-all duration-500 hover:scale-[1.03] hover-glint glass-card-light dark:bg-slate-900 border-amber-500/30">
                    <div class="flex items-start justify-between mb-4">
                        <div class="p-3 rounded-2xl bg-amber-500/10 border border-amber-500/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 animate-float" style="animation-delay: 1s">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="flex items-center gap-2">
                             <span class="px-2.5 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[9px] font-black rounded-lg border border-amber-500/20 uppercase tracking-widest shadow-sm">10 REQ</span>
                             <div class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse shadow-[0_0_10px_#f59e0b]"></div>
                        </div>
                    </div>
                    <div class="space-y-0.5">
                        <h3 class="font-black text-base uppercase tracking-tight text-slate-900 dark:text-white group-hover:text-amber-600 transition-colors">Perpanjangan</h3>
                        <p class="text-[10px] font-bold text-slate-500 dark:text-slate-400 leading-relaxed">Permintaan perpanjangan masa magang terdeteksi.</p>
                        <div class="mt-5 py-2.5 w-full bg-amber-500/10 hover:bg-amber-500 text-amber-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest text-center border border-amber-500/20 hover:border-amber-500 transition-all duration-300 shadow-sm group-hover:shadow-amber-500/20 group-hover:shadow-lg">Tinjau Sekarang</div>
                    </div>
                </a>
            </div>
        </div>
    </div>

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

    @push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }

        /* PREMIUM GLINT & ANIMATION EFFECTS */
        .glass-card-light {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
        }
        
        .hover-glint {
            position: relative;
            overflow: hidden;
        }
        
        .hover-glint::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0) 40%,
                rgba(255, 255, 255, 0.4) 50%,
                rgba(255, 255, 255, 0) 60%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(45deg);
            transition: all 0.7s;
            opacity: 0;
            pointer-events: none;
        }
        
        .hover-glint:hover::after {
            left: 100%;
            top: 100%;
            opacity: 1;
        }

        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0px); }
        }
        .animate-float { animation: floating 3s ease-in-out infinite; }
    </style>
    @endpush

    @push('scripts')
    <script>
        const addMentorModal = document.getElementById('addMentorModal');
        const addMentorModalContent = document.getElementById('addMentorModalContent');

        function openAddMentorModal() {
            addMentorModal.classList.remove('opacity-0', 'pointer-events-none');
            addMentorModalContent.classList.remove('scale-95');
            addMentorModalContent.classList.add('scale-100');
        }

        function closeAddMentorModal() {
            addMentorModal.classList.add('opacity-0', 'pointer-events-none');
            addMentorModalContent.classList.remove('scale-100');
            addMentorModalContent.classList.add('scale-95');
        }

        function showInfoModal(title, text) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'info',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
            });
        }
    </script>
    @endpush
</x-app-layout>