document.getElementById("uploadForm").addEventListener("submit", function (e) {
    e.preventDefault();
  
    const fileInput = document.getElementById("file");
    const captionInput = document.getElementById("caption");
    const gallery = document.getElementById("galleryContainer");
  
    const file = fileInput.files[0];
    const caption = captionInput.value;
  
    if (!file || !caption) {
      alert("File dan caption wajib diisi.");
      return;
    }
  
    const reader = new FileReader();
    reader.onload = function (event) {
      const item = document.createElement("div");
      item.classList.add("gallery-item");
  
      if (file.type.startsWith("video/")) {
        item.innerHTML = `
          <video controls>
            <source src="${event.target.result}" type="${file.type}">
            Your browser does not support the video tag.
          </video>
          <p>${caption}</p>
        `;
      } else {
        item.innerHTML = `
          <img src="${event.target.result}" alt="${caption}" />
          <p>${caption}</p>
        `;
      }
  
      gallery.prepend(item); // Tambahkan ke atas galeri
      fileInput.value = "";
      captionInput.value = "";
    };
    reader.readAsDataURL(file);
  });
  