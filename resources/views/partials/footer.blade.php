<!-- Footer -->
<footer class="bg-danger text-white mt-5 shadow-sm">
  <div class="container py-4">
    <div class="row">
      <!-- Logo & Title -->
      <div class="col-md-4 mb-3">
        <div class="d-flex align-items-center mb-2">
          <img src="{{ asset('assets/images/Banggai-removebg-preview.png') }}" 
               alt="Logo" width="40" height="40" class="me-2">
          <h5 class="mb-0 fw-bold">SIG Banggai</h5>
        </div>
        <p class="small">
          Sistem Informasi Geografis Kabupaten Banggai untuk informasi wisata, berita, kegiatan, dan peta interaktif.
        </p>
      </div>

      <!-- Quick Links -->
      <div class="col-md-4 mb-3">
        <h6 class="fw-bold">Navigasi</h6>
        <ul class="list-unstyled">
          <li><a href="{{ url('/') }}" class="text-white text-decoration-none">Home</a></li>
          <li><a href="#mapsSection" class="text-white text-decoration-none">Maps</a></li>
          <li><a href="{{ url('/objek-wisata') }}" class="text-white text-decoration-none">Objek Wisata</a></li>
          <li><a href="{{ url('/berita') }}" class="text-white text-decoration-none">Berita</a></li>
          <li><a href="{{ url('/gallery') }}" class="text-white text-decoration-none">Gallery</a></li>
          <li><a href="{{ url('/kegiatan') }}" class="text-white text-decoration-none">Kegiatan</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="col-md-4 mb-3">
        <h6 class="fw-bold">Kontak</h6>
        <p class="small mb-1"><i class="bi bi-geo-alt-fill me-2"></i>Banggai, Sulawesi Tengah</p>
        <p class="small mb-1"><i class="bi bi-envelope-fill me-2"></i>info@banggai.go.id</p>
        <p class="small"><i class="bi bi-telephone-fill me-2"></i>+62 123 456 789</p>

        <!-- Social Media -->
        <div>
          <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
          <a href="#" class="text-white"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Bar -->
  <div class="bg-dark text-center py-2 small">
    &copy; {{ date('Y') }} SIG Banggai. All Rights Reserved.
  </div>
</footer>
