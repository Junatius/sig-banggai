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
  <title>Maps 3D - SIG Pariwisata Banggai</title>

  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
    #map-container {
      position: relative;
      width: 100%;
      height: 600px;
      border-radius: 15px;
      overflow: hidden;
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
<body class="bg-light">

  @include('partials.navbar')

  <section class="intro-header py-5 text-center text-white bg-primary">
    <div class="container">
        <div class="hero-icon mb-4">
            <i class="fas fa-map-marked-alt fa-4x"></i>
        </div>
        <h1 class="fw-bold mb-3">Peta 3D Pariwisata Banggai</h1>
        <p class="lead mb-4">Jelajahi destinasi wisata Banggai dengan tampilan peta 3D.</p>
    </div>
  </section>

  <section id="mapSection" class="py-5 bg-light">
    <div class="container position-relative">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-semibold">
          Peta 3D Lokasi Pariwisata
        </div>
        <div class="card-body p-0 position-relative">
          <div id="map-container">
            <!-- Search Box -->
            <div id="search-container">
              <input type="text" id="search-box" placeholder="Cari nama objek wisata...">
              <div id="suggestions"></div>
            </div>

            <!-- 3D Map -->
            <gmp-map-3d
              id="map3d"
              mode="hybrid"
              range="5000"
              tilt="65"
              heading="20"
              interactive
              center="-0.9568, 122.7875">
            </gmp-map-3d>
          </div>
        </div>
      </div>
    </div>
  </section>

  @include('partials.footer')

  <script async
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&v=beta&libraries=maps3d"
    onload="init3DMap()">
  </script>

<script>
  async function init3DMap() {
    const map3d = document.getElementById("map3d");
    const attractions = @json($attractions);

    await customElements.whenDefined("gmp-map-3d");

    // --- Add markers dynamically ---
    attractions.forEach(attraction => {
      if (attraction.latitude && attraction.longitude) {
        const marker = document.createElement("gmp-marker-3d");
        marker.setAttribute("position", `${attraction.latitude},${attraction.longitude}`);
        marker.setAttribute("label", attraction.name);
        marker.setAttribute("altitude", "100");
        marker.setAttribute("altitude-mode", "RELATIVE_TO_GROUND");
        marker.setAttribute("title", attraction.name);
        marker.setAttribute("interactive", "true"); // ✅ this makes it clickable
        marker.style.cursor = "pointer";


        // --- Marker click event ---
        marker.addEventListener("click", () => {
          const popup = document.createElement("div");
          popup.innerHTML = `
            <div class="p-2" style="max-width:220px">
              ${attraction.photo_profile 
                ? `<img src="/storage/${attraction.photo_profile}" style="width:100%;border-radius:8px;margin-bottom:8px;">`
                : ""}
              <h6>${attraction.name}</h6>
              <p>${attraction.desc.substring(0, 80)}...</p>
              <a href="/objek-wisata/${attraction.id}" target="_blank" class="btn btn-sm btn-primary">Lihat Detail</a>
            </div>
          `;

          // Simple floating popup (custom, not InfoWindow)
          const existing = document.querySelector(".map-popup");
          if (existing) existing.remove();
          popup.className = "map-popup position-absolute bg-white shadow rounded p-2";
          popup.style.top = "20px";
          popup.style.left = "20px";
          popup.style.zIndex = 9999;
          document.getElementById("map-container").appendChild(popup);
        });

        map3d.appendChild(marker);
      }
    });

    setupSearch(map3d, attractions);
  }

  function setupSearch(map3d, attractions) {
    const searchBox = document.getElementById("search-box");
    const suggestions = document.getElementById("suggestions");

    searchBox.addEventListener("input", function() {
      const query = this.value.toLowerCase();
      suggestions.innerHTML = "";

      if (query.length > 0) {
        const matches = attractions.filter(a =>
          a.name.toLowerCase().includes(query)
        );

        if (matches.length > 0) {
          suggestions.style.display = "block";
          matches.forEach(a => {
            const div = document.createElement("div");
            div.textContent = a.name;
            div.addEventListener("click", () => {
              map3d.setAttribute("center", `${a.latitude},${a.longitude}`);
              map3d.setAttribute("tilt", "70");
              map3d.setAttribute("heading", "45");
              map3d.setAttribute("range", "3000");
              suggestions.style.display = "none";
              searchBox.value = a.name;
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

    document.addEventListener("click", (e) => {
      if (!searchBox.contains(e.target) && !suggestions.contains(e.target)) {
        suggestions.style.display = "none";
      }
    });
  }
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
