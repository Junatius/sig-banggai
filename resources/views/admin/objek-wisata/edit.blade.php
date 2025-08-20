@extends('partials.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Card Form --}}
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Edit Tempat Wisata</h1>

        <form action="{{ route('dashboard.attractions.update', $attraction->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Wisata --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Nama Wisata</label>
                <input type="text" name="name" value="{{ old('name', $attraction->name) }}"
                       class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                       placeholder="Masukkan nama wisata" required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Kecamatan --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Kecamatan</label>
                <select name="subdistrict_id"
                        class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    <option value="">Pilih Kecamatan</option>
                    @foreach($subdistricts as $subdistrict)
                        <option value="{{ $subdistrict->id }}" {{ old('subdistrict_id', $attraction->subdistrict_id) == $subdistrict->id ? 'selected' : '' }}>
                            {{ $subdistrict->name }}
                        </option>
                    @endforeach
                </select>
                @error('subdistrict_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Foto Profil --}}
            <div class="flex flex-col items-center">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Foto Profil</label>
                @if($attraction->photo_profile)
                    <img src="{{ asset('storage/'.$attraction->photo_profile) }}"
                         class="w-40 h-32 object-cover rounded-lg mb-3 border border-gray-200 shadow">
                @endif
                <input type="file" name="photo_profile"
                       class="w-full md:w-2/3 rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                @error('photo_profile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi</label>
                <textarea name="desc" rows="4"
                          class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                          placeholder="Tulis deskripsi wisata">{{ old('desc', $attraction->desc) }}</textarea>
                @error('desc') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Fasilitas --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Apakah ada fasilitas?</label>
                <select name="has_facility"
                        class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="1" {{ old('has_facility', $attraction->has_facility) == '1' ? 'selected' : '' }}>Ada</option>
                    <option value="0" {{ old('has_facility', $attraction->has_facility) == '0' ? 'selected' : '' }}>Tidak</option>
                </select>
                @error('has_facility') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Jenis Wisata --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Jenis Wisata</label>
                <input type="text" name="type" value="{{ old('type', $attraction->type) }}"
                       class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                       placeholder="Contoh: Pantai, Gunung, Air Terjun" required>
                @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Legalitas --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Legalitas</label>
                <input type="text" name="legality" value="{{ old('legality', $attraction->legality) }}"
                       class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                       placeholder="Masukkan legalitas" required>
                @error('legality') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Harga Tiket --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Harga Tiket</label>
                <input type="number" name="price" value="{{ old('price', $attraction->price) }}"
                       class="w-full rounded-lg border border-gray-300 bg-white text-gray-900 placeholder-gray-400 p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                       placeholder="Masukkan harga tiket">
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('dashboard.attractions.index') }}"
                   class="px-6 py-3 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-500 transition font-semibold">
                    Kembali
                </a>
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-500 transition font-semibold">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
