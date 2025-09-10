@extends('partials.dashboard')

@section('content')
<div class="container">
    <a href="{{ route('dashboard.news.index') }}" 
       class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded mb-3 inline-block">
        ← Kembali
    </a>

    <div class="card bg-white shadow-md rounded-lg overflow-hidden py-4">
        @if ($news->photo_url)
            <div class="w-full h-96 bg-gray-100 flex items-center justify-center overflow-hidden">
                <img src="{{ asset('storage/' . $news->photo_url) }}" 
                    alt="Foto Berita" 
                    class="max-h-full max-w-full object-contain rounded">
            </div>
        @endif
        <div class="p-6">
            <h3 class="text-secondary-emphasis text-2xl font-bold mb-2">{{ $news->title }}</h3>
            <p class="text-sm text-gray-600 mb-4">
                Oleh <span class="font-medium text-gray-700">{{ $news->user->username ?? 'Tidak diketahui' }}</span>
                @if ($news->user && $news->user->attraction)
                    | Tempat Wisata: <span class="text-indigo-600 font-semibold">{{ $news->user->attraction->name }}</span>
                @endif
                | <span class="italic">{{ $news->created_at->translatedFormat('l, d F Y') }}</span>
            </p>
            <p class="text-gray-700 leading-relaxed">{!! nl2br(e($news->desc)) !!}</p>
        </div>
    </div>
</div>
@endsection
