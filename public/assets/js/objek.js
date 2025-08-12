document.addEventListener('DOMContentLoaded', function () {
  const objekList = document.getElementById('objekList');
  const searchInput = document.getElementById('searchInput');
  const kecamatanFilter = document.getElementById('kecamatanFilter');
  const categoryFilter = document.getElementById('categoryFilter');
  const budgetFilter = document.getElementById('budgetFilter');
  const toggleDarkMode = document.getElementById('toggleDarkMode');

  let semuaObjekWisata = [];

  // Tampilkan objek wisata ke dalam HTML
  function displayObjekWisata(objek) {
      objekList.innerHTML = '';
      if (objek.length === 0) {
          objekList.innerHTML = '<p class="text-center">Tidak ada objek wisata yang sesuai.</p>';
          return;
      }

      objek.forEach(item => {
          // Ikon tahap usia
          let ikonUsia = "";
          if (item.usia === "anak") ikonUsia = "👶";
          else if (item.usia === "remaja") ikonUsia = "🧒";
          else if (item.usia === "keluarga") ikonUsia = "👨‍👩‍👧‍👦";

          // Ikon akses difabel
          let ikonAkses = item.aksesibilitas?.includes("difabel") ? "♿" : "";

          const card = document.createElement('div');
          card.classList.add('col-md-4', 'mb-4');
          card.innerHTML = `
              <div class="card shadow-sm h-100">
                  <img src="${item.image_url}" class="card-img-top" alt="${item.name}">
                  <div class="card-body">
                      <h5 class="card-title">${item.name}</h5>
                      <p class="card-text">
                          ${item.description.substring(0, 100)}...
                          <br><small>${ikonUsia} ${ikonAkses}</small>
                      </p>
                      <p class="text-muted">Kategori: ${item.category}</p>
                      <p class="text-muted">Kecamatan: ${item.lokasi}</p>
                      <a href="detail-objek.html?id=${item.id}" class="btn btn-danger">Lihat Detail</a>
                  </div>
              </div>
          `;
          objekList.appendChild(card);
      });
  }

  // Filter berdasarkan input pengguna
  function applyFilters() {
      const searchQuery = searchInput.value.toLowerCase();
      const selectedKecamatan = kecamatanFilter.value;
      const selectedCategory = categoryFilter.value;
      const selectedBudget = budgetFilter.value;

      const filteredData = semuaObjekWisata.filter(item => {
          const matchName = item.name.toLowerCase().includes(searchQuery);
          const matchKecamatan = selectedKecamatan ? item.lokasi === selectedKecamatan : true;
          const matchCategory = selectedCategory ? item.category === selectedCategory : true;
          const matchBudget = selectedBudget ? item.budget === selectedBudget : true;
          return matchName && matchKecamatan && matchCategory && matchBudget;
      });

      displayObjekWisata(filteredData);
  }

  // Event listener filter
  searchInput.addEventListener('input', applyFilters);
  kecamatanFilter.addEventListener('change', applyFilters);
  categoryFilter.addEventListener('change', applyFilters);
  budgetFilter.addEventListener('change', applyFilters);

  // Fetch data dari API
  fetch("http://localhost:8000/api/objek-wisata") // Ganti URL dengan API Laravel
      .then(res => res.json())
      .then(data => {
          semuaObjekWisata = data;
          displayObjekWisata(data);
      })
      .catch(err => {
          objekList.innerHTML = "<p class='text-danger'>Gagal memuat data objek wisata.</p>";
          console.error(err);
      });

  // Dark mode check saat pertama kali load
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
