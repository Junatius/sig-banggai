<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SIG Pariwisata Banggai</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

  @include('partials.navbar') {{-- You can modularize navbar if reused --}}

  <!-- Header Section with background image -->
  <header class="hero-header d-flex align-items-center" id="homeSection">
    <div class="container text-white text-center">
      <h1>Selamat datang di SIG Pariwisata Kabupaten Banggai</h1>
      <p>Informasi lengkap tentang objek wisata daerah Banggai.</p>
    </div>
  </header>

  <!-- About Section -->
  <section id="aboutSection" class="container my-5">
    <h2 class="text-center mb-4">Tentang Kabupaten Banggai</h2>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
      <!-- Card Sejarah dan Asal Usul -->
      <div class="col">
        <div class="card h-100 shadow-lg">
          <img src="{{ asset('assets/images/history.jpg') }}" class="card-img-top" alt="Sejarah Banggai">
          <div class="card-body">
            <h5 class="card-title">Sejarah dan Asal Usul</h5>
            <p class="card-text">Kabupaten Banggai memiliki sejarah panjang yang berakar dari kebudayaan lokal dan pengaruh berbagai kerajaan yang pernah ada. Asal usul Banggai dimulai dari daerah pesisir yang berkembang pesat sejak masa kolonial.</p>
          </div>
        </div>
      </div>

      <!-- Card Letak dan Kondisi Wilayah -->
      <div class="col">
        <div class="card h-100 shadow-lg">
          <img src="{{ asset('assets/images/location.jpg') }}" class="card-img-top" alt="Letak Wilayah Banggai">
          <div class="card-body">
            <h5 class="card-title">Letak dan Kondisi Wilayah</h5>
            <p class="card-text">Kabupaten Banggai terletak di bagian utara Pulau Sulawesi, dengan kondisi geografis yang beragam, mulai dari daerah pesisir hingga pegunungan.</p>
          </div>
        </div>
      </div>

      <!-- Card Budaya dan Adat Istiadat -->
      <div class="col">
        <div class="card h-100 shadow-lg">
          <img src="{{ asset('assets/images/budaya.jpg') }}" class="card-img-top" alt="Budaya dan Adat Istiadat">
          <div class="card-body">
            <h5 class="card-title">Budaya dan Adat Istiadat</h5>
            <p class="card-text">Budaya Banggai kaya dengan tradisi dan adat istiadat yang diwariskan secara turun temurun. Beberapa di antaranya adalah upacara adat dan tarian tradisional yang masih dilestarikan hingga kini.</p>
          </div>
        </div>
      </div>

      <!-- Card Potensi dan Sumber Daya Alam -->
      <div class="col">
        <div class="card h-100 shadow-lg">
          <img src="{{ asset('assets/images/potensi.jpg') }}" class="card-img-top" alt="Potensi dan Sumber Daya Alam">
          <div class="card-body">
            <h5 class="card-title">Potensi dan Sumber Daya Alam</h5>
            <p class="card-text">Kabupaten Banggai memiliki potensi sumber daya alam yang melimpah, seperti tambang, hasil laut, serta hutan yang dapat dimanfaatkan untuk pembangunan ekonomi berkelanjutan.</p>
          </div>
        </div>
      </div>

      <!-- Card Perekonomian dan Mata Pencaharian -->
      <div class="col">
        <div class="card h-100 shadow-lg">
          <img src="{{ asset('assets/images/perekonomian.jpg') }}" class="card-img-top" alt="Perekonomian dan Mata Pencaharian">
          <div class="card-body">
            <h5 class="card-title">Perekonomian dan Mata Pencaharian</h5>
            <p class="card-text">Mata pencaharian utama masyarakat Banggai adalah pertanian, perikanan, dan perdagangan, dengan perekonomian yang terus berkembang pesat di sektor-sektor ini.</p>
          </div>
        </div>
      </div>

      <!-- Card Kecamatan di Kabupaten Banggai -->
      <div class="col">
        <div class="card h-100 shadow-lg">
          <img src="{{ asset('assets/images/kecamatan.jpg') }}" class="card-img-top" alt="Kecamatan Banggai">
          <div class="card-body">
            <h5 class="card-title">Kecamatan di Kabupaten Banggai</h5>
            <p class="card-text">Kabupaten Banggai terdiri dari berbagai kecamatan yang memiliki ciri khas budaya dan potensi wisata masing-masing. Setiap kecamatan memiliki daya tarik tersendiri bagi para wisatawan.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--Kecamatan di Kabupaten Banggai-->
  <section id="kecamatan" class="py-5">
    <div class="container">
      <h2 class="text-center mb-4">Daftar Kecamatan di Kabupaten Banggai</h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <!-- Contoh satu kecamatan -->
        <div class="col">
          <div class="card kecamatan-card text-center p-3 h-100">
            <h5 class="card-title">Kecamatan Luwuk</h5>
            <p class="text-muted mb-1">Terletak di wilayah tengah</p>
            <p class="card-text">Populasi sekitar 45.000 jiwa</p>
          </div>
        </div>
        <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
                <h5 class="card-title">Kecamatan Luwuk</h5>
                <p class="text-muted mb-1">Terletak di wilayah tengah</p>
                <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
        </div>
        <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div><div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div><div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
          <div class="col">
            <div class="card kecamatan-card text-center p-3 h-100">
              <h5 class="card-title">Kecamatan Luwuk</h5>
              <p class="text-muted mb-1">Terletak di wilayah tengah</p>
              <p class="card-text">Populasi sekitar 45.000 jiwa</p>
            </div>
          </div>
        <!-- Duplikat untuk 23 kecamatan lainnya -->
      </div>
    </div>
  </section>    

  <!-- Konten lainnya -->
  <div class="container my-5">
    <section id="mapsSection" class="mt-5">
      <h2>Peta Wisata</h2>
      <p>Menampilkan lokasi objek wisata secara interaktif.</p>
    </section>

    <section id="objekWisataSection" class="mt-5">
      <h2>Objek Wisata</h2>
      <p>Daftar lengkap destinasi wisata di Kabupaten Banggai.</p>
    </section>

    <section id="beritaSection" class="mt-5">
      <h2>Berita</h2>
      <p>Berita dan info terkini seputar pariwisata daerah.</p>
    </section>

    <section id="gallerySection" class="mt-5">
      <h2>Gallery</h2>
      <p>Kumpulan foto-foto menarik dari objek wisata.</p>
    </section>

    <section id="loginSection" class="mt-5">
      <h2>Login</h2>
      <form>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </section>
  </div>

  <!-- Footer -->
  <footer class="custom-footer mt-5">
    <div class="container py-4">
      <div class="row">
        <div class="col-md-4 mb-3">
          <h5>SIG Pariwisata Banggai</h5>
          <p>Website informasi geografis pariwisata untuk mempromosikan potensi wisata di Kabupaten Banggai.</p>
        </div>
        <div class="col-md-4 mb-3">
          <h5>Menu Navigasi</h5>
          <ul class="list-unstyled">
            <li><a href="{{ url('/') }}">Beranda</a></li>
            <li><a href="#about">Tentang</a></li>
            <li><a href="#kecamatan">Kecamatan</a></li>
            <li><a href="#galeri">Galeri</a></li>
            <li><a href="#kontak">Kontak</a></li>
          </ul>
        </div>
        <div class="col-md-4 mb-3">
          <h5>Kontak Kami</h5>
          <p>Email: <a href="mailto:dispar@banggai.go.id">dispar@banggai.go.id</a></p>
          <p>Telepon: (021) 123-4567</p>
          <p>Alamat: Jl. Jenderal Sudirman No.10, Luwuk</p>
          <div class="social-icons mt-3">
            <a href="https://facebook.com" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://instagram.com" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://youtube.com" target="_blank" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
      </div>
      <hr style="border-color: rgba(255,255,255,0.1);">
      <p class="text-center mb-0">&copy; 2025 ThesKind. All rights reserved.</p>
    </div>
  </footer>  
  
  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
