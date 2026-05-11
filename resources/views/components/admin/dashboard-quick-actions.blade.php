@props(['pendingApplicants', 'finishedInternsCount'])

<div class="space-y-4 relative">
    <div class="px-1 py-0.5 flex items-center justify-between">
        <h3 class="text-sm font-black text-slate-800 dark:text-slate-200 tracking-tight uppercase">Penting</h3>
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
        </div>
        <div class="mt-5 py-2.5 w-full bg-amber-500/10 hover:bg-amber-500 text-amber-600 hover:text-white rounded-xl text-[10px] font-black uppercase tracking-widest text-center border border-amber-500/20 hover:border-amber-500 transition-all duration-300 shadow-sm group-hover:shadow-amber-500/20 group-hover:shadow-lg">Tinjau Sekarang</div>
    </a>
</div>
