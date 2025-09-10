<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $event->name }} - Event</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .event-header {
      background: #fff;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
    }
    .event-img {
      width: 100%;
      border-radius: 15px;
      object-fit: cover;
      max-height: 400px;
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>
  @include('partials.navbar')

  <main class="container py-5">
    <div class="event-header">
      @if ($event->photo_url)
        <img src="{{ asset('storage/'.$event->photo_url) }}" alt="{{ $event->name }}" class="event-img">
      @endif
      <h1 class="fw-bold mb-3">{{ $event->name }}</h1>
      <p class="text-muted mb-2">
        <i class="fas fa-calendar-day"></i>
        {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
        - {{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}
      </p>
      <p class="text-muted mb-2">
        <i class="fas fa-map-marker-alt"></i> {{ $event->user->attraction->name ?? '-' }}
      </p>
      <p class="text-muted mb-2">
        <i class="fas fa-user-tie"></i> {{ $event->manager }}
      </p>
      <p class="text-muted mb-2">
        <i class="fas fa-phone"></i> {{ $event->contact }}
      </p>
      @if ($event->link)
        <p class="mb-2">
          <i class="fas fa-link"></i>
          <a href="{{ $event->link }}" target="_blank">{{ $event->link }}</a>
        </p>
      @endif
      <div class="mt-4">
        {!! nl2br(e($event->desc)) !!}
      </div>
      <div class="mt-4">
        <a href="{{ route('events.index') }}" class="btn btn-secondary">← Kembali ke Daftar Event</a>
      </div>
    </div>
  </main>

  @include('partials.footer')
</body>
</html>
