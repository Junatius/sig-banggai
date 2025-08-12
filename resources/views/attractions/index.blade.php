<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIG Pariwisata Banggai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/objek.css') }}" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

  @include('partials.navbar')
  
  <!-- Header -->
  <section class="intro-header py-5 text-center text-white">
    <div class="container">
        <div class="hero-icon mb-4">
            <i class="fas fa-map-marked-alt fa-4x"></i>
        </div>
        <h1 class="fw-bold mb-3">Selamat Datang di SIG Pariwisata Banggai</h1>
        <p class="lead mb-4">Temukan informasi lengkap seputar objek wisata terbaik di Kabupaten Banggai.</p>
        <a href="#objekSection" class="btn btn-light shadow-lg px-5 py-2 fw-semibold">Jelajahi Objek Wisata</a>
    </div>
  </section>

  <div class="container mt-4">
    <!-- Filter Form -->
    <form method="GET" action="{{ route('objek-wisata.index') }}">
      <div class="row mb-3">
        <div class="col-md-4">
          <label class="form-label fw-semibold">Kecamatan</label>
          <select name="kecamatan" class="form-select">
            <option value="">Semua Kecamatan</option>
            @foreach ($kecamatans as $id => $nama)
              <option value="{{ $id }}" {{ request('kecamatan') == $id ? 'selected' : '' }}>
                {{ $nama }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Kategori</label>
          <select name="category" class="form-select">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $item)
              <option value="{{ $item }}" {{ request('category') == $item ? 'selected' : '' }}>
                {{ $item }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Fasilitas</label>
          <select name="facility" class="form-select">
            <option value="">Semua</option>
            <option value="1" {{ request('facility') === '1' ? 'selected' : '' }}>Ada Fasilitas</option>
            <option value="0" {{ request('facility') === '0' ? 'selected' : '' }}>Belum Ada Fasilitas</option>
          </select>
        </div>
      </div>

      <!-- Bottom row: search + filter button -->
      <div class="row mb-3">
        <div class="col-md-10">
          <input type="text" name="search" class="form-control" placeholder="Cari objek wisata..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Objek Wisata Section -->
  <section id="objekSection" class="py-5 bg-light">
    <div class="container">
      <div class="row" id="objekList">
        @forelse ($attractions as $attraction)
          <div class="col-md-4 mb-4">
            <div class="card h-100">
              <img src="{{ $attraction->photo_profile ?? asset('assets/images/default.jpg') }}" class="card-img-top" alt="{{ $attraction->name }}">
              <div class="card-body">
                <h5 class="card-title">{{ $attraction->name }}</h5>
                <p class="card-text">{{ Str::limit($attraction->desc, 100) }}</p>
                <p class="card-text">
                  <small class="text-muted">
                    Kecamatan: {{ $attraction->subdistrict?->name ?? '-' }}
                  </small>
                </p>
                <p class="card-text"><small class="text-muted">Jenis Pengelola: {{ $attraction->type }}</small></p>
                <p class="card-text"><small class="text-muted">Legalitas: {{ $attraction->legality }}</small></p>
                <p class="card-text"><small class="text-muted">Kontak: {{ $attraction->contact }}</small></p>
                <p class="card-text">
                  <span class="badge bg-{{ $attraction->has_facility ? 'success' : 'secondary' }}">
                    {{ $attraction->has_facility ? 'Ada Fasilitas' : 'Belum Ada Fasilitas' }}
                  </span>
                </p>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-center">Tidak ada data objek wisata ditemukan.</p>
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="d-flex flex-column align-items-center mt-4">
        {{ $attractions->links() }}
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
