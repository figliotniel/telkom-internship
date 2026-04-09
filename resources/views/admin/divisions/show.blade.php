<x-app-layout>
    <div class="p-6 lg:p-10 max-w-7xl mx-auto space-y-8 w-full flex-1">
        
        <!-- Header & Breadcrumbs -->
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-500 mb-4 font-medium">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-red-600 transition-colors">Dashboard</a>
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('admin.divisions.index') }}" class="hover:text-red-600 transition-colors">Master Divisi</a>
                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-slate-800 dark:text-slate-300">{{ $division->code ?? 'Detail' }}</span>
            </div>

            <div class="flex flex-col md:flex-row md:items-start justify-between gap-6">
                <!-- Title Section -->
                <div class="flex items-center gap-5">
                    @php
                        $colorIndex = $division->id % 6;
                        $colorSchemes = [
                            ['bg' => 'from-blue-50 to-blue-100 dark:from-blue-500/20 dark:to-cyan-500/10', 'text' => 'text-blue-600 dark:text-blue-400'],
                            ['bg' => 'from-emerald-50 to-emerald-100 dark:from-emerald-500/20 dark:to-teal-500/10', 'text' => 'text-emerald-600 dark:text-emerald-400'],
                            ['bg' => 'from-purple-50 to-purple-100 dark:from-purple-500/20 dark:to-fuchsia-500/10', 'text' => 'text-purple-600 dark:text-purple-400'],
                            ['bg' => 'from-amber-50 to-amber-100 dark:from-amber-500/20 dark:to-orange-500/10', 'text' => 'text-amber-600 dark:text-amber-400'],
                            ['bg' => 'from-rose-50 to-rose-100 dark:from-rose-500/20 dark:to-pink-500/10', 'text' => 'text-rose-600 dark:text-rose-400'],
                            ['bg' => 'from-indigo-50 to-indigo-100 dark:from-indigo-500/20 dark:to-blue-500/10', 'text' => 'text-indigo-600 dark:text-indigo-400']
                        ];
                        $scheme = $colorSchemes[$colorIndex];
                    @endphp
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $scheme['bg'] }} {{ $scheme['text'] }} flex items-center justify-center font-black text-xl shadow-inner ring-1 ring-white/50 dark:ring-white/5 relative overflow-hidden shrink-0">
                        <span>{{ $division->code ?? substr($division->name, 0, 2) }}</span>
                    </div>
                    <div>
                        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ $division->name }}</h2>
                        <p class="text-slate-500 dark:text-slate-400 mt-1 text-sm font-medium">Informasi Divisi dan daftar Mahasiswa Magang di dalamnya.</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap items-center gap-3">
                    <button onclick="openEditModal()" class="px-4 py-2 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition-all font-bold text-sm shadow-sm active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit Divisi
                    </button>

                    <form action="{{ route('admin.divisions.destroy', $division->id) }}" method="POST" class="m-0">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete(this)" class="px-4 py-2 bg-white dark:bg-slate-800 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/50 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/30 transition-all font-bold text-sm shadow-sm active:scale-95 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-[0_2px_20px_-3px_rgba(0,0,0,0.05)] dark:shadow-none border border-slate-100 dark:border-slate-800 overflow-hidden" x-data="{ currentFilter: 'all' }">
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row gap-4 justify-between md:items-center bg-slate-50/50 dark:bg-transparent transition-colors">
                <div class="flex items-center gap-4">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200">Daftar Intern</h3>
                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold text-xs rounded-lg border border-slate-200 dark:border-slate-700">Total: {{ $division->internships->count() }}</span>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-1.5 p-1 bg-slate-100 dark:bg-slate-800/80 rounded-xl border border-slate-200 dark:border-slate-700 shadow-inner">
                    <button @click="currentFilter = 'all'" :class="{'bg-white dark:bg-slate-700 shadow text-slate-800 dark:text-white ring-1 ring-slate-200 dark:ring-slate-600': currentFilter === 'all', 'text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-300': currentFilter !== 'all'}" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 focus:outline-none">Semua</button>
                    <button @click="currentFilter = 'active'" :class="{'bg-emerald-500 shadow-md shadow-emerald-500/20 text-white': currentFilter === 'active', 'text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400': currentFilter !== 'active'}" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 focus:outline-none">Active</button>
                    <button @click="currentFilter = 'onboarding'" :class="{'bg-amber-500 shadow-md shadow-amber-500/20 text-white': currentFilter === 'onboarding', 'text-slate-500 hover:text-amber-600 dark:text-slate-400 dark:hover:text-amber-400': currentFilter !== 'onboarding'}" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 flex items-center gap-1.5 focus:outline-none">
                        Onboarding
                        @if($division->internships->whereIn('status', ['pending','onboarding'])->count() > 0)
                            <span class="flex h-2 w-2 relative flex-shrink-0"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span></span>
                        @endif
                    </button>
                    <button @click="currentFilter = 'finished'" :class="{'bg-blue-500 shadow-md shadow-blue-500/20 text-white': currentFilter === 'finished', 'text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400': currentFilter !== 'finished'}" class="px-4 py-1.5 rounded-lg text-xs font-bold transition-all duration-200 focus:outline-none">Finished</button>
                </div>
            </div>

            <!-- The Grid Cards -->
            @if($division->internships->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                    @foreach($division->internships as $intern)
                        @php
                            // Menggabungkan pending dan onboarding ke satu filter UI
                            $renderStatus = in_array($intern->status, ['pending', 'onboarding']) ? 'onboarding' : $intern->status;
                        @endphp
                        <div x-show="currentFilter === 'all' || currentFilter === '{{ $renderStatus }}'" 
                             x-transition.opacity.duration.300ms
                             class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 relative overflow-hidden group hover:border-red-300 dark:hover:border-red-900/50 hover:shadow-xl hover:shadow-red-900/5 transition-all duration-300 hover:-translate-y-1 cursor-pointer" onclick="window.location='{{ route('admin.internships.show', $intern->id) }}'">
                            
                            <!-- Status Badge -->
                            <div class="absolute top-0 right-0 p-4">
                                @if($intern->status === 'active')
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold tracking-widest bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20 uppercase">ACTIVE</span>
                                @elseif(in_array($intern->status, ['pending', 'onboarding']))
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold tracking-widest bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-500 border border-amber-200 dark:border-amber-500/20 uppercase">{{ $intern->status }}</span>
                                @elseif($intern->status === 'finished')
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold tracking-widest bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-500/20 uppercase">FINISHED</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold tracking-widest bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 uppercase">{{ $intern->status }}</span>
                                @endif
                            </div>
                            
                            <!-- Profile Header -->
                            <div class="flex items-center gap-4 mb-5 mt-1 pr-20"> <!-- Padding right to prevent overlapping with status badge -->
                                <div class="relative flex-shrink-0">
                                    @if($intern->student && $intern->student->studentProfile && $intern->student->studentProfile->photo)
                                        <img src="{{ asset('storage/' . $intern->student->studentProfile->photo) }}" class="w-12 h-12 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm object-cover ring-2 ring-white dark:ring-slate-900">
                                    @else
                                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-900 flex items-center justify-center font-bold text-xl text-slate-600 dark:text-slate-300 ring-2 ring-white dark:ring-slate-900 shadow-sm border border-slate-200 dark:border-slate-800">
                                            {{ substr(optional($intern->student)->name ?? 'U', 0, 1) }}
                                        </div>
                                    @endif

                                    <!-- Online Dot -->
                                    @if($intern->status === 'active')
                                        <span class="absolute -bottom-1 -right-1 block h-3.5 w-3.5 rounded-full ring-4 ring-white dark:ring-slate-900 bg-emerald-500"></span>
                                    @elseif($intern->status === 'finished')
                                        <span class="absolute -bottom-1 -right-1 block h-3.5 w-3.5 rounded-full ring-4 ring-white dark:ring-slate-900 bg-blue-500"></span>
                                    @endif
                                </div>
                                
                                <div class="min-w-0"> <!-- min-w-0 fixes flex child truncation -->
                                    <h3 class="font-bold text-slate-900 dark:text-white text-base leading-tight group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors truncate" title="{{ optional($intern->student)->name ?? 'Unknown Student' }}">{{ optional($intern->student)->name ?? 'Unknown Student' }}</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 truncate" title="{{ optional($intern->student)->email ?? 'no-email@test.com' }}">{{ optional($intern->student)->email ?? 'no-email@test.com' }}</p>
                                </div>
                            </div>
                            
                            <!-- Info Box -->
                            <div class="space-y-3 bg-slate-50 dark:bg-slate-800/50 rounded-xl p-3.5 border border-slate-100 dark:border-slate-800/80">
                                <div class="flex items-center text-xs">
                                    <div class="w-6 h-6 rounded lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center mr-2.5 text-slate-500 dark:text-slate-400 shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <span class="text-slate-600 dark:text-slate-300 truncate">Mentor: <span class="font-bold text-slate-900 dark:text-slate-100">{{ optional($intern->mentor)->name ?? '-' }}</span></span>
                                </div>
                                <div class="flex items-center text-xs">
                                    <div class="w-6 h-6 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center mr-2.5 text-slate-500 dark:text-slate-400 shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <span class="text-slate-600 dark:text-slate-300 font-medium">
                                        {{ \Carbon\Carbon::parse($intern->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($intern->end_date)->format('d M y') }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Action footer -->
                            <div class="mt-4 flex justify-end">
                                <span class="text-[11px] font-bold text-slate-400 group-hover:text-red-600 dark:group-hover:text-red-400 flex items-center gap-1 transition-colors uppercase tracking-wider">
                                    Lihat Detail
                                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="px-6 py-20 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800/50 rounded-full flex items-center justify-center mb-5 ring-1 ring-slate-100 dark:ring-slate-800 shadow-sm border border-white dark:border-slate-700">
                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <p class="font-bold text-slate-600 dark:text-slate-300 text-lg">Belum ada peserta magang.</p>
                        <p class="text-sm text-slate-400 mt-1 max-w-sm mx-auto">Siswa atau Mahasiswa yang didaftarkan ke divisi ini akan muncul di sini sebagai kartu profil tersendiri.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- MODAL EDIT DIVISI (Hides automatically, powered by JS) -->
    <div id="editDivisionModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-2xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.3)] dark:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.7)] transform scale-95 transition-all duration-300 border border-slate-200 dark:border-slate-700/60 overflow-hidden" id="editDivisionModalContent">
            
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/50">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Edit Data Divisi</h3>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-full p-1.5 shadow-sm border border-slate-200 dark:border-slate-700 transition-colors focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6">
                <form method="POST" action="{{ route('admin.divisions.update', $division->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-5">
                        <div class="relative">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Kode Divisi <span class="text-red-500">*</span></label>
                            <input type="text" name="code" value="{{ $division->code }}" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-500 hover:border-slate-300 dark:hover:border-slate-600 transition-all uppercase placeholder:normal-case shadow-sm h-11">
                        </div>
                        
                        <div class="relative">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Nama Divisi Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ $division->name }}" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-500 hover:border-slate-300 dark:hover:border-slate-600 transition-all shadow-sm h-11">
                        </div>
                        
                        <div class="relative">
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Kepala Mentor <span class="text-slate-500 font-normal">(Opsional)</span></label>
                            <select name="mentor_id" class="w-full px-4 py-2.5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-500 hover:border-slate-300 dark:hover:border-slate-600 transition-all shadow-sm h-11 appearance-none">
                                <option value="">-- Tanpa Kepala Mentor --</option>
                                @foreach($mentors as $mentor)
                                    <option value="{{ $mentor->id }}" {{ $division->mentor_id == $mentor->id ? 'selected' : '' }}>{{ $mentor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-8 pt-5 border-t border-slate-100 dark:border-slate-800 flex gap-3 flex-row-reverse">
                        <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all font-bold text-sm shadow-[0_4px_10px_rgba(220,38,38,0.3)] active:scale-95 flex-1 md:flex-none text-center focus:outline-none focus:ring-2 focus:ring-red-500/50">Perbarui Data</button>
                        <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 font-bold text-sm transition-all shadow-sm active:scale-95 flex-1 md:flex-none text-center focus:outline-none focus:ring-2 focus:ring-slate-500/50">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const modal = document.getElementById('editDivisionModal');
        const content = document.getElementById('editDivisionModalContent');

        function openEditModal() {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }

        function closeEditModal() {
            modal.classList.add('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
        }

        function confirmDelete(button) {
            Swal.fire({
                title: 'Hapus Divisi?',
                html: "Anda yakin ingin menghapus divisi <b>{{ addslashes($division->name) }}</b>?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    actions: 'flex gap-3 w-full justify-center mt-6',
                    confirmButton: 'px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    cancelButton: 'px-6 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold rounded-xl transition-all active:scale-95',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: {
                    popup: 'bg-white dark:bg-slate-800 rounded-xl border border-slate-100 dark:border-slate-700 shadow-lg',
                    title: 'text-slate-800 dark:text-slate-200 text-sm font-bold',
                }
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400 mt-2',
                    actions: 'mt-6',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: '<ul class="text-left text-sm space-y-1">@foreach ($errors->all() as $error)<li>- {{ $error }}</li>@endforeach</ul>',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
                    actions: 'mt-6',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
            });
        @endif
    </script>
    @endpush
</x-app-layout>
