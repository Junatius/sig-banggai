@extends('partials.dashboard')

@section('content')
<div class="container mx-auto py-6">
    <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
        <h1 class="text-2xl font-bold mb-6">Edit Informasi Tempat Wisata</h1>

        <form method="POST" action="{{ route('dashboard.attractions.update_pengelola') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $attraction->name) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi</label>
                <textarea name="desc" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('desc', $attraction->desc) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Legalitas</label>
                <input type="text" name="legality" value="{{ old('legality', $attraction->legality) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Harga Tiket</label>
                <input type="text" name="price" value="{{ old('price', $attraction->price) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="has_facility" value="1" {{ old('has_facility', $attraction->has_facility) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-gray-800">Memiliki Fasilitas</span>
                </label>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Foto Profil</label>
                <input type="file" name="photo_profile"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @if($attraction->photo_profile)
                    <p class="mt-2 text-sm text-gray-600">Foto saat ini:</p>
                    <img src="{{ asset('storage/'.$attraction->photo_profile) }}"
                         class="w-40 h-28 object-cover mx-auto rounded-md mt-1 border">
                @endif
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('dashboard.attractions.show_pengelola') }}"
                   class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg">Batal</a>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
