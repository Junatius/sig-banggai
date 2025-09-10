<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>{{ $attraction->name }} - SIG Pariwisata Banggai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/objek.css') }}" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    #map {
      width: 100%;
      height: 400px;
      border-radius: 12px;
    }
  </style>
</head>
<body>

  @include('partials.navbar')

  <section class="py-5 bg-light">
    <div class="container">
      <a href="{{ route('objek-wisata.index') }}" class="btn btn-secondary mb-3">
        ← Kembali
      </a>

      <div class="card shadow-lg mb-4">
        <div class="row g-0">
          <div class="col-md-6">
            <img src="{{ $attraction->photo_profile ? asset('storage/' . $attraction->photo_profile) : asset('assets/images/default.jpg') }}"
                 class="img-fluid w-100 h-100 object-fit-cover rounded-start"
                 alt="{{ $attraction->name }}">
          </div>
          <div class="col-md-6">
            <div class="card-body p-4">
              <h2 class="fw-bold">{{ $attraction->name }}</h2>
              <p class="text-muted mb-2">
                <i class="fas fa-map-marker-alt"></i> Kecamatan: {{ $attraction->subdistrict?->name ?? '-' }}
              </p>
              <p class="mb-3">{{ $attraction->desc }}</p>

              <ul class="list-unstyled mb-3">
                <li><strong>Jenis Wisata:</strong> {{ $attraction->type }}</li>
                <li><strong>Legalitas:</strong> {{ $attraction->legality }}</li>
                <li><strong>Harga Tiket:</strong> Rp. {{ number_format($attraction->price, 0, ',', '.') }}</li>
              </ul>

              <p>
                <span class="badge bg-{{ $attraction->has_facility ? 'success' : 'secondary' }}">
                  {{ $attraction->has_facility ? 'Ada Fasilitas' : 'Belum Ada Fasilitas' }}
                </span>
              </p>
            </div>
          </div>
        </div>
      </div>

      {{-- Google Maps --}}
      @if($attraction->latitude && $attraction->longitude)
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white fw-semibold">
            Lokasi pada Peta
          </div>
          <div class="card-body">
            <div id="map"></div>
          </div>
        </div>
      @endif

    </div>
  </section>

  @include('partials.footer')

  {{-- Google Maps --}}
  @if($attraction->latitude && $attraction->longitude)
    <script>
      window.initMap = function() {
        const location = {
          lat: parseFloat("{{ $attraction->latitude }}"),
          lng: parseFloat("{{ $attraction->longitude }}")
        };

        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 14,
          center: location,
        });

        const marker = new google.maps.Marker({
          position: location,
          map: map,
          title: "{{ $attraction->name }}"
        });

        const infoWindow = new google.maps.InfoWindow({
          content: `
            <div>
              <h6 class="fw-bold mb-1">{{ $attraction->name }}</h6>
              <p>{{ Str::limit($attraction->desc, 100) }}</p>
            </div>
          `
        });

        marker.addListener("click", () => {
          infoWindow.open(map, marker);
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
  @endif

</body>
</html>
