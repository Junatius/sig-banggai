<!-- Navbar Dashboard (Tailwind) -->
<nav class="bg-blue-800 shadow-md">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            {{-- Logo and Title --}}
            <a href="{{ route('dashboard.users.index') }}" class="flex items-center gap-1 text-white font-semibold hover:opacity-90">
                <img src="{{ asset('assets/images/Banggai-removebg-preview.png') }}" alt="Logo" class="w-20 h-10 object-contain"/>
                <span class="text-lg hidden sm:inline">Dashboard SIG Banggai</span>
            </a>

            {{-- Mobile Menu Button --}}
            <button id="navbar-toggle" class="md:hidden text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Menu Items --}}
            <ul id="navbar-menu" class="hidden md:flex items-center space-x-4 pt-3 font-medium">
                
                {{-- Manajemen User --}}
                @if(Auth::user()->role === 'dinas_pariwisata')
                    <li>
                        <a href="{{ route('dashboard.users.index') }}" 
                           class="flex items-center gap-1 px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition">
                            <i class="bi bi-people"></i> User
                        </a>
                    </li>
                @endif

                {{-- List Kecamatan --}}
                @if(Auth::user()->role === 'dinas_pariwisata')
                    <li>
                        <a href="{{ route('dashboard.subdistricts.index') }}" 
                           class="flex items-center gap-1 px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition">
                            <i class="bi bi-geo-alt"></i> Kecamatan
                        </a>
                    </li>
                @endif

                {{-- Informasi Pariwisata --}}
                @if(Auth::user()->role === 'pengelola')
                    <li>
                        <a href="{{ route('dashboard.attractions.show') }}" 
                           class="flex items-center gap-1 px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition">
                            <i class="bi bi-building"></i> Informasi Pariwisata
                        </a>
                    </li>
                @endif

                {{-- Manajemen Galeri --}}
                @if(Auth::user()->role === 'dinas_pariwisata')
                    <li>
                        <a href="{{ route('dashboard.galleries.index') }}" 
                           class="flex items-center gap-1 px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition">
                            <i class="bi bi-images"></i> Galeri
                        </a>
                    </li>
                @endif

                {{-- Data Pariwisatawan --}}
                @if(Auth::user()->role === 'dinas_pariwisata')
                    <li>
                        <a href="{{ route('dashboard.tourists.index') }}" 
                           class="flex items-center gap-1 px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition">
                            <i class="bi bi-people-fill"></i> Wisatawan
                        </a>
                    </li>
                @endif

                {{-- Manajemen Berita --}}
                @if(in_array(Auth::user()->role, ['dinas_pariwisata', 'pengelola']))
                    <li>
                        <a href="{{ route('dashboard.news.index') }}" 
                           class="flex items-center gap-1 px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition">
                            <i class="bi bi-newspaper"></i> Berita
                        </a>
                    </li>
                @endif

                {{-- Informasi Tempat Wisata --}}
                @if(Auth::user()->role === 'dinas_pariwisata')
                    <li>
                        <a href="{{ route('dashboard.attractions.index') }}" 
                           class="flex items-center gap-1 px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition">
                            <i class="bi bi-map"></i> Tempat Wisata
                        </a>
                    </li>
                @endif

                {{-- Event --}}
                @if(in_array(Auth::user()->role, ['dinas_pariwisata', 'pengelola']))
                    <li>
                        <a href="{{ route('dashboard.events.index') }}" 
                           class="flex items-center gap-1 px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition">
                            <i class="bi bi-calendar-event"></i> Event
                        </a>
                    </li>
                @endif

                {{-- Beranda --}}
                <li>
                    <a href="{{ url('/') }}" 
                       class="flex items-center gap-1 px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition">
                        <i class="bi bi-house-door"></i> Beranda
                    </a>
                </li>

                {{-- Dropdown User --}}
                <li class="relative">
                    <button id="user-menu-btn" class="flex items-center gap-1 px-3 py-2 rounded-lg text-white hover:bg-blue-700 transition focus:outline-none">
                        <i class="bi bi-person-circle"></i> {{ Auth::user()->username ?? 'User' }}
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul id="user-menu" class="absolute right-0 mt-2 w-44 bg-white text-gray-700 rounded-xl shadow-lg hidden">
                        <li>
                            <a href="{{ route('profile') }}" class="block py-2 hover:bg-gray-100 rounded-t-xl">
                                <i class="bi bi-person"></i> Profile
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left py-2 hover:bg-gray-100 rounded-b-xl">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle
    document.getElementById('navbar-toggle').addEventListener('click', () => {
        document.getElementById('navbar-menu').classList.toggle('hidden');
    });

    // User dropdown toggle
    const userMenuBtn = document.getElementById('user-menu-btn');
    const userMenu = document.getElementById('user-menu');

    userMenuBtn.addEventListener('click', () => {
        userMenu.classList.toggle('hidden');
    });

    // Close dropdown if clicked outside
    document.addEventListener('click', (e) => {
        if (!userMenuBtn.contains(e.target) && !userMenu.contains(e.target)) {
            userMenu.classList.add('hidden');
        }
    });
</script>
