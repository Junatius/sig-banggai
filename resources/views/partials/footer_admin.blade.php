<!-- Footer -->
<footer class="bg-blue-800 text-white mt-10">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">

            <!-- Logo + Title -->
            <div>
                <div class="flex items-center justify-center md:justify-start gap-3">
                    <img src="{{ asset('assets/images/Banggai-removebg-preview.png') }}" 
                         alt="Logo" class="w-16 h-16 object-contain"/>
                    <span class="text-xl font-bold">Dashboard SIG Banggai</span>
                </div>
                <p class="mt-3 text-sm text-gray-300 leading-relaxed">
                    Sistem Informasi Geografis Pariwisata Kabupaten Banggai.
                </p>
            </div>

            <!-- Menu Links -->
            <div>
                <h4 class="font-semibold text-lg mb-3 border-b border-blue-600 inline-block pb-1">Navigasi</h4>
                <ul class="space-y-2 text-sm">
                    @if(Auth::user()->role === 'dinas_pariwisata')
                        <li><a href="{{ route('dashboard.users.index') }}" class="hover:text-gray-200 transition">User</a></li>
                        <li><a href="{{ route('dashboard.subdistricts.index') }}" class="hover:text-gray-200 transition">Kecamatan</a></li>
                        <li><a href="{{ route('dashboard.galleries.index') }}" class="hover:text-gray-200 transition">Galeri</a></li>
                        <li><a href="{{ route('dashboard.tourists.index') }}" class="hover:text-gray-200 transition">Wisatawan</a></li>
                        <li><a href="{{ route('dashboard.attractions.index') }}" class="hover:text-gray-200 transition">Tempat Wisata</a></li>
                    @endif

                    @if(Auth::user()->role === 'pengelola')
                        <li><a href="{{ route('dashboard.attractions.show.pengelola') }}" class="hover:text-gray-200 transition">Informasi Pariwisata</a></li>
                    @endif

                    @if(in_array(Auth::user()->role, ['dinas_pariwisata', 'pengelola']))
                        <li><a href="{{ route('dashboard.news.index') }}" class="hover:text-gray-200 transition">Berita</a></li>
                        <li><a href="{{ route('dashboard.events.index') }}" class="hover:text-gray-200 transition">Event</a></li>
                    @endif

                    <li><a href="{{ url('/') }}" class="hover:text-gray-200 transition">Beranda</a></li>
                </ul>
            </div>

            <!-- User Menu -->
            <div>
                <h4 class="font-semibold text-lg mb-3 border-b border-blue-600 inline-block pb-1">Akun</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('profile') }}" class="hover:text-gray-200 transition">Profil</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="hover:text-gray-200 transition">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom -->
        <div class="border-t border-blue-700 mt-8 pt-4 text-center text-xs text-gray-400">
            © {{ date('Y') }} Dashboard SIG Banggai. All rights reserved.
        </div>
    </div>
</footer>
