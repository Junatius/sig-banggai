@extends('partials.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Tombol Kembali --}}
    <div class="mb-6">
        <a href="{{ route('dashboard.attractions.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition duration-200">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Card Form --}}
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">
        <h1 class="text-3xl font-bold text-black mb-8 text-center">Tambah Tempat Wisata</h1>

        <form action="{{ route('dashboard.attractions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Grid 2 kolom --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Wisata --}}
                <div>
                    <label class="block text-base font-semibold text-gray-700 mb-1">Nama Wisata</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full rounded-lg border-gray-300 ring-1 focus:border-blue-500 focus:ring focus:ring-blue-200 p-3 text-gray-800"
                           placeholder="Masukkan nama tempat wisata" required>
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Kecamatan --}}
                <div>
                    <label class="block text-base font-semibold text-gray-700 mb-1">Kecamatan</label>
                    <select name="subdistrict_id"
                            class="w-full ring-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 p-3 text-gray-800"
                            required>
                        <option value="">Pilih Kecamatan</option>
                        @foreach($subdistricts as $subdistrict)
                            <option value="{{ $subdistrict->id }}" {{ old('subdistrict_id') == $subdistrict->id ? 'selected' : '' }}>
                                {{ $subdistrict->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subdistrict_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Foto Profil --}}
                <div>
                    <label class="block text-base  font-semibold text-gray-700 mb-1">Foto Profil</label>
                    <input type="file" name="photo_profile"
                           class="w-full ring-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 p-3 text-gray-800">
                    @error('photo_profile') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Jenis Wisata --}}
                <div>
                    <label class="block text-base font-semibold text-gray-700 mb-1">Jenis Wisata</label>
                    <input type="text" name="type" value="{{ old('type') }}"
                           class="w-full rounded-lg ring-1 border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 p-3 text-gray-800"
                           placeholder="Misal: Pantai, Gunung, Taman" required>
                    @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Legalitas --}}
                <div>
                    <label class="block text-base font-semibold text-gray-700 mb-1">Legalitas</label>
                    <input type="text" name="legality" value="{{ old('legality') }}"
                           class="w-full ring-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 p-3 text-gray-800"
                           placeholder="Contoh: Resmi / Tidak Resmi" required>
                    @error('legality') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Harga Tiket --}}
                <div>
                    <label class="block text-base font-semibold text-gray-700 mb-1">Harga Tiket</label>
                    <input type="number" name="price" value="{{ old('price') }}"
                           class="w-full ring-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 p-3 text-gray-800"
                           placeholder="Masukkan harga tiket">
                    @error('price') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Apakah ada fasilitas --}}
                <div>
                    <label class="block text-base font-semibold text-gray-700 mb-1">Apakah ada fasilitas?</label>
                    <select name="has_facility"
                            class="w-full rounded-lg ring-1 border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 p-3 text-gray-800">
                        <option value="1" {{ old('has_facility') == '1' ? 'selected' : '' }}>Ada</option>
                        <option value="0" {{ old('has_facility') == '0' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('has_facility') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Deskripsi (Full Width) --}}
            <div>
                <label class="block text-base font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea name="desc" rows="4"
                          class="w-full rounded-lg ring-1 border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 p-3 text-gray-800"
                          placeholder="Tulis deskripsi lengkap tempat wisata">{{ old('desc') }}</textarea>
                @error('desc') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('dashboard.attractions.index') }}"
                   class="px-5 py-2 bg-gray-400 text-white rounded-lg shadow hover:bg-gray-500 transition duration-200">
                    Batal
                </a>
                <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
