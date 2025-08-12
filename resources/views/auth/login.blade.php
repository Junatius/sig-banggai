<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - SIG Pariwisata</title>
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

    .login-card {
      background-color: #fff;
      padding: 2.5rem 2rem;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      width: 100%;
      max-width: 420px;
      text-align: center;
    }

    .login-card h4 {
      color: #e26d5c;
      font-weight: 600;
      margin-bottom: 1.5rem;
    }

    .form-control {
      border-radius: 8px;
    }

    .btn-login {
      background-color: #e26d5c;
      color: #fff;
      border: none;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }

    .btn-login:hover {
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

    @media (max-width: 576px) {
      .login-card {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>
<body>

<div class="login-card">
  <div class="icon-circle">
    <i class="bi bi-person-fill"></i>
  </div>
  <h4>Login</h4>

  {{-- Notifikasi --}}
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if (session('failed'))
    <div class="alert alert-danger">{{ session('failed') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('login.proses') }}">
    @csrf
    <div class="mb-3 text-start">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email"
             value="{{ old('email') }}" placeholder="email@example.com" required>
    </div>

    <div class="mb-3 text-start">
      <label for="password" class="form-label">Kata Sandi</label>
      <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
    </div>

    <div class="mb-3 text-end text-small">
      <a href="#">Lupa kata sandi?</a>
    </div>

    <div class="d-grid mb-3">
      <button type="submit" class="btn btn-login">Masuk</button>
    </div>

    <div class="text-small">
      Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
    </div>
  </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
