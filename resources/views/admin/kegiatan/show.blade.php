@extends('partials.dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Detail Event</h1>

    <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
        {{-- Foto Event --}}
        @if($event->photo_url)
            <div class="flex justify-center">
                <img src="{{ asset('storage/' . $event->photo_url) }}" alt="Foto Event"
                    class="w-80 h-80 object-cover rounded-xl shadow-md">
            </div>
        @else
            <div class="flex justify-center">
                <span class="text-gray-400 italic">Tidak ada foto</span>
            </div>
        @endif

        {{-- Informasi Event --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-800">
            <div>
                <p class="font-semibold">Nama Event:</p>
                <p class="text-gray-700">{{ $event->name }}</p>
            </div>
            <div>
                <p class="font-semibold">Tanggal:</p>
                <p class="text-gray-700">
                    {{ date('d M Y', strtotime($event->start_date)) }} -
                    {{ date('d M Y', strtotime($event->end_date)) }}
                </p>
            </div>
            <div>
                <p class="font-semibold">Penanggung Jawab:</p>
                <p class="text-gray-700">{{ $event->manager }}</p>
            </div>
            <div>
                <p class="font-semibold">Kontak:</p>
                <p class="text-gray-700">{{ $event->contact }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="font-semibold">Deskripsi:</p>
                <p class="text-gray-700 whitespace-pre-line">{{ $event->desc }}</p>
            </div>
            @if($event->link)
                <div class="md:col-span-2">
                    <p class="font-semibold">Link Pendaftaran:</p>
                    <a href="{{ $event->link }}" target="_blank"
                       class="text-blue-600 hover:underline">{{ $event->link }}</a>
                </div>
            @endif
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-3 pt-4 border-t">
            {{-- Tombol Kembali --}}
            <a href="{{ route('dashboard.events.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg shadow-md transition">
                Kembali
            </a>

            {{-- Tombol Edit: hanya untuk admin & event buatan dinas_pariwisata --}}
            @if($event->user && $event->user->role === 'dinas_pariwisata')
                <a href="{{ route('dashboard.events.edit', $event->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg shadow-md transition">
                    Edit
                </a>
            @endif

            {{-- Tombol Hapus --}}
            <form action="{{ route('dashboard.events.destroy', $event->id) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg shadow-md transition">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
