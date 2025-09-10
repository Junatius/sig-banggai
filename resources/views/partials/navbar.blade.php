<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-danger shadow-sm px-3">
  <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
    <img src="{{ asset('assets/images/Banggai-removebg-preview.png') }}" 
         alt="Logo" width="40" height="40" 
         class="d-inline-block align-text-top me-2"/>
    SIG Banggai
  </a>
  <button class="navbar-toggler border-0" type="button" 
          data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
    <ul class="navbar-nav align-items-lg-center">
      <li class="nav-item">
        <a class="nav-link px-3 py-2 rounded hover-shadow {{ request()->is('/') ? 'active fw-bold bg-white text-danger' : 'text-white' }}" 
           href="{{ url('/') }}">
          Home
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-3 py-2 rounded hover-shadow {{ request()->is('maps') ? 'active fw-bold bg-white text-danger' : 'text-white' }}" 
           href="{{ url('/maps') }}">
          Maps
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-3 py-2 rounded hover-shadow {{ request()->is('objek-wisata*') ? 'active fw-bold bg-white text-danger' : 'text-white' }}" 
           href="{{ url('/objek-wisata') }}">
          Objek Wisata
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-3 py-2 rounded hover-shadow {{ request()->is('berita*') ? 'active fw-bold bg-white text-danger' : 'text-white' }}" 
           href="{{ url('/berita') }}">
          Berita
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-3 py-2 rounded hover-shadow {{ request()->is('gallery*') ? 'active fw-bold bg-white text-danger' : 'text-white' }}" 
           href="{{ url('/gallery') }}">
          Gallery
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link px-3 py-2 rounded hover-shadow {{ request()->is('kegiatan*') ? 'active fw-bold bg-white text-danger' : 'text-white' }}" 
           href="{{ url('/kegiatan') }}">
          Kegiatan
        </a>
      </li>

      @guest
        <li class="nav-item ms-lg-3">
          <a class="btn btn-light fw-semibold px-4 py-2 rounded-pill shadow-sm" 
             href="{{ route('login') }}">
            Login
          </a>
        </li>
      @else
        <li class="nav-item dropdown ms-lg-3">
          <a class="nav-link dropdown-toggle fw-semibold px-3 py-2 rounded {{ request()->is('profile') || request()->is('dashboard*') ? 'active bg-white text-danger' : 'text-white' }}" 
             href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle"></i> {{ Auth::user()->username ?? 'User' }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li>
              <a class="dropdown-item {{ request()->is('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                <i class="bi bi-person"></i> Profile
              </a>
            </li>
            @if(in_array(Auth::user()->role, ['dinas_pariwisata', 'pengelola']))
              <li>
                @if (Auth::user()->role === 'dinas_pariwisata')
                  <a class="dropdown-item {{ request()->is('dashboard/users*') ? 'active' : '' }}" href="{{ route('dashboard.users.index') }}">  
                @endif
                @if (Auth::user()->role === 'pengelola')    
                  <a class="dropdown-item {{ request()->is('dashboard/attractions*') ? 'active' : '' }}" href="{{ route('dashboard.attractions.show.pengelola') }}">  
                @endif
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
    </ul>
  </div>
</nav>
