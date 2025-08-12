@extends('layouts.dashboard')

@section('content')
<div class="container">
    <a href="{{ route('dashboard.news.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

    <div class="card">
        @if ($news->image)
            <img src="{{ asset('storage/' . $news->image) }}" class="card-img-top" alt="Foto Berita">
        @endif
        <div class="card-body">
            <h3 class="card-title">{{ $news->title }}</h3>
            <p class="text-muted">
                Oleh {{ $news->user->name ?? 'Tidak diketahui' }}  
                @if ($news->attraction) | Tempat Wisata: {{ $news->attraction->name }} @endif  
                | {{ $news->created_at->format('d M Y') }}
            </p>
            <p class="card-text">{!! nl2br(e($news->description)) !!}</p>
        </div>
    </div>
</div>
@endsection
