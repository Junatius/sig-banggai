@extends('partials.dashboard')

@section('content')
<div class="container py-4">
    <div class="card bg-light shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Berita</h5>
        </div>
        <div class="card-body">

            {{-- Pesan Error (Auto Hide 10s) --}}
            @if ($errors->any())
                <div id="error-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <script>
                    setTimeout(() => {
                        const errorAlert = document.getElementById('error-alert');
                        if (errorAlert) {
                            errorAlert.classList.remove('show');
                            errorAlert.classList.add('fade');
                        }
                    }, 10000);
                </script>
            @endif

            <form method="POST" action="{{ route('dashboard.news.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Judul Berita --}}
                <div class="mb-3">
                    <label class="form-label text-info">Judul Berita</label>
                    <input type="text" 
                           name="title" 
                           class="form-control @error('title') is-invalid @enderror" 
                           value="{{ old('title') }}" 
                           required>
                    <small class="form-text text-muted">
                        Wajib diisi, maksimal 50 karakter.
                    </small>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label text-info">Deskripsi</label>
                    <textarea name="desc" 
                              class="form-control @error('desc') is-invalid @enderror" 
                              rows="6" required>{{ old('desc') }}</textarea>
                    <small class="form-text text-muted">
                        Wajib diisi, berisi konten berita secara lengkap.
                    </small>
                    @error('desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto Berita --}}
                <div class="mb-3">
                    <label class="form-label text-info">Foto Berita</label>
                    <input type="file" 
                           name="photo_url" 
                           class="form-control @error('photo_url') is-invalid @enderror">
                    <small class="form-text text-muted">
                        Wajib diisi, Format: jpeg, png, jpg. Maksimal 2MB.
                    </small>
                    @error('photo_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="text-end">
                    <a href="{{ route('dashboard.news.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
