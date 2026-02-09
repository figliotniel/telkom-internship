<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Setup Data Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-4 text-sm text-gray-600">
                    Halo! Sebelum mulai mengisi logbook, silakan lengkapi data magangmu terlebih dahulu.
                </div>

                <form action="{{ route('internships.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Data Diri --}}
                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Data Diri & Pendidikan</h3>
                        
                        {{-- Jenjang Pendidikan --}}
                        <div class="mb-4">
                            <x-input-label for="education_level" :value="__('Jenjang Pendidikan')" />
                            <select id="education_level" name="education_level" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Pilih Jenjang...</option>
                                <option value="D3">D3</option>
                                <option value="D4">D4</option>
                                <option value="S1">S1</option>
                            </select>
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="mb-4">
                            <x-input-label for="date_of_birth" :value="__('Tanggal Lahir')" />
                            <x-text-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" required />
                        </div>
                    </div>

                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Magang</h3>

                        {{-- Lokasi Magang --}}
                        <div class="mb-4">
                            <x-input-label for="location" :value="__('Lokasi Penempatan (Witel)')" />
                            <select id="location" name="location" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="Witel Semarang">Witel Semarang</option>
                                <option value="Witel Solo">Witel Solo</option>
                                <option value="Witel Yogyakarta">Witel Yogyakarta</option>
                                <option value="Witel Purwokerto">Witel Purwokerto</option>
                                <option value="Witel Kudus">Witel Kudus</option>
                                <option value="Witel Pekalongan">Witel Pekalongan</option>
                                <option value="Witel Magelang">Witel Magelang</option>
                                {{-- Add other locations as needed --}}
                            </select>
                        </div>

                        {{-- Pilih Divisi --}}
                        <div class="mb-4">
                            <x-input-label for="division_id" :value="__('Unit Divisi')" />
                            <select id="division_id" name="division_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- Tanggal Mulai --}}
                            <div>
                                <x-input-label for="start_date" :value="__('Tanggal Mulai')" />
                                <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" required />
                            </div>

                            {{-- Tanggal Selesai --}}
                            <div>
                                <x-input-label for="end_date" :value="__('Tanggal Selesai')" />
                                <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" required />
                            </div>
                        </div>
                    </div>

                    {{-- Pakta Integritas --}}
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Dokumen Persyaratan</h3>
                        <x-input-label for="pact_integrity" :value="__('Foto Pakta Integritas')" />
                        <input id="pact_integrity" type="file" name="pact_integrity" accept="image/*" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required />
                        <p class="text-xs text-gray-500 mt-1">Upload foto dokumen pakta integritas yang sudah ditandatangani.</p>
                    </div>

                    <x-primary-button class="w-full justify-center mt-6">
                        {{ __('Simpan & Ajukan Magang') }}
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>