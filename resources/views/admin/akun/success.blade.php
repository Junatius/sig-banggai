@extends('partials.dashboard')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4">
                    <h5 class="mb-0">
                        <i class="bi bi-check-circle-fill me-2"></i> Akun Berhasil Dibuat
                    </h5>
                </div>
                <div class="card-body p-4">

                    <p class="text-muted text-center mb-4">Berikut adalah detail akun yang telah dibuat:</p>

                    <div class="mb-3">
                        <label class="fw-semibold text-dark">Nama:</label>
                        <div class="form-control-plaintext border rounded-3 px-3 py-2 bg-white fw-medium shadow-sm-sm">
                            {{ $user->username }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold text-dark">Email:</label>
                        <div class="form-control-plaintext border rounded-3 px-3 py-2 bg-white fw-medium shadow-sm-sm">
                            {{ $user->email }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-semibold text-dark">Password:</label>
                        <div class="input-group">
                            <input type="text" id="passwordText" class="form-control bg-white fw-medium" value="{{ $password }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyPassword()" title="Salin Password">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                        <small class="text-muted fst-italic">Simpan password ini dengan baik.</small>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('dashboard.users.index') }}" class="btn btn-success rounded-pill px-4 shadow-sm">
                            <i class="bi bi-house-door-fill me-1"></i> Selesai
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
function copyPassword() {
    let passText = document.getElementById("passwordText").value;
    navigator.clipboard.writeText(passText).then(() => {
        const toast = document.createElement('div');
        toast.textContent = 'Password berhasil disalin!';
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.background = '#198754';
        toast.style.color = '#fff';
        toast.style.padding = '10px 15px';
        toast.style.borderRadius = '8px';
        toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
        toast.style.zIndex = '9999';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    });
}
</script>

<style>
    body {
        background-color: #f4f6f8;
    }
    .bg-gradient-primary {
        background: linear-gradient(90deg, #0062E6, #33AEFF);
    }
</style>
@endsection
