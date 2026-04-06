<x-app-layout>
    <div class="py-10 relative">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 relative z-10">
            <!-- Full Width Container -->
            <div class="bg-white dark:bg-[#090e17] rounded-[2.5rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200/60 dark:border-slate-800 overflow-hidden min-h-[85vh] flex flex-col relative pb-28 lg:pb-0">
                
                <!-- Simple Header Area -->
                <div class="p-8 sm:px-12 sm:pt-10 sm:pb-6 border-b border-slate-100 dark:border-slate-800/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/30">
                    <div>
                        <h1 class="text-3xl font-black tracking-tight text-slate-800 dark:text-slate-100">Catat Aktivitas</h1>
                        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">
                            Isi detail progres kerja dan lampirkan bukti kegiatan Anda hari ini.
                        </p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 transition-all shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali
                    </a>
                </div>

                <!-- Form Area -->
                <div class="p-8 sm:p-12 flex-grow flex flex-col w-full">
                    <form action="{{ route('logbooks.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col h-full relative" id="logbookForm" x-data="{ loading: false }">
                        @csrf
                        
                        <!-- Header Group -->
                        <div class="group relative mb-6">
                            <!-- Date Picker -->
                            <div class="mb-4 flex items-center">
                                <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-lg text-sm font-bold cursor-pointer transition-colors border border-slate-200 dark:border-slate-700 relative">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <input id="date" type="text" name="date" value="{{ old('date') }}" required
                                        class="p-0 border-0 bg-transparent text-sm font-bold text-slate-700 dark:text-slate-200 cursor-pointer focus:ring-0 w-32"
                                        placeholder="Pilih Tanggal"
                                        x-data
                                        x-init="flatpickr($el, { dateFormat: 'Y-m-d', altInput: true, altFormat: 'd F Y', locale: 'id', disableMobile: true })" />
                                    <svg class="w-3 h-3 opacity-50 absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <x-input-error :messages="$errors->get('date')" class="ml-3 mt-0 whitespace-nowrap" />
                            </div>

                            <!-- Title Input -->
                            <div class="relative">
                                <input id="title" type="text" name="title" value="{{ old('title') }}" required
                                    class="w-full bg-transparent border-0 p-0 text-3xl sm:text-4xl lg:text-5xl font-black text-slate-800 dark:text-white placeholder-slate-200 dark:placeholder-slate-800 focus:ring-0 transition-opacity"
                                    placeholder="Judul aktivitas hari ini" />
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="w-full h-px bg-gradient-to-r from-slate-200 dark:from-slate-800 to-transparent mb-6"></div>

                        <!-- Rich Text Editor -->
                        <div class="flex-grow flex flex-col relative z-20 mb-10 min-h-[300px]">
                            <input id="activity" type="hidden" name="activity" value="{{ old('activity') }}">
                            <trix-editor input="activity" 
                                class="trix-content flex-grow w-full border-0 focus:ring-0 p-0 text-slate-700 dark:text-slate-300 leading-relaxed text-lg"
                                placeholder="Ceritakan bagaimana kegiatan magang Anda hari ini...">
                            </trix-editor>
                            <x-input-error :messages="$errors->get('activity')" class="mt-2" />
                        </div>

                        <!-- Attachment Area -->
                        <div class="mt-auto pt-8 border-t border-slate-100 dark:border-slate-800/50 mb-16 lg:mb-20 relative z-10 w-full overflow-hidden">
                            <p class="text-xs font-bold text-slate-400 border-none uppercase tracking-widest mb-4">Lampiran Bukti (Opsional)</p>
                            
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
                                :class="{'border-red-400 bg-red-50/50 dark:border-red-500/50 dark:bg-red-500/10 scale-[1.01]': isDragging, 'border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-[#090e17]': !isDragging}"
                                class="relative w-full border-2 border-dashed rounded-3xl p-8 hover:border-red-300 dark:hover:border-red-500/50 hover:bg-slate-100 dark:hover:bg-slate-900 text-center transition-all group flex flex-col items-center justify-center cursor-pointer" onclick="document.getElementById('evidence').click()">
                                
                                <input id="evidence" name="evidence" type="file" class="sr-only" onchange="previewFile(this)" accept="image/*,.pdf">
                                
                                <div id="dropzone_content" class="flex flex-col items-center pointer-events-none transition-transform duration-300 group-hover:scale-105">
                                    <div class="w-12 h-12 rounded-full bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-slate-400 group-hover:text-red-500 transition-colors mb-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <h4 class="text-slate-600 dark:text-slate-300 font-bold mb-1 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors text-sm">Tarik gambar PDF / PNG ke sini</h4>
                                    <p class="text-[10px] text-slate-400 font-medium tracking-wide">Atau klik untuk memilih file (Maks 5MB)</p>
                                </div>

                                <div id="preview_container" class="hidden absolute inset-0 flex flex-col items-center justify-center bg-white/95 dark:bg-slate-900/95 backdrop-blur-sm z-20 transition-all p-4">
                                    <img id="preview_image" src="" alt="Preview" class="max-h-[120px] max-w-full object-contain drop-shadow-md rounded-lg mb-2">
                                    <div class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-full border border-slate-200 dark:border-slate-700 max-w-[80%]">
                                        <p id="fileName" class="text-xs text-slate-700 dark:text-slate-300 font-bold truncate"></p>
                                        <button type="button" class="text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/20 rounded-full p-1 shrink-0" onclick="event.stopPropagation(); document.getElementById('evidence').value = ''; document.getElementById('preview_container').classList.add('hidden'); document.getElementById('dropzone_content').classList.remove('hidden');">
                                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fixed Bottom Submit Bar -->
                        <div class="absolute bottom-0 left-0 w-full bg-white dark:bg-[#090e17] border-t border-slate-200 dark:border-slate-800 p-6 flex flex-col sm:flex-row items-center sm:justify-between gap-4 z-30 rounded-b-[2.5rem]">
                            <span class="text-xs text-slate-400 font-medium hidden sm:inline-block">Semua koneksi data terenkripsi aman</span>
                            <div class="flex items-center gap-3 w-full sm:w-auto">
                                <a href="{{ route('dashboard') }}" class="w-1/2 sm:w-auto text-center px-6 py-3 rounded-full text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 transition-all text-sm font-bold border border-slate-200 dark:border-slate-700">
                                    Batal
                                </a>
                                <button type="button" @click="confirmSaveLogbook($data)" 
                                    x-bind:disabled="loading"
                                    :class="{'opacity-50 cursor-not-allowed': loading, 'hover:shadow-red-600/40 hover:-translate-y-0.5': !loading}"
                                    class="w-1/2 sm:w-auto px-8 py-3 rounded-full bg-red-600 hover:bg-red-700 text-white font-bold shadow-lg shadow-red-600/30 transition-all flex items-center justify-center gap-2 text-sm whitespace-nowrap">
                                    <span x-show="!loading">Kirim Logbook</span>
                                    <span x-show="loading" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </span>
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        /* Custom Styling for Seamless Trix "Document" Feel */
        trix-editor {
            border: none;
            padding: 0;
            background-color: transparent;
            font-size: 1.125rem;
            line-height: 1.8;
            font-family: 'Inter', sans-serif;
            box-shadow: none;
        }
        .dark trix-editor {
            background-color: transparent;
            color: #f8fafc;
            border: none;
            box-shadow: none;
        }
        trix-editor:focus {
            outline: none;
        }
        trix-toolbar {
            position: sticky;
            top: 0;
            z-index: 20;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: none;
            border-bottom: 1px solid #f1f5f9;
            border-radius: 0;
            padding: 0.5rem 0;
            margin-bottom: 1rem;
            box-shadow: none;
            width: fit-content;
        }
        .dark trix-toolbar {
            background-color: rgba(9, 14, 23, 0.9);
            border-bottom-color: #1e293b;
        }
        trix-toolbar .trix-button-group {
            border: none;
            background-color: transparent;
            margin-bottom: 0;
            padding: 0;
        }
        .dark trix-toolbar .trix-button-group {
            border: none;
            background-color: transparent;
        }
        trix-toolbar .trix-button {
            border-radius: 0.5rem;
            color: #64748b;
            background: transparent;
            border: none;
            transition: all 0.2s;
        }
        trix-toolbar .trix-button:hover { background-color: #f1f5f9; }
        .dark trix-toolbar .trix-button { color: #f8fafc; }
        .dark trix-toolbar .trix-button:hover { background-color: #334155; color: #ffffff; }
        .dark trix-toolbar .trix-button::before { filter: brightness(0) invert(1); opacity: 0.8; }
        .dark trix-toolbar .trix-button--active::before { opacity: 1; }
        trix-toolbar .trix-button--active { background-color: #fee2e2; color: #ef4444; }
        .dark trix-toolbar .trix-button--active { background-color: #991b1b; color: #fca5a5; }
        .trix-button-group--file-tools { display: none !important; }
        trix-editor:empty:before { color: #cbd5e1; }
        
        trix-editor h1 { font-size: 1.5em; font-weight: 800; margin-bottom: 0.5em; line-height: 1.2; color: #0f172a; letter-spacing: -0.025em; }
        .dark trix-editor h1 { color: #f8fafc; }
        trix-editor blockquote { border-left: 4px solid #ef4444; padding-left: 1.5rem; color: #475569; font-style: italic; margin: 1.5rem 0; }
        .dark trix-editor blockquote { border-left-color: #dc2626; color: #94a3b8; }
        trix-editor code { background-color: #f1f5f9; padding: 0.2rem 0.5rem; border-radius: 0.5rem; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.9em; color: #dc2626; }
        .dark trix-editor code { background-color: #1e293b; color: #fca5a5; }
        trix-editor pre { background-color: #0f172a; color: #f8fafc; padding: 1.5rem; border-radius: 1rem; overflow-x: auto; margin: 1.5rem 0; font-family: ui-monospace, monospace; border: 1px solid #1e293b; }
        .dark trix-editor pre { background-color: #020617; border: 1px solid #334155; }
        trix-editor ul, trix-editor ol { padding-left: 1.5rem; margin-bottom: 1.5rem; }
        trix-editor li { margin-bottom: 0.5rem; }
    </style>

    <script>
        document.addEventListener("trix-file-accept", function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Upload Gambar?',
                text: "Untuk saat ini, silakan gunakan kolom 'Bukti Kegiatan' di bawah untuk mengupload foto atau dokumen.",
                icon: 'info',
                confirmButtonText: 'Baik, saya mengerti',
                buttonsStyling: false,
                customClass: {
                    popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                    title: 'text-slate-900 dark:text-slate-100 font-bold',
                    htmlContainer: 'text-slate-600 dark:text-slate-400',
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
                        popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                        title: 'text-slate-900 dark:text-slate-100 font-bold',
                        htmlContainer: 'text-slate-600 dark:text-slate-400',
                        confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                    }
                });
                return;
            }

            if (form.reportValidity()) {
                Swal.fire({
                    title: 'Simpan Logbook?',
                    text: "Pastikan data sudah benar sebelum dikirimkan.",
                    icon: 'question',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonText: 'Ya, Kirim!',
                    cancelButtonText: 'Batal',
                    buttonsStyling: false,
                    customClass: {
                        popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                        title: 'text-slate-900 dark:text-slate-100 font-bold',
                        htmlContainer: 'text-slate-600 dark:text-slate-400',
                        confirmButton: 'px-6 py-2.5 mx-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all active:scale-95',
                        cancelButton: 'px-6 py-2.5 mx-2 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-300 dark:hover:bg-slate-600 font-bold rounded-xl transition-all active:scale-95',
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Mengirim...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => Swal.showLoading(),
                            buttonsStyling: false,
                            customClass: {
                                popup: 'bg-white dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-2xl shadow-xl',
                                title: 'text-slate-900 dark:text-slate-100 font-bold',
                                htmlContainer: 'text-slate-600 dark:text-slate-400',
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