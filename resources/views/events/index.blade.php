<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Daftar Event - SIG Pariwisata Banggai</title>
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
            <i class="fas fa-calendar-alt fa-4x"></i>
        </div>
        <h1 class="fw-bold mb-3">Daftar Event Pariwisata Banggai</h1>
        <p class="lead mb-4">Temukan informasi event terbaru di destinasi wisata Kabupaten Banggai.</p>
        <a href="#eventSection" class="btn btn-light shadow-lg px-5 py-2 fw-semibold">Lihat Event</a>
    </div>
  </section>

  <div class="container mt-4">
    <!-- Filter Form -->
    <form method="GET" action="{{ route('events.index') }}">
      <div class="row mb-3">
        <div class="col-md-4">
          <label class="form-label fw-semibold">Tempat Wisata</label>
          <select name="attraction" class="form-select">
            <option value="">Semua Tempat Wisata</option>
            @foreach ($attractions as $item)
              <option value="{{ $item->id }}" {{ request('attraction') == $item->id ? 'selected' : '' }}>
                {{ $item->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Tanggal Mulai</label>
          <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Tanggal Berakhir</label>
          <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
      </div>

      <!-- Bottom row: search + filter button -->
      <div class="row mb-3">
        <div class="col-md-10">
          <input type="text" name="search" class="form-control" placeholder="Cari nama event..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
      </div>
    </form>
  </div>

  <!-- Event Section -->
  <section id="eventSection" class="py-5 bg-light">
    <div class="container">
      <div class="row" id="eventList">
        @forelse ($events as $event)
          <div class="col-md-4 mb-4">
            <a href="{{ route('events.show', $event->id) }}" class="text-decoration-none text-dark">
              <div class="card h-100 shadow-sm">
                <img src="{{ $event->photo_url ? asset('storage/'.$event->photo_url) : asset('assets/images/default-event.jpg') }}"
                     class="card-img-top"
                     alt="{{ $event->name }}"
                     style="height:200px; object-fit:cover;">
                <div class="card-body">
                  <h5 class="card-title">{{ $event->name }}</h5>
                  <p class="card-text mb-1"><small class="text-muted">
                    <i class="fas fa-calendar-day"></i>
                    {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }} - 
                    {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}
                  </small></p>
                  <p class="card-text mb-1"><small class="text-muted">
                    <i class="fas fa-user-tie"></i> {{ $event->manager }}
                  </small></p>
                  <p class="card-text mb-1"><small class="text-muted">
                    <i class="fas fa-map-marker-alt"></i> {{ $event->user->attraction->name ?? '-' }}
                  </small></p>
                </div>
              </div>
            </a>  
          </div>
        @empty
          <div class="col-12">
            <p class="text-center">Tidak ada event ditemukan.</p>
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      <div class="d-flex flex-column align-items-center mt-4">
        {{ $events->links() }}
      </div>
    </div>
  </section>

  <!-- Footer -->
  @include('partials.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
