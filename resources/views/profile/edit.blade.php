<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Edit Profil</title>
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
  .btn-save {
    background-color: #e26d5c;
    color: white;
    border: none;
  }
  .btn-save:hover {
    background-color: #d15345;
  }
</style>
</head>
<body>
<div class="wrapper">
  <div class="top-bar">
    <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">
      &larr; Kembali
    </a>
  </div>
  <div class="content">
    <div class="card shadow">
      <h4 class="mb-4 text-center">Edit Profil</h4>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <div class="mb-3">
          <label class="form-label">Nama Pengguna</label>
          <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        @if ($user->role === 'pengelola_pariwisata' && $attraction)
          <div class="mb-3">
            <label class="form-label">Nama Objek Wisata</label>
            <input type="text" class="form-control" value="{{ $attraction->name }}" disabled>
          </div>

          <div class="mb-3">
            <label class="form-label">Kontak Objek Wisata</label>
            <input type="text" name="contact" class="form-control" value="{{ old('contact', $attraction->contact) }}" required>
          </div>
        @endif

        <div class="mb-3">
          <label class="form-label">Kata Sandi Baru</label>
          <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak ingin mengubah">
        </div>

        <div class="mb-3">
          <label class="form-label">Konfirmasi Kata Sandi</label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru">
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-save">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
