@extends('partials.dashboard')

@section('content')
<div class="p-6">
    {{-- Title & Tambah Event --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Event</h1>
        <a href="{{ route('dashboard.events.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md transition flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Event
        </a>
    </div>

    {{-- Search & Filter Card --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('dashboard.events.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Search --}}
            <div>
                <label for="search" class="block text-gray-700 text-sm font-medium mb-1">Cari Event</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Masukkan nama event..."
                    class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full focus:ring focus:ring-blue-300 focus:outline-none">
            </div>

            {{-- Tanggal Mulai --}}
            <div>
                <label for="start_date" class="block text-gray-700 text-sm font-medium mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                    class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full focus:ring focus:ring-blue-300 focus:outline-none">
            </div>

            {{-- Tanggal Selesai --}}
            <div>
                <label for="end_date" class="block text-gray-700 text-sm font-medium mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                    class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full focus:ring focus:ring-blue-300 focus:outline-none">
            </div>

            {{-- Filter Tempat Wisata --}}
            @if(auth()->user()->role === 'dinas_pariwisata')
            <div>
                <label for="attractions_id" class="block text-gray-700 text-sm font-medium mb-1">Tempat Wisata</label>
                <select name="attractions_id" id="attractions_id"
                    class="border border-gray-300 text-gray-900 rounded-lg px-4 py-2 w-full focus:ring focus:ring-blue-300 focus:outline-none">
                    <option value="">Semua</option>
                    @foreach($attractions as $attraction)
                        <option value="{{ $attraction->id }}" {{ request('attractions_id') == $attraction->id ? 'selected' : '' }}>
                            {{ $attraction->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            {{-- Tombol Filter --}}
            <div class="md:col-span-4 flex justify-end mt-2">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg shadow-md transition">
                    Terapkan Filter
                </button>
            </div>
        </form>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="py-3 px-4">Foto</th>
                    <th class="py-3 px-4">Nama Event</th>
                    <th class="py-3 px-4">Tanggal</th>
                    <th class="py-3 px-4">Tempat Wisata</th>
                    <th class="py-3 px-4">Penanggung Jawab</th>
                    <th class="py-3 px-4">Kontak</th>
                    <th class="py-3 px-4">Dibuat</th>
                    <th class="py-3 px-4">Terakhir Diubah</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr class="border-b hover:bg-gray-50">
                        {{-- Foto --}}
                        <td class="py-3 px-4">
                            @if($event->photo_url)
                                <img src="{{ asset('storage/' . $event->photo_url) }}" alt="Foto Event" class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <span class="text-gray-400">Tidak ada</span>
                            @endif
                        </td>

                        {{-- Nama Event --}}
                        <td class="py-3 px-4 font-semibold text-gray-900">{{ $event->name }}</td>

                        {{-- Tanggal --}}
                        <td class="py-3 px-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}
                        </td>

                        {{-- Nama Tempat Wisata --}}
                        <td class="py-3 px-4 text-gray-700">
                            {{ $event->user->attraction->name ?? '-' }}
                        </td>

                        {{-- Penanggung Jawab --}}
                        <td class="py-3 px-4 text-gray-700">{{ $event->manager }}</td>

                        {{-- Kontak --}}
                        <td class="py-3 px-4 text-gray-700">{{ $event->contact }}</td>

                        {{-- Dibuat --}}
                        <td class="py-3 px-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($event->created_at)->translatedFormat('d F Y') }}
                        </td>

                        {{-- Terakhir Diubah --}}
                        <td class="py-3 px-4 text-gray-700">
                            {{ \Carbon\Carbon::parse($event->updated_at)->translatedFormat('d F Y') }}
                        </td>

                        {{-- Tombol Aksi --}}
                        <td class="py-3 px-4 flex gap-3 justify-center">
                            {{-- Detail --}}
                            <a href="{{ route('dashboard.events.show', $event->id) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow-md transition"
                               title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </a>

                            {{-- Edit: hanya muncul jika event dibuat oleh user dengan role dinas_pariwisata --}}
                            @if($event->user->role === 'pengelola' || $event->user->role === 'dinas_pariwisata')
                                <a href="{{ route('dashboard.events.edit', $event->id) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white p-2 rounded-full shadow-md transition"
                                title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5h2m-1-1v2m-7 7l-2 2m0 0l4 4m-4-4h18" />
                                    </svg>
                                </a>
                            @endif

                            {{-- Hapus --}}
                            <button class="btn text-white btn-danger rounded-pill shadow-transition"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $event->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-4 text-center text-gray-500">Belum ada event</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $events->links() }}
    </div>
</div>

@foreach ($events as $event)
    <div class="modal fade" id="deleteModal{{ $event->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $event->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('dashboard.events.destroy', $event->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-gray-500">
                        <h5 class="modal-title" id="deleteModalLabel{{ $event->id }}">Hapus Kegiatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-black">
                        Apakah Anda yakin ingin menghapus kegiatan <strong>{{ $event->name }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

@endsection
