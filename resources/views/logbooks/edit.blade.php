<x-app-layout>
    <div class="py-10 relative">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 relative z-10 text-slate-800 dark:text-slate-200">
            <!-- Decorative Backglow - Telkom Red Aurora -->
            <div class="absolute top-[-10%] left-[-10%] w-[600px] h-[600px] bg-red-600/30 dark:bg-red-600/20 blur-[100px] rounded-full pointer-events-none z-0 animate-pulse" style="animation-duration: 8s;"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-rose-500/25 dark:bg-orange-600/20 blur-[100px] rounded-full pointer-events-none z-0 animate-pulse" style="animation-duration: 12s; animation-delay: 2s;"></div>
            <div class="absolute top-[30%] left-[50%] w-[400px] h-[400px] bg-red-500/20 dark:bg-slate-800/40 blur-[100px] rounded-full pointer-events-none z-0 -translate-x-1/2"></div>

            <div class="relative z-10 bg-white/70 dark:bg-[#0f172a]/70 backdrop-blur-3xl rounded-[2.5rem] p-8 md:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.05)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white dark:border-slate-700/50 flex flex-col">
                
                <div class="mb-10 text-center relative">
                    <a href="{{ route('logbooks.index') }}" class="absolute left-0 top-0 hidden md:flex items-center justify-center gap-2 px-5 py-2.5 bg-white/50 dark:bg-slate-800/50 border border-slate-200/60 dark:border-slate-700/50 rounded-xl text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-all shadow-sm hover:shadow-md backdrop-blur-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                    
                    <span class="px-4 py-1.5 bg-red-100 dark:bg-red-500/10 text-red-600 dark:text-red-400 text-[10px] font-black uppercase tracking-widest rounded-full border border-red-200/50 dark:border-red-500/20 mb-4 inline-block shadow-sm">Edit Laporan</span>
                    <h3 class="text-3xl font-black text-slate-800 dark:text-white tracking-tight">Perbarui Logbook Anda</h3>
                </div>

                <form action="{{ route('logbooks.update', $logbook->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col h-full relative" id="logbookForm" x-data="{ loading: false }">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-8">
                        
                        <!-- Date & Title Area -->
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Date Input (Disabled) -->
                            <div class="relative group shrink-0 opacity-80">
                                <label class="block text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2 ml-1">Tanggal Kegiatan</label>
                                <div class="relative flex items-center bg-red-50/30 dark:bg-red-900/10 border border-slate-200/60 dark:border-slate-700/50 rounded-2xl overflow-hidden cursor-not-allowed">
                                    <div class="bg-red-50 dark:bg-red-500/10 p-4 shrink-0 text-red-500 flex items-center justify-center border-r border-slate-200/50 dark:border-slate-700/50">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <input id="disabled_date" type="text" value="{{ \Carbon\Carbon::parse($logbook->date)->translatedFormat('l, d F Y') }}" disabled
                                        class="w-full sm:w-48 bg-transparent border-0 px-4 py-3 text-sm font-bold text-red-700/80 dark:text-red-400/80 focus:ring-0 cursor-not-allowed opacity-80" />
                                </div>
                            </div>

                            <!-- Title Input -->
                            <div class="flex-grow">
                                <label class="block text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2 ml-1">Judul Aktivitas</label>
                                <div class="relative flex items-center bg-white/50 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-700/50 rounded-2xl transition-all hover:border-red-300 dark:hover:border-red-700 focus-within:ring-2 focus-within:ring-red-500/20 overflow-hidden px-4">
                                    <input id="title" type="text" name="title" value="{{ old('title', $logbook->title) }}" required
                                        class="w-full bg-transparent border-0 py-4 text-max-2xl font-black text-slate-800 dark:text-white placeholder-slate-400 focus:ring-0 transition-opacity"
                                        placeholder="Ketik judul kegiatan..." />
                                </div>
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Editor Area -->
                        <div class="relative">
                            <label class="block text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-2 ml-1">Deskripsi Kegiatan Lengkap</label>
                            
                            <div class="bg-white/50 dark:bg-slate-800/40 border border-slate-200/60 dark:border-slate-700/50 rounded-[2rem] p-4 transition-all focus-within:border-red-400 dark:focus-within:border-red-500 focus-within:shadow-[0_0_20px_rgba(239,68,68,0.15)] focus-within:bg-white dark:focus-within:bg-slate-800/80">
                                <input id="activity" type="hidden" name="activity" value="{{ old('activity', $logbook->activity) }}">
                                <trix-editor input="activity" 
                                    class="trix-content w-full border-0 focus:ring-0 p-4 text-slate-700 dark:text-slate-300 leading-relaxed text-[15px] min-h-[300px]"
                                    placeholder="Ceritakan detail kegiatanmu, tantangan, atau hasil pekerjaan hari ini...">
                                </trix-editor>
                            </div>
                            <x-input-error :messages="$errors->get('activity')" class="mt-2" />
                        </div>

                        <!-- Mentor Notes (Readonly) if exists -->
                        @if ($logbook->mentor_notes)
                            <div class="mt-4 bg-amber-50/80 dark:bg-amber-900/20 border-l-4 border-amber-500 p-5 rounded-2xl backdrop-blur-sm">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-6 w-6 text-amber-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-xs font-black uppercase tracking-widest text-amber-800 dark:text-amber-400 mb-1">Catatan/Revisi Pembimbing:</h3>
                                        <div class="text-sm font-medium text-amber-900 dark:text-amber-200">
                                            <p>{{ $logbook->mentor_notes }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Attachment Area -->
                        <div class="relative w-full overflow-hidden pt-4">
                            <p class="text-[10px] font-black text-slate-500 dark:text-slate-400 border-none uppercase tracking-widest mb-4 ml-1">Lampiran Bukti (Opsional)</p>
                            
                            <div x-data="{ 
                                    isDragging: false,
                                    handleDrop(e) {
                                        this.isDragging = false;
                                        if (e.dataTransfer.files.length > 0) {
                                            const file = e.dataTransfer.files[0];
                                            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
                                            if (validTypes.includes(file.type)) {
                                                const fileInput = document.getElementById('evidence');
                                                fileInput.files = e.dataTransfer.files;
                                                const event = new Event('change');
                                                fileInput.dispatchEvent(event);
                                            } else {
                                                Swal.fire({ icon: 'error', title: 'Format Tidak Sesuai', text: 'Harap unggah file PNG, JPG, atau PDF.' });
                                            }
                                        }
                                    }
                                }"
                                @dragover.prevent="isDragging = true" 
                                @dragleave.prevent="isDragging = false" 
                                @drop.prevent="handleDrop($event)"
                                :class="{'border-red-400 bg-red-50/50 dark:border-red-500/50 dark:bg-red-500/10 scale-[1.01]': isDragging, 'border-slate-200/60 dark:border-slate-700/50 bg-white/50 dark:bg-slate-800/40': !isDragging}"
                                class="relative w-full border-2 border-dashed rounded-3xl p-8 hover:border-red-300 dark:hover:border-red-500/50 hover:bg-white dark:hover:bg-slate-800/80 text-center transition-all group flex flex-col items-center justify-center cursor-pointer backdrop-blur-sm" onclick="document.getElementById('evidence').click()">
                                
                                <input id="evidence" name="evidence" type="file" class="sr-only" onchange="previewFile(this)" accept="image/*,.pdf">
                                
                                <div id="dropzone_content" class="flex flex-col items-center pointer-events-none transition-transform duration-300 group-hover:scale-105">
                                    <div class="w-14 h-14 rounded-full bg-slate-100 dark:bg-slate-900 border border-slate-200/50 dark:border-slate-700/50 shadow-sm flex items-center justify-center text-slate-400 group-hover:text-red-500 transition-colors mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <h4 class="text-slate-600 dark:text-slate-300 font-bold mb-1 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors text-sm">Ganti lampiran bukti</h4>
                                    <p class="text-[10px] text-slate-400 font-medium tracking-wide">Pilih atau letakkan file di sini (Maks 5MB)</p>
                                </div>

                                <div id="preview_container" class="hidden absolute inset-0 flex flex-col items-center justify-center bg-white/95 dark:bg-[#0f172a]/95 backdrop-blur-md z-20 transition-all p-4 rounded-3xl">
                                    <img id="preview_image" src="" alt="Preview" class="max-h-[140px] max-w-full object-contain drop-shadow-md rounded-lg mb-3">
                                    <div class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 px-4 py-2 rounded-full border border-slate-200 dark:border-slate-700 max-w-[80%] shadow-sm">
                                        <p id="fileName" class="text-sm text-slate-700 dark:text-slate-300 font-bold truncate"></p>
                                        <button type="button" class="text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/20 rounded-full p-1.5 shrink-0 transition-colors" onclick="event.stopPropagation(); document.getElementById('evidence').value = ''; document.getElementById('preview_container').classList.add('hidden'); document.getElementById('dropzone_content').classList.remove('hidden');">
                                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('evidence')" class="mt-2" />
                        </div>

                        <!-- Action Bar -->
                        <div class="pt-6 flex flex-col sm:flex-row items-center justify-center sm:justify-end gap-4">
                            <a href="{{ route('logbooks.index') }}" class="w-full sm:w-auto text-center px-8 py-3.5 rounded-2xl text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50 hover:text-slate-900 transition-all text-sm font-bold border border-transparent hover:border-slate-200 dark:hover:border-slate-700">
                                Batal
                            </a>
                            <button type="button" @click="confirmSaveLogbook($data)" 
                                x-bind:disabled="loading"
                                :class="{'opacity-50 cursor-not-allowed': loading, 'hover:-translate-y-1 hover:shadow-[0_10px_20px_rgba(220,38,38,0.3)]': !loading}"
                                class="w-full sm:w-auto px-10 py-3.5 rounded-2xl font-bold text-white bg-gradient-to-r from-red-600 to-red-500 transition-all flex items-center justify-center gap-3 text-sm uppercase tracking-wider transform">
                                <span x-show="!loading">Perbarui Logbook</span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <style>
        /* Custom Styling for Option 2 Floating Trix Toolbar */
        trix-editor {
            border: none;
            padding: 0;
            background-color: transparent;
            font-size: 0.9375rem; 
            line-height: 1.8;
            box-shadow: none;
        }
        .dark trix-editor {
            background-color: transparent;
            color: #f8fafc;
        }
        trix-editor:focus {
            outline: none;
        }
        
        trix-toolbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background-color: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(8px);
            border: none;
            border-bottom: 1px dashed rgba(203, 213, 225, 0.5); /* border-slate-300/50 */
            border-radius: 0;
            padding: 0.5rem 1rem;
            margin-bottom: 1rem;
            margin-top: -0.5rem;
            margin-left: -0.5rem;
            margin-right: -0.5rem;
            box-shadow: none;
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
            align-items: center;
        }
        .dark trix-toolbar {
            background-color: rgba(15, 23, 42, 0.4);
            border-bottom-color: rgba(51, 65, 85, 0.5);
        }
        
        trix-toolbar .trix-button-group {
            border: none !important;
            background-color: transparent !important;
            margin-bottom: 0 !important;
            padding: 0 !important;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        /* Add dividers between button groups natively */
        trix-toolbar .trix-button-group:not(:last-child)::after {
            content: '';
            display: block;
            width: 1px;
            height: 1.25rem;
            background-color: #cbd5e1;
            margin: 0 0.5rem;
        }
        .dark trix-toolbar .trix-button-group:not(:last-child)::after {
            background-color: #334155;
        }

        trix-toolbar .trix-button {
            border-radius: 0.75rem !important; /* rounded-xl */
            color: #64748b;
            background: transparent !important;
            border: none !important;
            transition: all 0.2s !important;
            padding: 0.5rem !important;
            display: flex;
            align-items: center;
            justify-content: center;
            height: auto !important;
            min-width: 36px;
        }
        trix-toolbar .trix-button:hover { background-color: #f1f5f9 !important; color: #dc2626; }
        .dark trix-toolbar .trix-button { color: #94a3b8; }
        .dark trix-toolbar .trix-button:hover { background-color: rgba(30, 41, 59, 0.8) !important; color: #fca5a5; }
        
        .dark trix-toolbar .trix-button::before { filter: brightness(0) invert(0.8); }
        .dark trix-toolbar .trix-button--active::before { filter: brightness(0) invert(1); }
        
        trix-toolbar .trix-button--active { background-color: #fee2e2 !important; color: #ef4444 !important; }
        .dark trix-toolbar .trix-button--active { background-color: rgba(239, 68, 68, 0.2) !important; color: #fca5a5 !important; }
        
        .trix-button-group--file-tools { display: none !important; }
        trix-editor:empty:before { color: #cbd5e1; }
        .dark trix-editor:empty:before { color: #475569; }
        
        trix-editor h1 { font-size: 1.75em; font-weight: 900; margin-bottom: 0.75em; line-height: 1.2; color: #0f172a; letter-spacing: -0.025em; }
        .dark trix-editor h1 { color: #fff; }
        trix-editor blockquote { border-left: 4px solid #ef4444; padding-left: 1.5rem; color: #475569; font-style: italic; margin: 1.5rem 0; background: #fef2f2; padding: 1rem 1.5rem; border-radius: 0 1rem 1rem 0; }
        .dark trix-editor blockquote { border-left-color: #dc2626; color: #cbd5e1; background: rgba(239, 68, 68, 0.05); }
        trix-editor code { background-color: #f1f5f9; padding: 0.2rem 0.5rem; border-radius: 0.5rem; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.9em; color: #dc2626; }
        .dark trix-editor code { background-color: #1e293b; color: #fca5a5; }
        trix-editor pre { background-color: #0f172a; color: #f8fafc; padding: 1.5rem; border-radius: 1rem; overflow-x: auto; margin: 1.5rem 0; font-family: ui-monospace, monospace; border: 1px solid #1e293b; }
        .dark trix-editor pre { background-color: #020617; border: 1px solid #1e293b; }
        trix-editor ul, trix-editor ol { padding-left: 1.5rem; margin-bottom: 1.5rem; }
        trix-editor li { margin-bottom: 0.5rem; }

        /* Support custom text alignments generated by JS */
        .text-justify { text-align: justify; }
    </style>

    <script>
        // Custom Trix Configuration for alignment
        document.addEventListener("trix-initialize", function(event) {
            Trix.config.blockAttributes.alignLeft = {
                tagName: "div",
                class: "text-left"
            };
            Trix.config.blockAttributes.alignCenter = {
                tagName: "div",
                class: "text-center"
            };
            Trix.config.blockAttributes.alignRight = {
                tagName: "div",
                class: "text-right"
            };

            const toolbar = event.target.toolbarElement;
            const blockGroup = toolbar.querySelector(".trix-button-group--block-tools");
            
            // Add custom SVGs for text alignment to the block tools group
            if(blockGroup && !toolbar.querySelector('[data-trix-attribute="alignLeft"]')) {
                const alignButtons = `
                    <button type="button" class="trix-button" data-trix-attribute="alignLeft" title="Rata Kiri" tabindex="-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h10M4 18h16"></path></svg>
                    </button>
                    <button type="button" class="trix-button" data-trix-attribute="alignCenter" title="Rata Tengah" tabindex="-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M7 12h10M4 18h16"></path></svg>
                    </button>
                    <button type="button" class="trix-button" data-trix-attribute="alignRight" title="Rata Kanan" tabindex="-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M10 12h10M4 18h16"></path></svg>
                    </button>
                `;
                blockGroup.insertAdjacentHTML("beforeend", alignButtons);
            }
        });

        document.addEventListener("trix-file-accept", function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Upload Gambar?',
                text: "Untuk saat ini, silakan gunakan kolom 'Bukti Kegiatan' di bawah untuk mengupload foto atau dokumen.",
                icon: 'info',
                confirmButtonText: 'Baik, saya mengerti',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-[#0f172a] border border-transparent dark:border-slate-800 rounded-3xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-black',
                    htmlContainer: 'text-slate-500 dark:text-slate-400',
                    confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                }
            });
        });

        function previewFile(input) {
            const file = input.files[0];
            const fileName = document.getElementById('fileName');
            const previewImage = document.getElementById('preview_image');
            const previewContainer = document.getElementById('preview_container');
            const dropzoneContent = document.getElementById('dropzone_content');

            if (file) {
                fileName.textContent = file.name;
                fileName.classList.remove('hidden');

                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                         previewImage.src = e.target.result;
                         previewContainer.classList.remove('hidden');
                         dropzoneContent.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.classList.add('hidden'); 
                    dropzoneContent.classList.remove('hidden');
                }
            } else {
                fileName.classList.add('hidden');
                previewContainer.classList.add('hidden');
                dropzoneContent.classList.remove('hidden');
            }
        }

        function confirmSaveLogbook(alpineData) {
            const form = document.getElementById('logbookForm');
            const activityInput = document.getElementById('activity');
            const rawContent = activityInput.value;
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = rawContent;
            const textContent = tempDiv.textContent || tempDiv.innerText || "";
            
            if (textContent.trim().length === 0 && !rawContent.includes('<img')) {
                 Swal.fire({
                    title: 'Logbook Kosong!',
                    text: 'Ceritakan aktivitasmu hari ini. Jangan biarkan kosong ya!',
                    icon: 'warning',
                    buttonsStyling: false,
                    customClass: {
                        popup: 'bg-white dark:bg-[#0f172a] border border-transparent dark:border-slate-800 rounded-3xl shadow-xl',
                        title: 'text-slate-900 dark:text-slate-100 font-black',
                        htmlContainer: 'text-slate-500 dark:text-slate-400',
                        confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    }
                });
                return;
            }

            if (form.reportValidity()) {
                Swal.fire({
                    title: 'Simpan Logbook?',
                    text: "Pastikan data revisi sudah benar.",
                    icon: 'question',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                    buttonsStyling: false,
                    customClass: {
                        popup: 'bg-white dark:bg-[#0f172a] border border-transparent dark:border-slate-800 rounded-3xl shadow-xl',
                        title: 'text-slate-900 dark:text-slate-100 font-black',
                        htmlContainer: 'text-slate-500 dark:text-slate-400',
                        confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                        cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700/50 text-slate-700 dark:text-slate-300 hover:bg-slate-300 dark:hover:bg-slate-700 font-bold rounded-xl transition-all active:scale-95 border border-transparent dark:border-slate-700/50',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Pembaruan Disimpan...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading(),
                            buttonsStyling: false,
                            customClass: {
                                popup: 'bg-white dark:bg-[#0f172a] border border-transparent dark:border-slate-800 rounded-3xl shadow-xl',
                                title: 'text-slate-900 dark:text-slate-100 font-black',
                                htmlContainer: 'text-slate-500 dark:text-slate-400',
                            }
                        });
                        alpineData.loading = true;
                        form.submit();
                    }
                });
            }
        }
    </script>
</x-app-layout>