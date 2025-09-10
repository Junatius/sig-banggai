<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $news->title }} - Berita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #ffe6e1, #ffd8ce);
      min-height: 100vh;
    }
    .news-card {
      background: #fff;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      overflow: hidden;
    }
    .news-img {
      width: 100%;
      height: 350px;
      object-fit: cover;
    }
    .news-body {
      padding: 2rem;
    }
    .news-meta {
      font-size: 0.9rem;
      color: #6c757d;
      margin-bottom: 1rem;
    }
    .news-title {
      font-weight: bold;
      font-size: 1.8rem;
      margin-bottom: 1rem;
    }
    .news-content {
      font-size: 1rem;
      line-height: 1.6;
    }
    .btn-back {
      background-color: #e26d5c;
      color: #fff;
      border: none;
      margin-top: 1.5rem;
    }
    .btn-back:hover {
      background-color: #d15345;
      color: #fff;
    }
  </style>
</head>
<body>
  @include('partials.navbar')

  <main class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card news-card">
          @if ($news->photo_url)
            <img src="{{ asset('storage/' . $news->photo_url) }}" class="news-img" alt="{{ $news->title }}">
          @endif
          <div class="news-body">
            <h1 class="news-title">{{ $news->title }}</h1>
            <p class="news-meta">
              <i class="fas fa-user"></i>
              {{ $news->user->role === 'dinas_pariwisata' ? 'Dinas Pariwisata' : ($news->user->attraction->name ?? '-') }}
              · <strong>{{ $news->user->username }}</strong>
              · <i class="fas fa-calendar-alt"></i>
              {{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('l, d F Y') }}
            </p>
            <div class="news-content">
              {!! $news->desc !!}
            </div>
            <a href="{{ route('news.index') }}" class="btn btn-back">
              ← Kembali ke Daftar Berita
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>

  @include('partials.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
