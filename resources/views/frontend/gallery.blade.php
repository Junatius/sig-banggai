<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Galeri Pariwisata</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #fef9f7, #fff3f0);
      min-height: 100vh;
    }
    /* 5 kolom per baris di layar besar */
    @media (min-width: 992px) {
      .col-lg-2-4 {
        flex: 0 0 20%;
        max-width: 20%;
      }
    }
    .card {
      border-radius: 15px;
      overflow: hidden;
      height: 100%;
    }
    .card img {
      object-fit: cover;
      height: 200px;
      width: 100%;
    }
    .filter-form {
      max-width: 400px;
    }
    .hero-header {
      background: #fff0ec;
      text-align: center;
      padding: 4rem 2rem;
    }
    .hero-title {
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 1rem;
    }
    .hero-subtitle {
      font-size: 1.2rem;
      margin-bottom: 2rem;
    }
    .btn-navbar {
      background-color: #e26d5c;
      color: white;
      padding: 0.5rem 1.2rem;
      border-radius: 5px;
      text-decoration: none;
    }
    .btn-navbar:hover {
      background-color: #d15345;
      color: white;
    }
  </style>
</head>
<body>

  @include('partials.navbar')

  <header class="hero-header">
    <i class="fas fa-images fa-3x mb-3"></i>
    <h1 class="hero-title">Galeri Pariwisata</h1>
    <p class="hero-subtitle">Jelajahi keindahan Banggai dalam bidikan terbaik</p>
    <a href="#galeri" class="btn btn-navbar">Lihat Galeri</a>
  </header>

  @if(session('success'))
    <div id="success-alert" 
        class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 shadow" 
        style="z-index: 9999; min-width: 300px;" 
        role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
      setTimeout(() => {
        let alertEl = document.getElementById('success-alert');
        if (alertEl) {
          let bsAlert = new bootstrap.Alert(alertEl);
          bsAlert.close();
        }
      }, 3000); // 3 detik
    </script>
  @endif


  <section class="container py-5" id="galeri">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
      <h2 class="mb-3">Galeri Pariwisata</h2>
      <form method="GET" action="{{ route('galleries') }}" class="d-flex filter-form w-100 w-md-auto">
        <select name="attraction_id" class="form-select me-2">
          <option value="">Semua Wisata</option>
          @foreach ($attractions as $attraction)
            <option value="{{ $attraction->id }}" {{ request('attraction_id') == $attraction->id ? 'selected' : '' }}>
              {{ $attraction->name }}
            </option>
          @endforeach
        </select>
        <button type="submit" class="btn btn-outline-secondary">Filter</button>
      </form>
    </div>

    <div class="row g-4">
      @forelse ($galeries as $gallery)
        <div class="col-6 col-md-4 col-lg-2-4 d-flex">
          <div class="card shadow-sm flex-fill position-relative">

            {{-- Delete button (only visible to owner) --}}
            @auth
              @if ($gallery->users_id === auth()->id())
                <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2" 
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteModal{{ $gallery->id }}">
                  <i class="fas fa-trash-alt"></i>
                </button>
              @endif
            @endauth

            <img src="{{ asset('storage/' . $gallery->photo_url) }}" alt="{{ $gallery->attraction->name }}">
            <div class="card-body text-center">
              <p class="mb-0 fw-bold">{{ $gallery->attraction->name }}</p>
            </div>
          </div>
        </div>

        {{-- Delete confirmation modal --}}
        @auth
          @if ($gallery->users_id === auth()->id())
            <div class="modal fade" id="deleteModal{{ $gallery->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $gallery->id }}" aria-hidden="true">
              <div class="modal-dialog">
                <form method="POST" action="{{ route('gallery.destroy', $gallery->id) }}">
                  @csrf
                  @method('DELETE')
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="deleteModalLabel{{ $gallery->id }}">Konfirmasi Hapus Foto</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                      Apakah Anda yakin ingin menghapus foto ini dari tempat wisata 
                      <strong>{{ $gallery->attraction->name }}</strong>?
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          @endif
        @endauth
      @empty
        <div class="col-12 text-center">
          <p class="text-muted">Tidak ada foto ditemukan.</p>
        </div>
      @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
      {{ $galeries->withQueryString()->links() }}
    </div>

        @auth
    <section class="container py-5">
      <h3 class="mb-4">Unggah Foto Baru</h3>
      <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="p-4 bg-white shadow-sm rounded">
        @csrf
        <div class="mb-3">
          <label for="photo_url" class="form-label">Pilih Foto</label>
          <input type="file" name="photo_url" id="photo_url" class="form-control @error('photo_url') is-invalid @enderror" accept="image/*" required>
          @error('photo_url')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="attractions_id" class="form-label">Pilih Tempat Wisata</label>
          <select name="attractions_id" id="attractions_id" class="form-select @error('attractions_id') is-invalid @enderror" required>
            <option value="">-- Pilih Wisata --</option>
            @foreach ($attractions as $attraction)
              <option value="{{ $attraction->id }}">{{ $attraction->name }}</option>
            @endforeach
          </select>
          @error('attractions_id')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Upload</button>
      </form>
    </section>
    @endauth

  </section>

  @include('partials.footer') {{-- You can modularize footer if reused --}}

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
