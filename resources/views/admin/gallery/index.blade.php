@extends('partials.dashboard')

@section('content')
<div class="container py-4">
    <div class="card custom-card">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Manajemen Galeri</h5>
        </div>
        <div class="card-body bg-light-custom">

            @if(session('success'))
                <div id="success-alert" class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('dashboard.galleries.index') }}" class="d-flex gap-2 mb-3 flex-wrap">
                <input type="text" name="search" class="form-control" placeholder="Cari nama pengguna..." value="{{ $search }}">
                
                <select name="attraction" class="form-select" style="max-width: 250px;">
                    <option value="">Filter Tempat Wisata</option>
                    @foreach($attractions as $attr)
                        <option value="{{ $attr->id }}" {{ ($filterAttraction == $attr->id) ? 'selected' : '' }}>{{ $attr->name }}</option>
                    @endforeach
                </select>

                <!-- Dropdown filter status -->
                <select name="status" class="form-select" style="max-width: 200px;">
                    <option value="">Filter Status Foto</option>
                    <option value="pending" {{ ($filterStatus == 'pending') ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ ($filterStatus == 'approved') ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ ($filterStatus == 'rejected') ? 'selected' : '' }}>Ditolak</option>
                </select>

                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari & Filter</button>
                <a href="{{ route('dashboard.galleries.index') }}" class="btn btn-outline-secondary">Reset</a>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama Tempat Wisata</th>
                            <th>Nama Pengupload</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($galeries as $index => $galery)
                        <tr>
                            <td>{{ $galeries->firstItem() + $index }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $galery->photo_url) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $galery->photo_url) }}" 
                                        alt="Foto" 
                                        class="img-thumbnail" 
                                        style="max-width: 200px; max-height: 150px;">
                                </a>
                            </td>
                            <td>{{ $galery->attraction->name ?? '-' }}</td>
                            <td>{{ $galery->user->username ?? '-' }}</td>
                            <td>
                                @if($galery->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($galery->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($galery->status == 'pending')
                                    <button class="btn btn-success btn-sm rounded-pill shadow-sm me-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#approveModal{{ $galery->id }}">
                                        <i class="bi bi-check-lg"></i> Approve
                                    </button>
                                    <button class="btn btn-danger btn-sm rounded-pill shadow-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#rejectModal{{ $galery->id }}">
                                        <i class="bi bi-x-lg"></i> Reject
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada galeri ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $galeries->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve -->
@foreach ($galeries as $galery)
<div class="modal fade" id="approveModal{{ $galery->id }}" tabindex="-1" aria-labelledby="approveModalLabel{{ $galery->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('dashboard.galleries.approve', $galery->id) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel{{ $galery->id }}">Konfirmasi Approve Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin <strong>menyetujui</strong> foto ini dari <em>{{ $galery->user->username }}</em> untuk tempat wisata <em>{{ $galery->attraction->name }}</em>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Setujui</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Modal Reject -->
@foreach ($galeries as $galery)
<div class="modal fade" id="rejectModal{{ $galery->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $galery->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('dashboard.galleries.reject', $galery->id) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel{{ $galery->id }}">Konfirmasi Tolak Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin <strong>menolak</strong> foto ini dari <em>{{ $galery->user->username }}</em> untuk tempat wisata <em>{{ $galery->attraction->name }}</em>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Tolak</button>
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
