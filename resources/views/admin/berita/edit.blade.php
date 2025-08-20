@extends('partials.dashboard')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Berita</h5>
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('dashboard.news.update', $news->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Judul Berita --}}
                <div class="mb-3">
                    <label class="form-label text-black">Judul Berita</label>
                    <input type="text" 
                           name="title" 
                           class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title', $news->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label text-black">Deskripsi</label>
                    <textarea name="desc" 
                              class="form-control @error('desc') is-invalid @enderror" 
                              rows="6" required>{{ old('desc', $news->desc) }}</textarea>
                    @error('desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto Berita --}}
                <div class="mb-3">
                    <label class="form-label text-black">Foto Berita</label>
                    @if($news->photo_url)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $news->photo_url) }}" 
                                 alt="Foto Berita" 
                                 class="img-thumbnail" 
                                 style="max-width: 200px;">
                        </div>
                    @endif
                    <input type="file" 
                           name="photo_url" 
                           class="form-control @error('photo_url') is-invalid @enderror">
                    @error('photo_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <a href="{{ route('dashboard.news.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-warning text-white">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
