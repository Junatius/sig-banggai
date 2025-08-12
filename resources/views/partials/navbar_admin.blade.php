<!-- Navbar Dashboard -->
<nav class="navbar navbar-expand-lg px-3" style="background-color: #0d6efd;">
    <a class="navbar-brand text-white fw-bold" href="{{ route('dashboard.users.index') }}">
        <img src="{{ asset('assets/images/Banggai-removebg-preview.png') }}" alt="Logo" width="40" height="40" class="d-inline-block align-text-top me-2"/>
        Dashboard SIG Banggai
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#dashboardNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="dashboardNavbar">
        <ul class="navbar-nav">
            {{-- Manajemen User - hanya untuk dinas_pariwisata --}}
            @if(Auth::user()->role === 'dinas_pariwisata')
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('dashboard.users.index') }}">
                        <i class="bi bi-people"></i> Manajemen User
                    </a>
                </li>
            @endif

            {{-- List Kecamatan - hanya untuk dinas_pariwisata --}}
            @if(Auth::user()->role === 'dinas_pariwisata')
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('dashboard.subdistricts.index') }}">
                        <i class="bi bi-geo-alt"></i> List Kecamatan
                    </a>
                </li>
            @endif

            {{-- Informasi Pariwisata - hanya untuk pengelola --}}
            @if(Auth::user()->role === 'pengelola')
                <li class="nav-item">
                    {{-- <a class="nav-link text-white" href="{{ route('my-tourism.info') }}"> --}}
                    <a class="nav-link text-white" href="#">
                        <i class="bi bi-building"></i> Informasi Pariwisata
                    </a>
                </li>
            @endif

            {{-- Manajemen Galeri - hanya untuk dinas_pariwisata --}}
            @if(Auth::user()->role === 'dinas_pariwisata')
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('dashboard.galleries.index') }}">
                        <i class="bi bi-images"></i> Manajemen Galeri
                    </a>
                </li>
            @endif

            {{-- Data Pariwisatawan - hanya untuk dinas_pariwisata --}}
            @if(Auth::user()->role === 'dinas_pariwisata')
                <li class="nav-item">
                    {{-- <a class="nav-link text-white" href="{{ route('tourists.index') }}"> --}}
                    <a class="nav-link text-white" href="#">
                        <i class="bi bi-people-fill"></i> Data Pariwisatawan
                    </a>
                </li>
            @endif

            {{-- Manajemen Berita - untuk kedua role --}}
            @if(in_array(Auth::user()->role, ['dinas_pariwisata', 'pengelola']))
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('dashboard.news.index') }}">
                        <i class="bi bi-newspaper"></i> Manajemen Berita
                    </a>
                </li>
            @endif

            {{-- Beranda --}}
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ url('/') }}">
                    <i class="bi bi-house-door"></i> Beranda
                </a>
            </li>

            {{-- Dropdown User --}}
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
        </ul>
    </div>
</nav>
