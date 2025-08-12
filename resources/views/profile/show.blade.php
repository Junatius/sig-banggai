<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Profil Saya</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
    background: linear-gradient(135deg, #ffe6e1, #ffd8ce);
    min-height: 100vh;
  }
  .wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }
  .top-bar {
    padding: 1rem;
  }
  .content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .card {
    border-radius: 15px;
    padding: 2rem;
    max-width: 500px;
    width: 100%;
  }
  .btn-edit {
    background-color: #e26d5c;
    color: white;
    border: none;
  }
  .btn-edit:hover {
    background-color: #d15345;
  }
</style>
</head>
<body>
<div class="wrapper">
  <div class="top-bar">
    <a href="{{ url("/") }}" class="btn btn-light btn-sm">
      &larr; Kembali
    </a>
  </div>
  <div class="content">
    <div class="card shadow">
      <h4 class="mb-4 text-center">Profil Saya</h4>

      <p><strong>Nama Pengguna:</strong> {{ $user->username }}</p>
      <p><strong>Email:</strong> {{ $user->email }}</p>

      @if ($user->role === 'pengelola_pariwisata' && $attraction)
        <p><strong>Nama Objek Wisata:</strong> {{ $attraction->name }}</p>
        <p><strong>Kontak Objek Wisata:</strong> {{ $attraction->contact }}</p>
      @endif

      <div class="d-grid">
        <a href="{{ route('profile.edit') }}" class="btn btn-edit">Edit Profil</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
