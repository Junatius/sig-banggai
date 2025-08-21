@extends('partials.dashboard')

@section('content')
<div class="container mx-auto py-6">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="mb-4 p-4 text-green-900 bg-green-100 border border-green-200 rounded-lg shadow">
            <i class="bi bi-check-circle-fill mr-1"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 text-red-900 bg-red-100 border border-red-200 rounded-lg shadow">
            <i class="bi bi-exclamation-triangle-fill mr-1"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h1 class="text-2xl font-bold text-white md:text-gray-100">Manajemen Tempat Wisata</h1>
        <a href="{{ route('dashboard.attractions.create') }}"
           class="mt-3 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
            <i class="bi bi-plus-lg mr-2"></i> Tambah Tempat Wisata
        </a>
    </div>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('dashboard.attractions.index') }}"
          class="bg-white rounded-xl shadow p-5 mb-6 border border-gray-200">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">

            {{-- Search --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Cari Nama Wisata</label>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="w-full px-3 py-2 bg-white text-gray-800 placeholder-gray-500 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Masukkan nama tempat wisata..."
                >
            </div>

            {{-- Kecamatan --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Kecamatan</label>
                <select
                    name="filter_subdistrict"
                    class="w-full px-3 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Semua</option>
                    @foreach($subdistricts as $subdistrict)
                        <option value="{{ $subdistrict->id }}" {{ request('filter_subdistrict') == $subdistrict->id ? 'selected' : '' }}>
                            {{ $subdistrict->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fasilitas --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Fasilitas</label>
                <select
                    name="filter_facility"
                    class="w-full px-3 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Semua</option>
                    <option value="1" {{ request('filter_facility') === '1' ? 'selected' : '' }}>Ada</option>
                    <option value="0" {{ request('filter_facility') === '0' ? 'selected' : '' }}>Tidak Ada</option>
                </select>
            </div>

            {{-- Harga Minimal --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Harga Min</label>
                <input
                    type="number"
                    name="min_price"
                    value="{{ request('min_price') }}"
                    class="w-full px-3 py-2 bg-white text-gray-800 placeholder-gray-500 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="0"
                >
            </div>

            {{-- Harga Maksimal --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Harga Max</label>
                <input
                    type="number"
                    name="max_price"
                    value="{{ request('max_price') }}"
                    class="w-full px-3 py-2 bg-white text-gray-800 placeholder-gray-500 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="1000000"
                >
            </div>

            {{-- Jenis Wisata --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Jenis Wisata</label>
                <select
                    name="filter_type"
                    class="w-full px-3 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Semua</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('filter_type') == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end mt-5 gap-3">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow">
                <i class="bi bi-search mr-2"></i> Filter
            </button>
            <a href="{{ route('dashboard.attractions.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg shadow">
                <i class="bi bi-arrow-repeat mr-2"></i> Reset
            </a>
        </div>
    </form>

    {{-- Tabel Tempat Wisata --}}
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-x-auto">
        <table class="min-w-full text-sm text-gray-800">
            <thead class="bg-gray-100 text-gray-800 sticky top-0 z-10">
                <tr class="divide-x divide-gray-200">
                    <th class="px-4 py-3 text-left font-semibold w-24">Foto</th>
                    <th class="px-4 py-3 text-left font-semibold w-56">Nama</th>
                    <th class="px-4 py-3 text-left font-semibold w-44">Kecamatan</th>
                    <th class="px-4 py-3 text-center font-semibold w-28">Fasilitas</th>
                    <th class="px-4 py-3 text-left font-semibold w-40">Jenis Wisata</th>
                    <th class="px-4 py-3 text-left font-semibold w-36">Legalitas</th>
                    <th class="px-4 py-3 text-right font-semibold w-36">Harga Tiket (Rp)</th>
                    <th class="px-4 py-3 text-center font-semibold w-36">Dibuat</th>
                    <th class="px-4 py-3 text-center font-semibold w-40">Terakhir Diubah</th>
                    <th class="px-4 py-3 text-center font-semibold w-32">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($attractions as $attraction)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        @if($attraction->photo_profile)
                            <img src="{{ asset('storage/'.$attraction->photo_profile) }}"
                                 class="w-16 h-12 object-cover rounded-md border border-gray-200" alt="">
                        @else
                            <div class="w-16 h-12 rounded-md border border-dashed border-gray-300 flex items-center justify-center text-xs text-gray-400">
                                No Image
                            </div>
                        @endif
                    </td>

                    <td class="px-4 py-3 font-semibold">
                        <div class="leading-snug">{{ $attraction->name }}</div>
                    </td>

                    <td class="px-4 py-3">
                        {{ $attraction->subdistrict->name ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        @if($attraction->has_facility)
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Ada</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Tidak</span>
                        @endif
                    </td>

                    <td class="px-4 py-3">
                        {{ ucfirst($attraction->type) }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $attraction->legality }}
                    </td>

                    <td class="px-4 py-3 text-right">
                        @php
                            $priceText = is_numeric($attraction->price)
                                ? number_format((int)$attraction->price, 0, ',', '.')
                                : ($attraction->price ?: '-');
                        @endphp
                        {{ $priceText }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        {{ optional($attraction->created_at)->translatedFormat('d M Y') }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        {{ optional($attraction->updated_at)->translatedFormat('d M Y') }}
                    </td>

                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('dashboard.attractions.show', $attraction->id) }}"
                               class="px-2 py-1 rounded bg-blue-600 hover:bg-blue-700 text-white" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('dashboard.attractions.edit', $attraction->id) }}"
                               class="px-2 py-1 rounded bg-yellow-500 hover:bg-yellow-600 text-white" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $attraction->id }}"
                                class="px-2 py-1 rounded bg-red-600 hover:bg-red-700 text-white"
                                title="Hapus"
                            >
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-6 text-gray-600">Tidak ada tempat wisata ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-5">
        {{-- Default Tailwind pagination dari Laravel sudah cukup kontras.
             Pastikan di config/app.php 'pagination' => 'tailwind' --}}
        {{ $attractions->withQueryString()->links() }}
    </div>
</div>

@foreach ($attractions as $attraction)
    <div class="modal fade" id="deleteModal{{ $attraction->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $attraction->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('dashboard.attractions.destroy', $attraction->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-gray-500">
                        <h5 class="modal-title" id="deleteModalLabel{{ $attraction->id }}">Hapus Tempat Wsiata</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-black">
                        Apakah Anda yakin ingin menghapus Tempat Wisata <strong>{{ $attraction->name }}</strong>?
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
