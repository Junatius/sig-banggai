@extends('partials.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Tambah Event</h1>

    {{-- Notifikasi Error Global --}}
    @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dashboard.events.store') }}" method="POST" enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow-md space-y-4">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-gray-800 font-medium mb-1">Nama Event</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                class="border @error('name') border-red-500 @else border-gray-300 @enderror 
                       text-gray-900 rounded-lg px-4 py-2 w-full focus:ring focus:ring-blue-300 focus:outline-none">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Foto --}}
        <div>
            <label class="block text-gray-800 font-medium mb-1">Foto Event</label>
            <input type="file" name="photo_url"
                class="border @error('photo_url') border-red-500 @else border-gray-300 @enderror 
                       text-gray-900 rounded-lg px-4 py-2 w-full bg-white">
            @error('photo_url')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-800 font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" required
                    class="border @error('start_date') border-red-500 @else border-gray-300 @enderror 
                           text-gray-900 rounded-lg px-4 py-2 w-full">
                @error('start_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-800 font-medium mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" required
                    class="border @error('end_date') border-red-500 @else border-gray-300 @enderror 
                           text-gray-900 rounded-lg px-4 py-2 w-full">
                @error('end_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-gray-800 font-medium mb-1">Deskripsi</label>
            <textarea name="desc" rows="5"
                class="border @error('desc') border-red-500 @else border-gray-300 @enderror 
                       text-gray-900 rounded-lg px-4 py-2 w-full">{{ old('desc') }}</textarea>
            @error('desc')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Link Pendaftaran --}}
        <div>
            <label class="block text-gray-800 font-medium mb-1">Link Postingan (Opsional)</label>
            <input type="url" name="link" value="{{ old('link') }}"
                class="border @error('link') border-red-500 @else border-gray-300 @enderror 
                       text-gray-900 rounded-lg px-4 py-2 w-full">
            @error('link')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Penanggung Jawab --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-800 font-medium mb-1">Penanggung Jawab</label>
                <input type="text" name="manager" value="{{ old('manager') }}" required
                    class="border @error('manager') border-red-500 @else border-gray-300 @enderror 
                           text-gray-900 rounded-lg px-4 py-2 w-full">
                @error('manager')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-gray-800 font-medium mb-1">Kontak</label>
                <input type="text" name="contact" value="{{ old('contact') }}" required
                    class="border @error('contact') border-red-500 @else border-gray-300 @enderror 
                           text-gray-900 rounded-lg px-4 py-2 w-full">
                @error('contact')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('dashboard.events.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow-md transition">
                Kembali
            </a>
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md transition">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
