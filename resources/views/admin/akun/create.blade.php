@extends('partials.dashboard')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4">
                    <h5 class="mb-0">
                        <i class="bi bi-person-plus-fill me-2"></i>Tambah Akun
                    </h5>
                </div>
                <div class="card-body p-4">

                    <form action="{{ route('dashboard.users.store') }}" method="POST">
                        @csrf

                        {{-- Role --}}
                        <div class="mb-3">
                            <label for="role" class="form-label fw-semibold">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="">Pilih Role</option>
                                <option value="dinas_pariwisata">Dinas Pariwisata</option>
                                <option value="pengelola">Pengelola</option>
                            </select>
                            @error('role') 
                                <div class="text-danger small">{{ $message }}</div> 
                            @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan nama" required>
                            @error('name') 
                                <div class="text-danger small">{{ $message }}</div> 
                            @enderror
                        </div>

                        {{-- Nama Wisata (khusus pengelola) --}}
                        <div class="mb-3" id="attractionField" style="display:none;">
                            <label for="attraction_id" class="form-label fw-semibold">Nama Wisata</label>
                            <select name="attraction_id" class="form-select">
                                <option value="">Pilih Wisata</option>
                                @foreach($attractions as $attr)
                                    <option value="{{ $attr->id }}">{{ $attr->name }}</option>
                                @endforeach
                            </select>
                            @error('attraction_id') 
                                <div class="text-danger small">{{ $message }}</div> 
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
                            @error('email') 
                                <div class="text-danger small">{{ $message }}</div> 
                            @enderror
                        </div>

                        <p class="text-muted small fst-italic">
                            Password akan dibuatkan secara otomatis ketika menekan tombol <strong>Buat</strong>.
                        </p>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-secondary rounded-pill shadow-sm">
                                <i class="bi bi-arrow-left-circle me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success rounded-pill shadow-sm">
                                <i class="bi bi-check2-circle me-1"></i> Buat
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk toggle input wisata --}}
<script>
    document.getElementById('role').addEventListener('change', function() {
        const attractionField = document.getElementById('attractionField');
        attractionField.style.display = this.value === 'pengelola' ? 'block' : 'none';
    });
</script>

{{-- Styling tambahan --}}
<style>
    body {
        background-color: #f4f6f8;
    }
    .bg-gradient-primary {
        background: linear-gradient(90deg, #0062E6, #33AEFF);
    }
</style>
@endsection
