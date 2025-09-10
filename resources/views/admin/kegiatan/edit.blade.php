@extends('partials.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Event</h1>

    <form action="{{ route('dashboard.events.update', $event->id) }}" method="POST" enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow-md space-y-4">
        @csrf
        @method('PUT')

        {{-- Nama Event --}}
        <div>
            <label class="block text-gray-800 font-medium mb-1">Nama Event</label>
            <input type="text" name="name" value="{{ old('name', $event->name) }}" required
                class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full focus:ring focus:ring-blue-300 focus:outline-none">
        </div>

        {{-- Foto Event --}}
        <div>
            <label class="block text-gray-800 font-medium mb-1">Foto Event</label>
            <input type="file" name="photo_url"
                class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full bg-white">
            @if($event->photo_url)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $event->photo_url) }}" alt="Foto Event"
                        class="w-64 h-64 object-cover rounded-lg shadow-md mx-auto">
                </div>
            @endif
        </div>

        {{-- Tanggal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-800 font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ old('start_date', $event->start_date) }}" required
                    class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full">
            </div>
            <div>
                <label class="block text-gray-800 font-medium mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ old('end_date', $event->end_date) }}" required
                    class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full">
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-gray-800 font-medium mb-1">Deskripsi</label>
            <textarea name="desc" rows="5"
                class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full">{{ old('desc', $event->desc) }}</textarea>
        </div>

        {{-- Link Pendaftaran --}}
        <div>
            <label class="block text-gray-800 font-medium mb-1">Link Pendaftaran (Opsional)</label>
            <input type="url" name="link" value="{{ old('link', $event->link) }}"
                class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full">
        </div>

        {{-- Penanggung Jawab dan Kontak --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-800 font-medium mb-1">Penanggung Jawab</label>
                <input type="text" name="manager" value="{{ old('manager', $event->manager) }}" required
                    class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full">
            </div>
            <div>
                <label class="block text-gray-800 font-medium mb-1">Kontak</label>
                <input type="text" name="contact" value="{{ old('contact', $event->contact) }}" required
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
                Update
            </button>
        </div>
    </form>
</div>
@endsection
