<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - SIG Pariwisata</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #ffe6e1, #ffd8ce);
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .register-card {
      background-color: #fff;
      padding: 2.5rem 2rem;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 420px;
      text-align: center;
    }

    .register-card h4 {
      color: #e26d5c;
      font-weight: 600;
      margin-bottom: 1.5rem;
    }

    .form-control {
      border-radius: 8px;
    }

    .btn-register {
      background-color: #e26d5c;
      color: #fff;
      border: none;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }

    .btn-register:hover {
      background-color: #d15345;
    }

    .icon-circle {
      width: 65px;
      height: 65px;
      background-color: #fdded8;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
    }

    .icon-circle i {
      font-size: 1.8rem;
      color: #e26d5c;
    }

    .form-label {
      text-align: left;
      display: block;
      font-weight: 500;
    }

    .text-small {
      font-size: 0.9rem;
    }

    .alert {
      text-align: left;
    }

    @media (max-width: 576px) {
      .register-card {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>
<body>

<div class="register-card">
  <div class="icon-circle">
    <i class="bi bi-person-plus-fill"></i>
  </div>
  <h4>Daftar</h4>

  {{-- Success message --}}
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  {{-- Error message --}}
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  {{-- Validation errors --}}
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('register-proses') }}">
    @csrf

    <div class="mb-3 text-start">
      <label for="name" class="form-label">Nama Lengkap</label>
      <input type="text" class="form-control" id="name" name="name" placeholder="Nama Anda"
             value="{{ old('name') }}" required>
    </div>

    <div class="mb-3 text-start">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com"
             value="{{ old('email') }}" required>
    </div>

    <div class="mb-3 text-start">
      <label for="password" class="form-label">Kata Sandi</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
    </div>

    <div class="mb-3 text-start">
      <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
             placeholder="••••••••" required>
    </div>

    <div class="d-grid mb-3">
      <button type="submit" class="btn btn-register">Daftar</button>
    </div>

    <div class="text-small">
      Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </div>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
