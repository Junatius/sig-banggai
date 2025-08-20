@extends('partials.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Tombol Kembali --}}
    <div class="mb-4">
        <a href="{{ route('dashboard.attractions.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 transition">
            <i class="bi bi-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    {{-- Card Detail --}}
    <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
        <h1 class="text-2xl font-bold text-black mb-6">Detail Tempat Wisata</h1>

        {{-- Foto Profil --}}
        <div class="mb-6 flex justify-center">
            @if($attraction->photo_profile)
                <img src="{{ asset('storage/'.$attraction->photo_profile) }}"
                    class="w-full max-w-lg h-64 object-cover rounded-lg shadow">
            @else
                <div class="w-full max-w-lg h-64 flex items-center justify-center bg-gray-100 rounded-lg">
                    <span class="text-gray-500 italic">Tidak ada foto</span>
                </div>
            @endif
        </div>


        {{-- Informasi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <p class="text-gray-500 text-sm">Nama Wisata</p>
                <p class="text-lg font-semibold text-black">{{ $attraction->name }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Kecamatan</p>
                <p class="text-lg font-semibold text-black">{{ $attraction->subdistrict->name }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Fasilitas</p>
                <p class="text-lg font-semibold text-black">
                    {!! $attraction->has_facility
                        ? '<span class="text-green-600">Ada</span>'
                        : '<span class="text-red-600">Tidak Ada</span>' !!}
                </p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Jenis Wisata</p>
                <p class="text-lg font-semibold text-black">{{ ucfirst($attraction->type) }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Legalitas</p>
                <p class="text-lg font-semibold text-black">{{ $attraction->legality }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Harga Tiket</p>
                <p class="text-lg font-semibold text-black">Rp {{ number_format($attraction->price, 0, ',', '.') }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-gray-500 text-sm">Deskripsi</p>
                <p class="text-lg text-gray-700">{{ $attraction->desc }}</p>
            </div>
        </div>

        {{-- Tanggal Dibuat dan Diperbarui --}}
        <div class="mt-6 border-t pt-4 grid grid-cols-1 md:grid-cols-2 gap-5 text-sm text-gray-500">
            <p>Dibuat pada: <span class="font-semibold">{{ $attraction->created_at->translatedFormat('d F Y, H:i') }}</span></p>
            <p>Terakhir diubah: <span class="font-semibold">{{ $attraction->updated_at->translatedFormat('d F Y, H:i') }}</span></p>
        </div>
    </div>
</div>
@endsection
