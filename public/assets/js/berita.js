document.addEventListener("DOMContentLoaded", () => {
    const filterSelect = document.getElementById("categoryFilter");
    const searchInput = document.getElementById("searchInput");

    // Render awal
    renderBerita();

    // Saat filter berubah
    filterSelect.addEventListener("change", () => {
        renderBerita(filterSelect.value, searchInput.value);
    });

    // Saat mengetik di search
    searchInput.addEventListener("input", () => {
        renderBerita(filterSelect.value, searchInput.value);
    });

    // Scroll to berita section saat tombol "Lihat Berita" di header ditekan
    const lihatBeritaBtn = document.querySelector('.btn-navbar');
    lihatBeritaBtn.addEventListener("click", function (event) {
        event.preventDefault(); // Cegah aksi default anchor

        // Cari elemen dengan ID 'berita'
        const beritaSection = document.getElementById('berita');

        // Lakukan smooth scroll ke bagian berita
        beritaSection.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
});

const beritaData = [
    {
        judul: "Festival Budaya Banggai 2025",
        isi: "Perayaan budaya yang meriah akan diadakan di pusat kota dengan berbagai pertunjukan seni tradisional, kuliner khas Banggai, serta pameran kerajinan lokal. Acara ini bertujuan melestarikan budaya dan meningkatkan kunjungan wisatawan.",
        tanggal: "2025-04-28",
        view: 234,
        isPilihan: true,
        gambar: "assets/img/berita1.jpg"
    },
    {
        judul: "Objek Wisata Baru Dibuka",
        isi: "Objek wisata baru resmi dibuka untuk umum dengan fasilitas yang lengkap dan panorama alam yang menakjubkan. Lokasi ini diharapkan menjadi destinasi favorit baru di Kabupaten Banggai.",
        tanggal: "2025-04-30",
        view: 128,
        isPilihan: false,
        gambar: "assets/img/berita2.jpg"
    },
    {
        judul: "Pengumuman Jadwal Kegiatan",
        isi: "Berikut jadwal kegiatan resmi dari Dinas Pariwisata selama bulan Mei. Termasuk di dalamnya workshop budaya, pelatihan pemandu wisata, dan lomba fotografi wisata.",
        tanggal: "2025-04-20",
        view: 512,
        isPilihan: false,
        gambar: "assets/img/berita3.jpg"
    },
    {
        judul: "Konser Musik Tradisional",
        isi: "Musisi lokal akan tampil di acara musik tradisional di Pantai Kilo 5, menampilkan alat musik khas seperti gimba dan suling. Acara terbuka untuk umum dan gratis.",
        tanggal: "2025-04-29",
        view: 310,
        isPilihan: true,
        gambar: "assets/img/berita4.jpg"
    }
];

function renderBerita(filterKategori = "terbaru", keyword = "") {
    const container = document.getElementById("beritaContainer");
    container.innerHTML = "";

    let filtered = beritaData;

    // Pencarian
    if (keyword) {
        filtered = filtered.filter(b =>
            b.judul.toLowerCase().includes(keyword.toLowerCase()) ||
            b.isi.toLowerCase().includes(keyword.toLowerCase())
        );
    }

    // Filter kategori
    if (filterKategori === "terbaru") {
        filtered.sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));
    } else if (filterKategori === "populer") {
        filtered.sort((a, b) => b.view - a.view);
    } else if (filterKategori === "pilihan") {
        filtered = filtered.filter(b => b.isPilihan);
    }

    if (filtered.length === 0) {
        container.innerHTML = "<p class='text-center'>Tidak ada berita ditemukan.</p>";
        return;
    }

    filtered.forEach((berita, index) => {
        const card = `
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card card-berita shadow-sm h-100">
            <img src="${berita.gambar}" class="card-img-top" alt="${berita.judul}">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">${berita.judul}</h5>
              <p class="card-text">${berita.isi.substring(0, 80)}...</p>
              <small class="text-muted d-block mb-2">Tanggal: ${berita.tanggal}</small>
              <span class="badge bg-info">Views: ${berita.view}</span>
              ${berita.isPilihan ? '<span class="badge bg-success ms-2">Pilihan</span>' : ''}
              <button class="btn btn-sm btn-navbar mt-3 baca-btn" data-index="${index}" data-bs-toggle="modal" data-bs-target="#beritaModal">
                Baca Selengkapnya
              </button>
            </div>
          </div>
        </div>
      `;
        container.insertAdjacentHTML("beforeend", card);
    });

    // Event untuk tombol "Baca Selengkapnya"
    document.querySelectorAll(".baca-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            const index = this.getAttribute("data-index");
            const berita = filtered[index];

            document.getElementById("beritaModalLabel").textContent = berita.judul;
            document.getElementById("modalGambar").src = berita.gambar;
            document.getElementById("modalIsi").textContent = berita.isi;
            document.getElementById("modalTanggal").textContent = "Tanggal: " + berita.tanggal;
            document.getElementById("modalViews").textContent = "Views: " + berita.view;
        });
    });
}
