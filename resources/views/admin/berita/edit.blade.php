@extends('partials.dashboard')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-gradient-warning text-white">
            <h5 class="mb-0">Edit Berita</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.news.update', $news->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Judul Berita</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title', $news->title) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="desc" class="form-control" rows="6" required>{{ old('desc', $news->desc) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Berita</label>
                    @if($news->photo_url)
                        <div class="mb-2">
                            <img src="{{ asset($news->photo_url) }}" alt="Foto Berita" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    @endif
                    <input type="file" name="photo_url" class="form-control">
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
