<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Berita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #ffe6e1, #ffd8ce);
      min-height: 100vh;
    }

    .card {
      border-radius: 15px;
      height: 100%;
      display: flex;
      flex-direction: column;
    }

    .card-img-top {
      object-fit: cover;
      height: 180px;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }

    .card-body {
      display: flex;
      flex-direction: column;
      flex: 1;
    }

    .card-title {
      font-weight: bold;
      margin-bottom: 0.25rem;
    }

    .card-text.small {
      margin-bottom: 0.25rem;
    }

    .btn-add {
      background-color: #e26d5c;
      color: white;
      border: none;
    }

    .btn-add:hover {
      background-color: #d15345;
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

  @include('partials.navbar') {{-- You can modularize navbar if reused --}}

  <header class="hero-header">
    <h1 class="hero-title">Berita Terbaru</h1>
    <p class="hero-subtitle">Menampilkan berita terbaru dan penting di Kabupaten Banggai</p>
    <a href="#berita" class="btn btn-navbar">Lihat Berita</a>
  </header>

  <section class="container py-5" id="berita">
    <h2 class="mb-4 text-center">Berita Pariwisata</h2>

    <div class="d-flex justify-content-between mb-3 flex-wrap">
      <form method="GET" action="{{ route('news.index') }}" class="d-flex flex-wrap w-100 gap-2">
        <input type="text" name="search" class="form-control me-2" placeholder="Cari judul..." value="{{ request('search') }}">
        <select name="filter" class="form-select me-2">
          <option value="">Semua</option>
          <option value="dinas_pariwisata" {{ request('filter') == 'dinas_pariwisata' ? 'selected' : '' }}>Dinas Pariwisata</option>
          @foreach ($attractions as $attraction)
            <option value="{{ $attraction->id }}" {{ request('filter') == $attraction->id ? 'selected' : '' }}>
              {{ $attraction->name }}
            </option>
          @endforeach
        </select>
        <button type="submit" class="btn btn-outline-secondary">Filter</button>

        @auth
          @if (auth()->user()->role === 'pengelola' || auth()->user()->role === 'dinas_pariwisata')
            <a href="{{ route('dashboard.news.create') }}" class="btn btn-add ms-auto">+ Tambah Berita</a>
          @endif
        @endauth
      </form>
    </div>

    <div class="row g-4">
      @forelse ($news as $item)
        <div class="col-md-4 d-flex">
          <div class="card shadow-sm flex-fill">
            <img src="{{ asset('storage/' . $item->photo_url) }}" class="card-img-top" alt="{{ $item->title }}">
            <div class="card-body">
              <h6 class="card-title">{{ $item->title }}</h6>
              <p class="card-text">{{ Str::limit(strip_tags($item->desc), 100, '...') }}</p>
              <p class="card-text small text-muted">
                {{ $item->user->role === 'dinas_pariwisata' ? 'Dinas Pariwisata' : ($item->user->attraction->name ?? '-') }}
              </p>
              <p class="card-text small text-muted mb-2">
                {{ $item->user->username }} · {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('l, d F Y') }}
              </p>
              <a href="{{ route('news.show', $item->id) }}" class="btn btn-sm btn-outline-primary mt-auto">Baca Selengkapnya</a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center">
          <p>Tidak ada berita ditemukan.</p>
        </div>
      @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
      {{ $news->withQueryString()->links() }}
    </div>
  </section>

  @include('partials.footer') {{-- You can modularize footer if reused --}}

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
