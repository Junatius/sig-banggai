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

      {{-- Google 3D Maps --}}
      @if($attraction->latitude && $attraction->longitude)
        <div class="card shadow-sm">
          <div class="card-header bg-primary text-white fw-semibold">
            Lokasi pada Peta (3D)
          </div>
          <div class="card-body">
            <div id="map3d-container" style="width: 100%; height: 500px; border-radius: 12px; overflow: hidden;"></div>
          </div>
        </div>
      @endif


    </div>
  </section>

  @include('partials.footer')

  {{-- Google Maps --}}
  {{-- Google 3D Maps --}}
@if($attraction->latitude && $attraction->longitude)
  <script>
    async function init3DMap() {
      const { Map3DElement, Marker3DInteractiveElement, PopoverElement } = await google.maps.importLibrary("maps3d");
      const { PinElement } = await google.maps.importLibrary("marker");

      // --- Map setup ---
      const map = new Map3DElement({
        center: { 
          lat: parseFloat("{{ $attraction->latitude }}"),
          lng: parseFloat("{{ $attraction->longitude }}"),
          altitude: 500
        },
        range: 3000,
        tilt: 70,
        heading: 45,
        mode: "HYBRID",
        gestureHandling: "COOPERATIVE"
      });

      // --- Create pin and popover ---
      const pin = new PinElement({
        glyphText: "★",
        scale: 1.5,
        background: "#0d6efd",
        borderColor: "#fff",
        glyphColor: "#fff"
      });

      const popover = new PopoverElement();
      const header = document.createElement("span");
      header.slot = "header";
      header.textContent = "{{ $attraction->name }}";

      const body = document.createElement("div");
      body.innerHTML = `
        <div style="max-width:240px">
          <img src="{{ $attraction->photo_profile ? asset('storage/' . $attraction->photo_profile) : asset('assets/images/default.jpg') }}"
               style="width:100%;border-radius:8px;margin-bottom:8px;">
          <p>{{ Str::limit($attraction->desc, 100) }}</p>
        </div>
      `;

      popover.append(header);
      popover.append(body);

      // --- Marker setup ---
      const marker = new Marker3DInteractiveElement({
        title: "{{ $attraction->name }}",
        position: { 
          lat: parseFloat("{{ $attraction->latitude }}"),
          lng: parseFloat("{{ $attraction->longitude }}"),
          altitude: 100
        },
        gmpPopoverTargetElement: popover
      });

      marker.append(pin);
      map.append(marker);
      map.append(popover);

      // --- Attach map to container ---
      const container = document.getElementById("map3d-container");
      container.innerHTML = "";
      map.style.width = "100%";
      map.style.height = "500px";
      map.style.borderRadius = "12px";
      container.append(map);
    }
  </script>

  <script async
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&v=beta&libraries=maps3d,marker"
    onload="init3DMap()">
  </script>
@endif

</body>
</html>
