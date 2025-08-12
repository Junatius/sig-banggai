    <!-- Navbar -->
  <nav class="navbar navbar-expand-lg custom-navbar px-3">
    <a class="navbar-brand text-white fw-bold" href="#">
      <img src="{{ asset('assets/images/Banggai-removebg-preview.png') }}" alt="Logo" width="40" height="40" class="d-inline-block align-text-top me-2"/>
      SIG Banggai
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link btn btn-link text-white" href="{{ url('/') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link btn btn-link text-white" href="#mapsSection">Maps</a></li>
        <li class="nav-item"><a class="nav-link btn btn-link text-white" href="{{ url('/objek-wisata') }}">Objek Wisata</a></li>
        <li class="nav-item"><a class="nav-link btn btn-link text-white" href="{{ url('/berita') }}">Berita</a></li>
        <li class="nav-item"><a class="nav-link btn btn-link text-white" href="{{ url('/gallery') }}">Gallery</a></li>
        <li class="nav-item"><a class="nav-link btn btn-link text-white" href="{{ url('/kegiatan') }}">Kegiatan</a></li>
        @guest
            <li class="nav-item">
                <a class="nav-link btn btn-info text-white" href="{{ route('login') }}">Login</a>
            </li>
        @else
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i> {{ Auth::user()->username ?? 'User' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile') }}">
                            <i class="bi bi-person"></i> Profile
                        </a>
                    </li>
                    @if(in_array(Auth::user()->role, ['dinas_pariwisata', 'pengelola']))
                        <li>
                            <a class="dropdown-item" href="{{ route('dashboard.users.index') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                    @endif
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        @endguest
        {{-- <li class="nav-item"><button class="nav-link btn btn-link text-white" href="javascript:void(0);" id="toggleDarkMode">Dark Mode</button></li> --}}
      </ul>
    </div>
  </nav>
