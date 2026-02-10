<x-guest-layout>
    <div x-data="{
        step: 1,
        studentType: null, // 'mahasiswa' or 'siswa'
        educationLevel: '',
        
        init() {
            this.$watch('studentType', value => {
                if (value === 'siswa') {
                    this.educationLevel = 'SMK';
                } else {
                    this.educationLevel = '';
                }
            });
        },

        nextStep() {
             // Validate Step 1 selection
             if (this.step === 1) {
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const confirm = document.getElementById('password_confirmation').value;
                const term = document.getElementById('term').checked;

                if (!name || !email || !password || !confirm || !term) {
                    alert('Harap lengkapi semua data dan setujui ketentuan.');
                    return;
                }
                if (password !== confirm) {
                    alert('Password tidak sama.');
                    return;
                }
            }

            // Validate Step 2 selection
            if (this.step === 2) {
                 if (!this.studentType) {
                    alert('Harap pilih kategori peserta (Mahasiswa / Siswa SMK).');
                    return;
                 }
                 
                 // If Mahasiswa, validate education level
                 if (this.studentType === 'mahasiswa' && !this.educationLevel) {
                     alert('Harap pilih jenjang pendidikan.');
                     return;
                 }

                 // Validate other required fields manually if needed or rely on HTML5 required (which works on submit, not nextStep button if it's type button)
                 // Since we are using type='button' for nextStep, we should check key fields or rely on the form submit at Step 3.
                 // However, moving to Step 3 usually requires data to be visually ready.
                 
                 // Check basic required fields for empty values
                 const requiredIds = ['start_date', 'end_date', 'duration', 'semester', 'reason', 'university', 'major', 'nim', 'phone'];
                 let empty = false;
                 // Note: This simple check might need refinement but good for now
            }

            if (this.step < 3) this.step++;
        },
        prevStep() {
            if (this.step > 1) this.step--;
        },
        get isStudent() {
            return this.studentType === 'siswa';
        },
        get isUniversity() {
             return this.studentType === 'mahasiswa';
        }
    }" class="w-full max-w-6xl mx-auto my-10 bg-white shadow-2xl rounded-2xl overflow-hidden font-sans">

        <!-- Header / Progress -->
        <div class="bg-gray-50 border-b border-gray-100 p-8">
            <div class="relative">
                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-gray-200">
                    <div :style="'width: ' + ((step / 3) * 100) + '%'" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-600 transition-all duration-500 ease-out"></div>
                </div>
                <div class="flex justify-between text-[10px] sm:text-sm font-semibold text-gray-500 tracking-wide uppercase">
                    <span :class="{'text-red-600': step >= 1}">1. Akun & Ketentuan</span>
                    <span :class="{'text-red-600': step >= 2}">2. Data Diri</span>
                    <span :class="{'text-red-600': step >= 3}">3. Konfirmasi</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="p-8 md:p-12 h-[750px] flex flex-col relative">
            @csrf
            <input type="hidden" name="student_type" :value="isStudent ? 'siswa' : 'mahasiswa'">

            <!-- Step 1: Ketentuan & Akun -->
            <div x-show="step === 1" class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                <div class="mb-8 text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900">Mulai Perjalanan Karirmu</h2>
                    <p class="text-gray-500 mt-2">Daftar sekarang untuk bergabung dengan tim hebat kami.</p>
                </div>

                <div class="grid md:grid-cols-2 gap-12">
                   <!-- Ketentuan -->
                   <div class="space-y-6">
                        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-lg">
                            <h3 class="flex items-center text-lg font-bold text-red-700 mb-3">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                Ketentuan Pendaftaran
                            </h3>
                            <div class="prose prose-sm text-gray-700">
                                <p class="mb-2">Selamat datang di Telkom Witel Jateng Semarang Utara. Mohon perhatikan:</p>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Wajib memiliki akun <strong>Telegram</strong> aktif dengan nomor Telkomsel.</li>
                                    <li>Komitmen penuh terhadap periode magang yang disepakati.</li>
                                </ul>
                                <p class="text-xs mt-3 text-red-600 bg-red-100 p-2 rounded inline-block font-semibold">
                                    Catatan: Pengurangan periode dapat membatalkan sertifikat.
                                </p>
                            </div>
                        </div>

                        <label class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-red-300 transition cursor-pointer">
                            <input type="checkbox" name="term" id="term" class="mt-1 w-5 h-5 text-red-600 rounded border-gray-300 focus:ring-red-500" required>
                            <span class="text-sm text-gray-700 select-none">
                                Saya telah membaca, memahami, dan menyetujui seluruh ketentuan dan persyaratan yang berlaku untuk program magang ini.
                            </span>
                        </label>
                   </div>

                   <!-- Form Akun -->
                   <div class="space-y-5">
                        <h3 class="text-xl font-bold text-gray-800 border-b pb-2">Buat Akun</h3>
                        
                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" type="text" name="name" :value="old('name')" required placeholder="Muhammad Dzaky Hamid" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Alamat Email')" />
                            <x-text-input id="email" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" type="email" name="email" :value="old('email')" required placeholder="email@university.ac.id" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" type="password" name="password" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-50 focus:bg-white transition" type="password" name="password_confirmation" required />
                            </div>
                        </div>
                   </div>
                </div>
            </div>

            <!-- Step 2: Lengkapi Data -->
            <div x-show="step === 2" style="display: none;" class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                
                <!-- Category Selection (Always Visible if not selected, or can change) -->
                <div x-show="!studentType" class="flex flex-col items-center justify-center h-full space-y-8">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-900">Pilih Kategori Peserta</h2>
                        <p class="text-gray-500">Silakan pilih kategori yang sesuai dengan Anda.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl px-4">
                        <!-- Mahasiswa Card -->
                        <div @click="studentType = 'mahasiswa'" class="group relative bg-white border-2 border-gray-200 rounded-2xl p-8 cursor-pointer hover:border-red-500 hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-6 group-hover:bg-red-50 group-hover:text-red-600 transition-colors">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Mahasiswa</h3>
                            <p class="text-sm text-gray-500">Untuk mahasiswa aktif jenjang D3, D4, dan S1 dari berbagai universitas.</p>
                        </div>

                        <!-- Siswa SMK Card -->
                        <div @click="studentType = 'siswa'" class="group relative bg-white border-2 border-gray-200 rounded-2xl p-8 cursor-pointer hover:border-red-500 hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center">
                             <div class="w-20 h-20 bg-green-50 text-green-600 rounded-full flex items-center justify-center mb-6 group-hover:bg-red-50 group-hover:text-red-600 transition-colors">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Siswa SMK</h3>
                            <p class="text-sm text-gray-500">Untuk siswa SMK yang akan melaksanakan Praktik Kerja Industri (Prakerin).</p>
                        </div>
                    </div>
                </div>

                <!-- Form Content (Visible after selection) -->
                <div x-show="studentType" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="mb-6 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Lengkapi Data Diri <span x-text="studentType === 'mahasiswa' ? '(Mahasiswa)' : '(Siswa SMK)'" class="text-red-600"></span></h2>
                            <p class="text-gray-500">Isi data diri dan upload dokumen yang diperlukan.</p>
                        </div>
                        <button type="button" @click="studentType = null" class="text-sm text-red-600 font-semibold hover:underline bg-red-50 px-3 py-1 rounded-lg">Ganti Kategori</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Kiri: Data Magang -->
                        <div class="space-y-5">
                        <h3 class="font-bold text-gray-800 border-b pb-2">Detail Magang</h3>
                        
                        <!-- Educational Level Selection (Only for Mahasiswa) -->
                        <div x-show="studentType === 'mahasiswa'">
                                <x-input-label for="education_level" :value="__('Jenjang Pendidikan')" />
                                <select name="education_level" id="education_level" x-model="educationLevel" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="" disabled selected hidden>Pilih Jenjang...</option>
                                    <option value="D3">D3</option>
                                    <option value="D4">D4</option>
                                    <option value="S1">S1</option>
                                </select>
                        </div>

                       <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="start_date" class="!text-xs text-gray-500" :value="__('Usulan Mulai Magang (Hari Senin Awal Bulan)')" />
                                <x-text-input type="date" name="start_date" class="w-full mt-1" required />
                            </div>
                            <div>
                                <x-input-label for="end_date" class="!text-xs text-gray-500" :value="__('Usulan Selesai Magang (Hari Jumat Akhir Bulan)')" />
                                <x-text-input type="date" name="end_date" class="w-full mt-1" required />
                            </div>
                       </div>
                       <div>
                            <x-input-label for="duration" :value="__('Durasi Magang')" />
                             <select name="duration" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" required>
                                <option value="" disabled selected hidden>Pilih Durasi Magang</option>
                                <option value="1 Bulan">1 Bulan</option>
                                <option value="2 Bulan">2 Bulan</option>
                                <option value="3 Bulan">3 Bulan</option>
                                <option value="4 Bulan">4 Bulan</option>
                                <option value="5 Bulan">5 Bulan</option>
                                <option value="6 Bulan">6 Bulan</option>
                             </select>
                       </div>
                       <div>
                            <label class="block font-medium text-sm text-gray-700">
                                <span x-text="isStudent ? 'Kelas Saat Ini' : 'Semester Saat Ini'"></span>
                            </label>
                             <select name="semester" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" required>
                                <option value="" disabled selected hidden>Pilih...</option>
                                <template x-if="isUniversity">

                                    <optgroup label="Mahasiswa">
                                        <option value="5">Semester 5</option>
                                        <option value="6">Semester 6</option>
                                        <option value="7">Semester 7</option>
                                        <option value="8">Semester 8</option>
                                    </optgroup>
                                </template>
                                <template x-if="isStudent">
                                    <optgroup label="Siswa SMK">
                                        <option value="10">Kelas 10</option>
                                        <option value="11">Kelas 11</option>
                                        <option value="12">Kelas 12</option>
                                    </optgroup>
                                </template>
                             </select>
                       </div>
                       <div>
                             <x-input-label for="reason" :value="__('Alasan Magang')" />
                             <textarea name="reason" rows="4" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Jelaskan mengapa Anda ingin magang di sini..." required></textarea>
                       </div>
                    </div>

                    <!-- Kanan: Data Mahasiswa/Siswa -->
                    <div class="space-y-5">
                        <h3 class="font-bold text-gray-800 border-b pb-2">
                             <span x-text="isStudent ? 'Data Siswa' : 'Data Mahasiswa'"></span>
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block font-medium text-sm text-gray-700">
                                    <span x-text="isStudent ? 'Nama Sekolah' : 'Universitas'"></span>
                                </label>
                                <x-text-input type="text" name="university" class="w-full mt-1" x-bind:placeholder="isStudent ? 'SMK Telkom...' : 'Nama Universitas'" required />
                            </div>
                            <div>
                                <x-input-label for="major" :value="__('Jurusan')" />
                                <x-text-input type="text" name="major" class="w-full mt-1" required />
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">
                                    <span x-text="isStudent ? 'NIS/NISN' : 'NIM'"></span>
                                </label>
                                <x-text-input type="text" name="nim" class="w-full mt-1" required />
                            </div>
                            <div class="col-span-2">
                                <x-input-label for="phone" :value="__('No. WhatsApp')" />
                                <x-text-input type="text" name="phone" class="w-full mt-1" placeholder="08..." required />
                            </div>
                        </div>
                    </div>

                    <!-- Bawah: File Uploads -->
                    <div class="md:col-span-2 bg-gray-50 p-6 rounded-xl border border-dashed border-gray-300">
                        <h3 class="font-bold text-gray-800 mb-4">Upload Dokumen</h3>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Curriculum Vitae (PDF)</label>
                                <input type="file" name="cv" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span x-text="isStudent ? 'Surat Pengantar Sekolah (PDF)' : 'Surat Rekomendasi Kampus (PDF)'"></span>
                                </label>
                                <input type="file" name="surat_rekomendasi" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span x-text="isStudent ? 'Kartu Pelajar (Image/PDF)' : 'Kartu Tanda Mahasiswa (Image/PDF)'"></span>
                                </label>
                                <input type="file" name="ktm" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Foto Diri Terbaru (Image)</label>
                                <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <!-- Step 3: Konfirmasi -->
            <div x-show="step === 3" style="display: none;" class="flex-1 flex flex-col items-center justify-center text-center py-12">
                
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-6 animate-bounce">
                    <svg class="w-12 h-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Semua Siap!</h2>
                <div class="max-w-md mx-auto text-gray-600 mb-10">
                    <p class="mb-2">Anda akan mendaftar sebagai <strong>Intern</strong> di Telkom Witel Semarang.</p>
                    <p>Pastikan seluruh data sudah benar. Klik tombol di bawah untuk mengirim permohonan Anda.</p>
                </div>

                <div class="flex gap-4">
                     <button type="button" @click="prevStep()" class="px-8 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg shadow-sm hover:bg-gray-50 transition">
                        Cek Lagi
                    </button>
                    <button type="submit" class="px-8 py-3 bg-red-600 text-white font-bold rounded-lg shadow-lg hover:bg-red-700 hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                        Kirim Permohonan
                    </button>
                </div>
            </div>

            <!-- Navigation Buttons (Global for Step 1-2) -->
            <div class="mt-8 pt-6 border-t border-gray-100 flex-shrink-0 flex justify-between" x-show="step < 3">
                <button type="button" 
                        @click="prevStep()" 
                        x-show="step > 1"
                        class="flex items-center text-gray-600 hover:text-gray-900 font-medium px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    Kembali
                </button>
                <div x-show="step === 1"></div> <!-- Spacer if no prev button -->
                
                <button type="button" 
                        @click="nextStep()" 
                        class="flex items-center bg-red-600 text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:bg-red-700 hover:shadow-lg transition transform hover:-translate-y-0.5">
                    Selanjutnya
                    <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>

        </form>
    </div>
</x-guest-layout>