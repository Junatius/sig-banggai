<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Maps - SIG Pariwisata Banggai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/objek.css') }}" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    #map {
      width: 100%;
      height: 600px;
      border-radius: 15px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .info-window {
      max-width: 250px;
    }
    .info-window img {
      width: 100%;
      border-radius: 8px;
      margin-bottom: 8px;
    }
    .info-window h6 {
      margin: 0 0 5px;
      font-weight: bold;
    }
    /* Search box */
    #search-container {
      position: absolute;
      top: 15px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 999;
      width: 300px;
    }
    #search-box {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    #suggestions {
      background: white;
      border: 1px solid #ccc;
      border-top: none;
      max-height: 200px;
      overflow-y: auto;
      display: none;
      position: absolute;
      width: 100%;
      z-index: 1000;
      border-radius: 0 0 8px 8px;
    }
    #suggestions div {
      padding: 8px 12px;
      cursor: pointer;
    }
    #suggestions div:hover {
      background: #f0f0f0;
    }
  </style>
</head>
<body>

  @include('partials.navbar')

  <!-- Header -->
  <section class="intro-header py-5 text-center text-white">
    <div class="container">
        <div class="hero-icon mb-4">
            <i class="fas fa-map-marked-alt fa-4x"></i>
        </div>
        <h1 class="fw-bold mb-3">Lokasi Pariwisata Banggai</h1>
        <p class="lead mb-4">Temukan lokasi destinasi wisata Kabupaten Banggai.</p>
        <a href="#mapSection" class="btn btn-light shadow-lg px-5 py-2 fw-semibold">Lihat Peta</a>
    </div>
  </section>

  <!-- Map Section -->
  <section id="mapSection" class="py-5 bg-light">
    <div class="container position-relative">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-semibold">
          Lokasi Pariwisata
        </div>
        <div class="card-body p-0 position-relative">

          <!-- Search Box -->
          <div id="search-container">
            <input type="text" id="search-box" placeholder="Cari nama objek wisata...">
            <div id="suggestions"></div>
          </div>

          <!-- Map -->
          <div id="map"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  @include('partials.footer')

  <!-- Google Maps API -->
  <script>
    let map;
    let markers = [];
    let infoWindows = [];
    
    function initMap() {
      const banggai = { lat: -1.3841, lng: 123.3186 };
      
      map = new google.maps.Map(document.getElementById("map"), {
        zoom: 9,
        center: banggai,
      });
      
      const attractions = @json($attractions);

      attractions.forEach(attraction => {
        if (attraction.latitude && attraction.longitude) {
          const position = {
            lat: parseFloat(attraction.latitude),
            lng: parseFloat(attraction.longitude),
          };
          
          const marker = new google.maps.Marker({
            position,
            map,
            title: attraction.name,
          });

          const content = `
            <div class="info-window">
              ${attraction.photo_profile 
                ? `<img src="/storage/${attraction.photo_profile}" alt="${attraction.name}">`
                : ''}
              <h6>${attraction.name}</h6>
              <p>${attraction.desc.substring(0, 80)}...</p>
              <a href="/objek-wisata/${attraction.id}" target="_blank" class="btn btn-sm btn-primary">Lihat Detail</a>
            </div>
          `;

          const infowindow = new google.maps.InfoWindow({
            content: content,
          });

          marker.addListener("click", () => {
            infoWindows.forEach(iw => iw.close());
            infowindow.open(map, marker);
          });

          markers.push({ marker, attraction });
          infoWindows.push(infowindow);
        }
      });

      // Search feature
      const searchBox = document.getElementById("search-box");
      const suggestions = document.getElementById("suggestions");

      searchBox.addEventListener("input", function() {
        const query = this.value.toLowerCase();
        suggestions.innerHTML = "";

        if (query.length > 0) {
          const matches = markers.filter(m => m.attraction.name.toLowerCase().includes(query));
          
          if (matches.length > 0) {
            suggestions.style.display = "block";
            matches.forEach(m => {
              const div = document.createElement("div");
              div.textContent = m.attraction.name;
              div.addEventListener("click", () => {
                map.setCenter(m.marker.getPosition());
                map.setZoom(14);

                infoWindows.forEach(iw => iw.close());
                const selectedInfowindow = infoWindows.find((iw, idx) => markers[idx].marker === m.marker);
                if (selectedInfowindow) selectedInfowindow.open(map, m.marker);

                suggestions.style.display = "none";
                searchBox.value = m.attraction.name;
              });
              suggestions.appendChild(div);
            });
          } else {
            suggestions.style.display = "none";
          }
        } else {
          suggestions.style.display = "none";
        }
      });
      
      document.addEventListener("click", function(e) {
        if (!searchBox.contains(e.target) && !suggestions.contains(e.target)) {
          suggestions.style.display = "none";
        }
      });
    }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
