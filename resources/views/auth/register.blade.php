<x-guest-layout>
    <div x-data="{
        step: 1,
        student_type: 'mahasiswa',        
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

            if (this.step < 3) this.step++;
        },
        prevStep() {
            if (this.step > 1) this.step--;
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
                    <span :class="{'text-red-600': step >= 2}">2. Data diri</span>
                    <span :class="{'text-red-600': step >= 3}">3. Konfirmasi</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="p-8 md:p-12 h-[750px] flex flex-col relative">
            @csrf

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

                        <label class="flex items-start gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200 hover:border-red-300 transition cursor-pointer mt-4">
                            <input type="checkbox" name="term" id="term" class="mt-1 w-5 h-5 text-red-600 rounded border-gray-300 focus:ring-red-500" required>
                            <span class="text-sm text-gray-700 select-none">
                                Saya telah membaca, memahami, dan menyetujui seluruh ketentuan dan persyaratan yang berlaku untuk program magang ini.
                            </span>
                        </label>
                   </div>
                </div>
            </div>

            <!-- Step 2: Lengkapi Data (Was Step 3) -->
            <div x-show="step === 2" style="display: none;" class="flex-1 overflow-y-auto pr-2 custom-scrollbar">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Lengkapi Administrasi</h2>
                    <p class="text-gray-500">Isi data diri dan upload dokumen yang diperlukan.</p>
                </div>

                <!-- Type Selection -->
                <div class="mb-8">
                    <label class="text-sm font-medium text-gray-700 block mb-3">Daftar Sebagai:</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="cursor-pointer relative">
                            <input type="radio" x-model="student_type" value="mahasiswa" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-gray-200 bg-white peer-checked:border-red-600 peer-checked:bg-red-50 hover:bg-gray-50 transition-all flex flex-col items-center">
                                <span class="font-bold text-gray-800 peer-checked:text-red-700">Mahasiswa</span>
                                <span class="text-xs text-gray-500 mt-1">D3 / D4 / S1</span>
                            </div>
                            <div class="absolute top-4 right-4 text-red-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                        </label>
                        <label class="cursor-pointer relative">
                            <input type="radio" x-model="student_type" value="siswa" class="peer sr-only">
                            <div class="p-4 rounded-xl border-2 border-gray-200 bg-white peer-checked:border-red-600 peer-checked:bg-red-50 hover:bg-gray-50 transition-all flex flex-col items-center">
                                <span class="font-bold text-gray-800 peer-checked:text-red-700">Siswa SMK / SMA</span>
                                <span class="text-xs text-gray-500 mt-1">Magang / PKL</span>
                            </div>
                            <div class="absolute top-4 right-4 text-red-600 opacity-0 peer-checked:opacity-100 transition-opacity">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                        </label>
                    </div>
                    <input type="hidden" name="student_type" :value="student_type">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                     <!-- Kiri: Data Magang -->
                    <div class="space-y-5">
                       <h3 class="font-bold text-gray-800 border-b pb-2">Detail Magang</h3>
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
                                <option value="">Pilih Durasi Magang</option>
                                <option value="1 Bulan">1 Bulan</option>
                                <option value="2 Bulan">2 Bulan</option>
                                <option value="3 Bulan">3 Bulan</option>
                                <option value="4 Bulan">4 Bulan</option>
                                <option value="5 Bulan">5 Bulan</option>
                                <option value="6 Bulan">6 Bulan</option>
                             </select>
                       </div>
                        <div x-show="student_type === 'mahasiswa'">
                             <x-input-label for="semester" :value="__('Semester Saat Ini')" />
                              <select name="semester" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" x-bind:required="student_type === 'mahasiswa'" x-bind:disabled="student_type !== 'mahasiswa'">
                                <option value="">Pilih...</option>
                                <option value="5">Semester 5</option>
                                <option value="6">Semester 6</option>
                                <option value="7">Semester 7</option>
                                <option value="8">Semester 8</option>
                              </select>
                        </div>
                        <div x-show="student_type === 'siswa'">
                             <x-input-label for="class" :value="__('Kelas')" />
                             <x-text-input type="text" name="semester" class="w-full mt-1" placeholder="Contoh: XI RPL 1" x-bind:required="student_type === 'siswa'" x-bind:disabled="student_type !== 'siswa'" />
                        </div>
                       <div>
                             <x-input-label for="reason" :value="__('Alasan Memilih Telkom Witel Semarang Jateng Utara sebagai Tempat Magang/Kerja Praktik')" />
                             <textarea name="reason" rows="4" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500" placeholder="Jelaskan mengapa Anda ingin magang di sini..." required></textarea>
                       </div>
                    </div>

                    <!-- Kanan: Data Mahasiswa -->
                    <div class="space-y-5">
                        <h3 class="font-bold text-gray-800 border-b pb-2">Data Mahasiswa</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <x-input-label for="university">
                                    <span x-text="student_type === 'mahasiswa' ? 'Universitas' : 'Asal Sekolah'"></span>
                                </x-input-label>
                                <x-text-input type="text" name="university" class="w-full mt-1" x-bind:placeholder="student_type === 'mahasiswa' ? 'Nama Universitas' : 'Nama Sekolah'" required />
                            </div>
                            <div>
                                <x-input-label for="major" :value="__('Jurusan')" />
                                <div x-show="student_type === 'mahasiswa'" class="mb-2">
                                     <select name="education_level" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                                        <option value="">Jenjang (Opsional)</option>
                                        <option value="D3">D3</option>
                                        <option value="D4">D4</option>
                                        <option value="S1">S1</option>
                                     </select>
                                </div>
                                <x-text-input type="text" name="major" class="w-full mt-1" placeholder="Contoh: Informatika" required />
                            </div>
                            <div>
                                <x-input-label for="nim">
                                    <span x-text="student_type === 'mahasiswa' ? 'NIM' : 'NISN/NIK'"></span>
                                </x-input-label>
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
                                    <span x-text="student_type === 'mahasiswa' ? 'Surat Rekomendasi dari Dosen (PDF)' : 'Surat Pengantar Sekolah (PDF)'"></span>
                                </label>
                                <input type="file" name="surat_rekomendasi" accept=".pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer" required>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <span x-text="student_type === 'mahasiswa' ? 'Kartu Tanda Mahasiswa (Image/PDF)' : 'Kartu Pelajar (Image/PDF)'"></span>
                                </label>
                                <input type="file" name="ktm" accept=".pdf,.jpg,.jpeg,.png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 cursor-pointer" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Konfirmasi (Was Step 4) -->
            <div x-show="step === 3" style="display: none;" class="flex-1 flex flex-col items-center justify-center text-center py-12">
                
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mb-6 animate-bounce">
                    <svg class="w-12 h-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Semua Siap!</h2>
                <div class="max-w-md mx-auto text-gray-600 mb-10">
                    <p class="mb-2">Anda akan mendaftar sebagai <strong>Intern</strong>.</p>
                    <p class="text-sm text-gray-500 mb-2">(Posisi akan ditentukan oleh Admin/HC)</p>
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
