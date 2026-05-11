@props(['recentInternships'])

<div class="lg:col-span-2 bg-white dark:bg-slate-900 rounded-2xl shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] dark:shadow-none border border-slate-100 dark:border-slate-800 flex flex-col" style="max-height: 554px;">
    <div class="px-7 py-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-transparent relative z-10 shrink-0">
        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Pendaftaran Magang Terbaru</h3>
        <a href="{{ route('admin.internships.index') }}" class="text-sm font-semibold text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 flex items-center gap-1 group">
            Lihat Semua
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>
    <div class="divide-y divide-slate-100/80 dark:divide-slate-800/80 custom-scrollbar flex-1 overflow-y-auto">
        @forelse($recentInternships as $internship)
        <div class="px-7 py-6 hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between group cursor-pointer {{ $loop->last ? 'rounded-b-2xl' : '' }}" onclick="window.location='{{ route('admin.internships.show', $internship->id) }}'">
            
            <div class="flex items-center gap-4">
                <div class="relative flex-shrink-0">
                    @if($internship->student->avatar_url)
                        <img src="{{ $internship->student->avatar_url }}" class="w-11 h-11 rounded-full border-2 border-white dark:border-slate-800 shadow-sm object-cover">
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
