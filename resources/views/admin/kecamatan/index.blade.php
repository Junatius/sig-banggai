@extends('partials.dashboard')

@section('content')
<div class="container py-4">
    <div class="card custom-card">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Manajemen Kecamatan</h5>
            <button class="btn btn-success btn-sm rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-lg"></i> Tambah Kecamatan
            </button>
        </div>
        <div class="card-body bg-light-custom">

            @if(session('success'))
                <div id="success-alert" class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('dashboard.subdistricts.index') }}" class="d-flex gap-2 mb-3">
                <input type="text" name="search" class="form-control" placeholder="Cari kecamatan..." value="{{ $search }}">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama Kecamatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subdistricts as $index => $subdistrict)
                            <tr>
                                <td>{{ $subdistricts->firstItem() + $index }}</td>
                                <td>{{ $subdistrict->name }}</td>
                                <td class="text-center">
                                    <button class="btn btn-warning btn-sm rounded-pill shadow-sm me-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $subdistrict->id }}">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>

                                    <button class="btn btn-outline-danger btn-sm rounded-pill shadow-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $subdistrict->id }}">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Tidak ada kecamatan ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $subdistricts->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('dashboard.subdistricts.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Kecamatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama kecamatan" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit dan Delete diletakkan di luar tabel -->
@foreach ($subdistricts as $subdistrict)
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal{{ $subdistrict->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $subdistrict->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('dashboard.subdistricts.update', $subdistrict->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $subdistrict->id }}">Edit Kecamatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="nama" value="{{ $subdistrict->name }}" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal{{ $subdistrict->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $subdistrict->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('dashboard.subdistricts.destroy', $subdistrict->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $subdistrict->id }}">Hapus Kecamatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus kecamatan <strong>{{ $subdistrict->name }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('success-alert');
        if(alert) {
            setTimeout(() => {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 3000);
        }
    });
</script>

@endsection

