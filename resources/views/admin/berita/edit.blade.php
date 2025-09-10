@extends('partials.dashboard')

@section('content')
<div class="container py-4">

    {{-- Alert error global --}}
    @if ($errors->any())
        <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mt-2 mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
        <script>
            setTimeout(() => {
                let alertBox = document.getElementById('error-alert');
                if (alertBox) {
                    alertBox.style.display = 'none';
                }
            }, 10000); // hilang otomatis setelah 10 detik
        </script>
    @endif

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
                    <small class="text-muted d-block mb-1">Wajib diisi, maksimal 50 karakter.</small>
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
                    <small class="text-muted d-block mb-1">Wajib diisi, minimal 10 karakter.</small>
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
                    <small class="text-muted d-block mb-1">Opsional, format: JPG/PNG, maks 2MB.</small>
                    @if($news->photo_url)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $news->photo_url) }}" 
                                 alt="Foto Berita" 
                                 class="img-thumbnail mx-auto" 
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
