<x-app-layout>
    <div class="p-6 lg:p-10 max-w-7xl mx-auto space-y-8 w-full">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div>
                <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Master Divisi</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2 text-sm md:text-base">Kelola daftar unit/divisi kerja untuk penempatan mentor dan peserta magang.</p>
            </div>
            <div>
                <button onclick="openModal('add')" class="px-5 py-2.5 bg-red-600 dark:bg-red-600 text-white rounded-xl hover:bg-red-700 dark:hover:bg-red-700 transition-all font-semibold text-sm shadow-[0_4px_14px_0_rgba(220,38,38,0.39)] hover:shadow-[0_6px_20px_rgba(220,38,38,0.23)] active:scale-95 flex items-center justify-center gap-2 w-full md:w-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Data Divisi
                </button>
            </div>
        </div>

        <!-- Search and Filter Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 relative z-10 mb-4 mt-8">
            <div class="relative w-full sm:w-80 group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400 group-focus-within:text-red-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <!-- Changed onkeyup to searchCards() -->
                <input type="text" id="searchInput" onkeyup="searchCards()" placeholder="Cari divisi..." class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all placeholder-slate-400 dark:placeholder-slate-500 shadow-sm">
            </div>
            <div class="text-sm font-bold text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                Total: <span class="text-slate-800 dark:text-slate-200">{{ $divisions->count() }} Divisi</span>
            </div>
        </div>

        <!-- Opsi A: Grid Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="divisionsContainer">
            @forelse($divisions as $division)
                @php
                    $colorIndex = $division->id % 6;
                    
                    // Pre-define full class strings so Tailwind's JIT compiler catches them
                    $colorSchemes = [
                        ['bg' => 'from-blue-50 to-blue-100 dark:from-blue-500/20 dark:to-cyan-500/10', 'text' => 'text-blue-600 dark:text-blue-400', 'textHover' => 'group-hover:text-blue-600 dark:group-hover:text-blue-400', 'border' => 'hover:border-blue-300 dark:hover:border-blue-700/50', 'shadow' => 'hover:shadow-blue-500/10', 'line' => 'bg-blue-500', 'navBg' => 'group-hover:bg-blue-100 dark:group-hover:bg-blue-500/20'],
                        ['bg' => 'from-emerald-50 to-emerald-100 dark:from-emerald-500/20 dark:to-teal-500/10', 'text' => 'text-emerald-600 dark:text-emerald-400', 'textHover' => 'group-hover:text-emerald-600 dark:group-hover:text-emerald-400', 'border' => 'hover:border-emerald-300 dark:hover:border-emerald-700/50', 'shadow' => 'hover:shadow-emerald-500/10', 'line' => 'bg-emerald-500', 'navBg' => 'group-hover:bg-emerald-100 dark:group-hover:bg-emerald-500/20'],
                        ['bg' => 'from-purple-50 to-purple-100 dark:from-purple-500/20 dark:to-fuchsia-500/10', 'text' => 'text-purple-600 dark:text-purple-400', 'textHover' => 'group-hover:text-purple-600 dark:group-hover:text-purple-400', 'border' => 'hover:border-purple-300 dark:hover:border-purple-700/50', 'shadow' => 'hover:shadow-purple-500/10', 'line' => 'bg-purple-500', 'navBg' => 'group-hover:bg-purple-100 dark:group-hover:bg-purple-500/20'],
                        ['bg' => 'from-amber-50 to-amber-100 dark:from-amber-500/20 dark:to-orange-500/10', 'text' => 'text-amber-600 dark:text-amber-400', 'textHover' => 'group-hover:text-amber-600 dark:group-hover:text-amber-400', 'border' => 'hover:border-amber-300 dark:hover:border-amber-700/50', 'shadow' => 'hover:shadow-amber-500/10', 'line' => 'bg-amber-500', 'navBg' => 'group-hover:bg-amber-100 dark:group-hover:bg-amber-500/20'],
                        ['bg' => 'from-rose-50 to-rose-100 dark:from-rose-500/20 dark:to-pink-500/10', 'text' => 'text-rose-600 dark:text-rose-400', 'textHover' => 'group-hover:text-rose-600 dark:group-hover:text-rose-400', 'border' => 'hover:border-rose-300 dark:hover:border-rose-700/50', 'shadow' => 'hover:shadow-rose-500/10', 'line' => 'bg-rose-500', 'navBg' => 'group-hover:bg-rose-100 dark:group-hover:bg-rose-500/20'],
                        ['bg' => 'from-indigo-50 to-indigo-100 dark:from-indigo-500/20 dark:to-blue-500/10', 'text' => 'text-indigo-600 dark:text-indigo-400', 'textHover' => 'group-hover:text-indigo-600 dark:group-hover:text-indigo-400', 'border' => 'hover:border-indigo-300 dark:hover:border-indigo-700/50', 'shadow' => 'hover:shadow-indigo-500/10', 'line' => 'bg-indigo-500', 'navBg' => 'group-hover:bg-indigo-100 dark:group-hover:bg-indigo-500/20']
                    ];
                    $scheme = $colorSchemes[$colorIndex];
                @endphp
                
                <div onclick="window.location='{{ route('admin.divisions.show', $division->id) }}'" class="cursor-pointer division-card bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-800 {{ $scheme['border'] }} hover:shadow-xl {{ $scheme['shadow'] }} transition-all duration-300 relative overflow-hidden group flex flex-col h-full hover:-translate-y-1">
                    <div class="absolute top-0 left-0 w-full h-1 {{ $scheme['line'] }} opacity-20 group-hover:opacity-100 transition-opacity"></div>
                    
                    <div class="flex justify-between items-start mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $scheme['bg'] }} {{ $scheme['text'] }} flex items-center justify-center font-black text-xl shadow-inner ring-1 ring-white/50 dark:ring-white/5 group-hover:scale-110 transition-transform duration-300">
                            <span class="div-code">{{ $division->code ?? substr($division->name, 0, 2) }}</span>
                        </div>
                        
                        <!-- Navigate icon -->
                        <div class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-400 {{ $scheme['navBg'] }} {{ $scheme['textHover'] }} transition-colors">
                            <svg class="w-4 h-4 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                    
                    <div class="flex-1 mb-6">
                        <h3 class="font-extrabold text-xl text-slate-800 dark:text-white leading-tight mb-2 {{ $scheme['textHover'] }} transition-colors div-name">{{ $division->name }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium leading-relaxed">Kepala Mentor: <br><span class="font-bold text-slate-700 dark:text-slate-300">{{ optional($division->mentor)->name ?? 'Belum ditentukan' }}</span></p>
                    </div>
                    
                    <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                        <div class="flex items-center gap-1.5 text-slate-500 dark:text-slate-400 text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Interns
                        </div>
                        <div class="inline-flex items-center justify-center px-2.5 py-1 rounded-md text-xs font-bold {{ $division->internships_count > 0 ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20' : 'bg-slate-100 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700/50' }} shadow-sm">
                            {{ $division->internships_count }} Aktif
                        </div>
                    </div>
                </div>

            @empty
                <div class="col-span-full py-16 flex flex-col items-center justify-center bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-300 dark:border-slate-700 w-full">
                    <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-1">Belum Ada Divisi</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-sm max-w-sm text-center">Silakan tekan tombol Tambah Data Divisi di pojok kanan atas untuk membuat divisi pertama Anda.</p>
                </div>
            @endforelse
        </div>

    </div>

    <!-- MODAL (Add & Edit) -->
    <div id="crudDivisionModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-2xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.3)] dark:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.7)] transform scale-95 transition-all duration-300 border border-slate-200 dark:border-slate-700/60 overflow-hidden" id="crudDivisionModalContent">
            
            <!-- Modal Header -->
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/50">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white" id="modalTitle">Tambah Data Divisi</h3>
                <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-full p-1.5 shadow-sm border border-slate-200 dark:border-slate-700 transition-colors focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <form id="divisionForm" method="POST" action="">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    
                    <div class="space-y-5">
                        <!-- Input Kode Divisi -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Kode Divisi <span class="text-red-500">*</span></label>
                            <input type="text" name="code" id="inputKode" required placeholder="e.g., BS, SSGS" class="w-full px-4 py-2.5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-500 hover:border-slate-300 dark:hover:border-slate-600 transition-all uppercase placeholder:normal-case shadow-sm h-11">
                            <p class="text-[11px] font-medium text-slate-500 dark:text-slate-400 mt-2">Gunakan singkatan maksimal 10 karakter.</p>
                        </div>
                        
                        <!-- Input Nama Divisi -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Nama Divisi Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="inputNama" required placeholder="e.g., Business Service" class="w-full px-4 py-2.5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-500 hover:border-slate-300 dark:hover:border-slate-600 transition-all shadow-sm h-11">
                        </div>
                        
                        <!-- Input Mentor Kepala -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Kepala Mentor Divisi <span class="text-slate-500 font-normal">(Opsional)</span></label>
                            <select name="mentor_id" id="inputMentor" class="w-full px-4 py-2.5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/30 focus:border-red-500 hover:border-slate-300 dark:hover:border-slate-600 transition-all shadow-sm h-11 appearance-none">
                                <option value="">-- Tanpa Kepala Mentor --</option>
                                @foreach($mentors as $mentor)
                                    <option value="{{ $mentor->id }}">{{ $mentor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="mt-8 pt-5 border-t border-slate-100 dark:border-slate-800 flex gap-3 flex-row-reverse">
                        <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all font-bold text-sm shadow-[0_4px_10px_rgba(220,38,38,0.3)] active:scale-95 flex-1 md:flex-none text-center focus:outline-none focus:ring-2 focus:ring-red-500/50">Simpan Data</button>
                        <button type="button" onclick="closeModal()" class="px-5 py-2.5 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 font-bold text-sm transition-all shadow-sm active:scale-95 flex-1 md:flex-none text-center focus:outline-none focus:ring-2 focus:ring-slate-500/50">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(mode, id = null, code = '', name = '', mentorId = '') {
            const modal = document.getElementById('crudDivisionModal');
            const content = document.getElementById('crudDivisionModalContent');
            const form = document.getElementById('divisionForm');
            
            const storeUrl = "{{ route('admin.divisions.store') }}";
            const updateUrlBase = "{{ url('admin/divisions') }}";

            modal.classList.remove('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
            
            if(mode === 'edit') {
                document.getElementById('modalTitle').innerText = 'Edit Data Divisi';
                document.getElementById('inputKode').value = code;
                document.getElementById('inputNama').value = name;
                document.getElementById('inputMentor').value = mentorId;
                
                form.action = updateUrlBase + '/' + id;
                document.getElementById('formMethod').value = "PUT";
            } else {
                document.getElementById('modalTitle').innerText = 'Tambah Data Divisi';
                document.getElementById('inputKode').value = '';
                document.getElementById('inputNama').value = '';
                document.getElementById('inputMentor').value = '';
                
                form.action = storeUrl;
                document.getElementById('formMethod').value = "POST";
            }
        }

        function closeModal() {
            const modal = document.getElementById('crudDivisionModal');
            const content = document.getElementById('crudDivisionModalContent');
            
            modal.classList.add('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            if (document.activeElement) {
                document.activeElement.blur();
            }
        }

        // Search logic updated for Card Layout
        function searchCards() {
            const input = document.getElementById("searchInput");
            const filter = input.value.toUpperCase();
            const container = document.getElementById("divisionsContainer");
            const cards = container.getElementsByClassName("division-card");

            for (let i = 0; i < cards.length; i++) {
                let textContent = cards[i].innerText || cards[i].textContent;
                
                if (textContent.toUpperCase().indexOf(filter) > -1) {
                    cards[i].style.display = "";
                } else {
                    cards[i].style.display = "none";
                }
            }
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
