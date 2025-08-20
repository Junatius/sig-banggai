@extends('partials.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Tambah Event</h1>

    <form action="{{ route('dashboard.events.store') }}" method="POST" enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow-md space-y-4">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-gray-800 font-medium mb-1">Nama Event</label>
            <input type="text" name="name" required
                class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full focus:ring focus:ring-blue-300 focus:outline-none">
        </div>

        {{-- Foto --}}
        <div>
            <label class="block text-gray-800 font-medium mb-1">Foto Event</label>
            <input type="file" name="photo_url"
                class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full bg-white">
        </div>

        {{-- Tanggal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-800 font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" required
                    class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full">
            </div>
            <div>
                <label class="block text-gray-800 font-medium mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" required
                    class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full">
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-gray-800 font-medium mb-1">Deskripsi</label>
            <textarea name="desc" rows="5"
                class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full"></textarea>
        </div>

        {{-- Link Pendaftaran --}}
        <div>
            <label class="block text-gray-800 font-medium mb-1">Link Pendaftaran (Opsional)</label>
            <input type="url" name="link"
                class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full">
        </div>

        {{-- Penanggung Jawab --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-800 font-medium mb-1">Penanggung Jawab</label>
                <input type="text" name="manager" required
                    class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full">
            </div>
            <div>
                <label class="block text-gray-800 font-medium mb-1">Kontak</label>
                <input type="text" name="contact" required
                    class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full">
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
