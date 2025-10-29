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
  <header
    id="homeSection"
    class="hero-header relative flex items-center justify-center text-center text-white min-h-screen bg-cover bg-center"
    style="background-image: url('{{ asset('assets/images/hero_background.jpg') }}');"
  >
    <!-- Optional overlay -->
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 container mx-auto px-4">
        <h1 class="text-3xl md:text-5xl font-bold mb-4">
            Selamat datang di SIG Pariwisata Kabupaten Banggai
        </h1>
        <p class="text-lg md:text-xl">
            Informasi lengkap tentang objek wisata daerah Banggai.
        </p>
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

  <!-- ======= Section 1: Objek Wisata ======= -->
  <section id="attractionsSection" class="container my-5">
    <div class="text-center mb-5">
      <h2 class="text-2xl md:text-3xl font-bold mb-3">Objek Wisata Populer</h2>
      <p class="text-gray-600">Temukan keindahan wisata unggulan di Kabupaten Banggai</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
      @foreach ($attractions->take(5) as $attraction)
        <div class="col">
          <div class="card h-100 shadow hover:shadow-lg transition rounded-lg overflow-hidden">
            <a href="{{ url('/objek-wisata/' . $attraction->id) }}" class="text-decoration-none text-dark">
              <img src="{{ asset('storage/' . $attraction->photo_profile) }}" 
                   class="card-img-top object-cover h-48 w-100" 
                   alt="{{ $attraction->name }}">
              <div class="card-body text-center">
                <h5 class="card-title font-semibold mb-2">{{ $attraction->name }}</h5>
                <p class="card-text text-sm text-gray-600">
                  {{ $attraction->price ? 'Rp ' . number_format($attraction->price, 0, ',', '.') : 'Gratis' }}
                </p>
              </div>
            </a>
          </div>
        </div>
      @endforeach
    </div>

    <div class="text-center mt-5">
      <a href="{{ url('/objek-wisata') }}" class="btn btn-outline-primary px-4 py-2 rounded">
        Lihat Selengkapnya
      </a>
    </div>
  </section>

  <!-- ======= Section 2: Berita Terbaru ======= -->
  <section id="newsSection" class="container my-5">
    <div class="text-center mb-5">
      <h2 class="text-2xl md:text-3xl font-bold mb-3">Berita Terbaru</h2>
      <p class="text-gray-600">Update informasi terbaru seputar pariwisata Banggai</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
      @foreach ($news->take(5) as $item)
        <div class="col">
          <div class="card h-100 shadow hover:shadow-lg transition rounded-lg overflow-hidden">
            <a href="{{ url('/berita/' . $item->id) }}" class="text-decoration-none text-dark">
              <img src="{{ asset('storage/' . $item->photo_url) }}" 
                   class="card-img-top object-cover h-48 w-100" 
                   alt="{{ $item->title }}">
              <div class="card-body">
                <h5 class="card-title font-semibold mb-2">{{ Str::limit($item->title, 40) }}</h5>
                <p class="text-sm text-gray-600 mb-1">
                  {{ $item->user->username ?? 'Admin' }}
                </p>
                <p class="text-xs text-muted">
                  {{ $item->created_at->diffForHumans() }}
                </p>
              </div>
            </a>
          </div>
        </div>
      @endforeach
    </div>

    <div class="text-center mt-5">
      <a href="{{ url('/berita') }}" class="btn btn-outline-primary px-4 py-2 rounded">
        Lihat Selengkapnya
      </a>
    </div>
  </section>

  @include('partials.footer') {{-- You can modularize footer if reused --}}

  <!-- Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/script.js') }}"></script>
</body>
</html>
