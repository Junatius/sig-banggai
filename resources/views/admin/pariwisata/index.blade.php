@extends('partials.dashboard')

@section('content')
<div class="container mx-auto py-6">
    @if(session('success'))
        <div class="mb-4 p-4 text-green-900 bg-green-100 border border-green-200 rounded-lg shadow">
            <i class="bi bi-check-circle-fill mr-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
        <h1 class="text-2xl font-bold mb-4">{{ $attraction->name }}</h1>

        @if($attraction->photo_profile)
            <img src="{{ asset('storage/'.$attraction->photo_profile) }}"
                 class="w-full flex mx-auto max-w-md h-64 object-cover rounded-lg mb-4 border">
        @endif

        <p class="mb-2"><strong>Kecamatan:</strong> {{ $attraction->subdistrict->name ?? '-' }}</p>
        <p class="mb-2"><strong>Deskripsi:</strong> {{ $attraction->desc }}</p>
        <p class="mb-2"><strong>Legalitas:</strong> {{ $attraction->legality }}</p>
        <p class="mb-2"><strong>Harga Tiket:</strong> {{ $attraction->price ?: '-' }}</p>
        <p class="mb-2"><strong>Fasilitas:</strong>
            @if($attraction->has_facility)
                <span class="text-green-600 font-semibold">Ada</span>
            @else
                <span class="text-red-600 font-semibold">Tidak</span>
            @endif
        </p>

        <div class="mt-6">
            <a href="{{ route('dashboard.attractions.edit_pengelola') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                <i class="bi bi-pencil mr-2"></i> Edit Informasi
            </a>
        </div>
    </div>
</div>
@endsection
