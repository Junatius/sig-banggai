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
<!-- Kecamatan Section -->
<section id="kecamatan" class="py-5">
  <div class="container">
    <h2 class="text-center mb-4">Daftar Kecamatan di Kabupaten Banggai</h2>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
      @foreach($subdistricts as $subdistrict)
        <div class="col">
          <div class="card kecamatan-card text-center p-3 h-100 shadow-sm">
            <h5 class="card-title">{{ $subdistrict->name }}</h5>
            <p class="text-muted mb-1">Wilayah administratif</p>
            <p class="card-text">Terdaftar diwebsite sejak <br/> {{ \Carbon\Carbon::parse($subdistrict->created_at)->translatedFormat('d F Y') }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

  @include('partials.footer') {{-- You can modularize footer if reused --}}

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
