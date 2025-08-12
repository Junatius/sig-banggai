// Menutup dropdown setelah item dipilih
const dropdownItems = document.querySelectorAll('.dropdown-item');
dropdownItems.forEach(item => {
  item.addEventListener('click', () => {
    const dropdownMenu = item.closest('.dropdown-menu');
    const dropdownToggle = dropdownMenu.closest('.nav-item').querySelector('.dropdown-toggle');
    // Menutup dropdown setelah klik
    dropdownToggle.classList.remove('show');
    dropdownMenu.classList.remove('show');
  });
});

document.getElementById("toggleDarkMode").addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");
  
    const navbar = document.querySelector(".navbar");
    navbar.classList.toggle("navbar-dark-mode");
  
    // Ganti teks jika mau
    this.textContent = document.body.classList.contains("dark-mode")
      ? "Light Mode"
      : "Dark Mode";
  });

  