@extends('partials.dashboard')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0">Tambah Berita</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.news.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Judul Berita</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="desc" class="form-control" rows="6" required>{{ old('desc') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto Berita (opsional)</label>
                    <input type="file" name="photo_url" class="form-control">
                </div>
                <div class="text-end">
                    <a href="{{ route('dashboard.news.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
