document.addEventListener('DOMContentLoaded', function () {
    // Ambil ID objek wisata dari URL
    const params = new URLSearchParams(window.location.search);
    const objekId = params.get('id');

    // Data objek wisata (biasanya bisa diambil dari database atau API)
    const objekWisataData = [
      { id: 1, name: 'Pantai Tanjung', image_url: 'assets/img/tanjung.jpg', description: 'Pantai dengan pemandangan indah.', jam_buka: '07:00 - 17:00', harga_tiket: 'Rp 50.000', fasilitas: 'Parkir, WC, Restoran, Wi-Fi' },
      { id: 2, name: 'Gunung Luwuk', image_url: 'assets/img/gunung.jpg', description: 'Pendakian gunung yang menantang.', jam_buka: '24 Jam', harga_tiket: 'Rp 30.000', fasilitas: 'Parkir, Toilet' },
      { id: 3, name: 'Museum Banggai', image_url: 'assets/img/museum.jpg', description: 'Museum dengan koleksi sejarah menarik.', jam_buka: '08:00 - 16:00', harga_tiket: 'Rp 20.000', fasilitas: 'Toilet, Wi-Fi, Parkir' },
      { id: 4, name: 'Taman Alam', image_url: 'assets/img/taman.jpg', description: 'Taman dengan suasana alami dan asri.', jam_buka: '07:00 - 18:00', harga_tiket: 'Rp 10.000', fasilitas: 'Parkir, Toilet, Ruang Bilas' },
    ];

    // Cari objek wisata yang sesuai dengan ID
    const objek = objekWisataData.find(item => item.id == objekId);

    // Jika objek wisata ditemukan, tampilkan detailnya
    if (objek) {
        document.getElementById('objekName').innerText = objek.name;
        document.getElementById('objekDescription').innerText = objek.description;
        document.getElementById('objekJamBuka').innerText = objek.jam_buka;
        document.getElementById('objekHargaTiket').innerText = objek.harga_tiket;
        document.getElementById('objekFasilitas').innerText = objek.fasilitas;
        document.getElementById('objekImage').src = objek.image_url;
    } else {
        // Jika objek tidak ditemukan
        document.getElementById('detailObjekSection').innerHTML = '<p class="text-center">Objek wisata tidak ditemukan.</p>';
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const toggleDarkMode = document.getElementById('toggleDarkMode');
  
    // Set dark mode if stored
    if (localStorage.getItem('darkMode') === 'enabled') {
      document.body.classList.add('dark-mode');
    }
  
    toggleDarkMode.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
      if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('darkMode', 'enabled');
      } else {
        localStorage.setItem('darkMode', 'disabled');
      }
    });
  });
  