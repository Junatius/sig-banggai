@extends('partials.dashboard')

@section('content')
<div class="container py-4">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle"></i> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Manajemen Berita</h4>
        <a href="{{ route('dashboard.news.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Berita
        </a>
    </div>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('dashboard.news.index') }}" class="card card-body mb-4">
        <div class="row g-3">

            {{-- Search Title --}}
            <div class="col-md-3">
                <label class="form-label">Cari Judul Berita</label>
                <input type="text" name="search" class="form-control" 
                       value="{{ request('search') }}" placeholder="Masukkan judul...">
            </div>

            {{-- Filter Role --}}
            @if (auth()->user()->role == 'dinas_pariwisata')
                <div class="col-md-3">
                    <label class="form-label">Role Pembuat</label>
                    <select name="filter_role" class="form-select" id="roleFilter">
                        <option value="">Semua</option>
                        <option value="dinas_pariwisata" {{ request('filter_role') == 'dinas_pariwisata' ? 'selected' : '' }}>Dinas Pariwisata</option>
                        <option value="pengelola" {{ request('filter_role') == 'pengelola' ? 'selected' : '' }}>Pengelola</option>
                    </select>
                </div>
            @endif

            {{-- Filter Attraction --}}
            <div class="col-md-3" id="attractionFilterWrapper" 
                 style="{{ request('filter_role') == 'pengelola' ? '' : 'display:none;' }}">
                <label class="form-label">Tempat Wisata</label>
                <select name="filter_attraction" class="form-select">
                    <option value="">Semua</option>
                    @foreach($attractions as $attraction)
                        <option value="{{ $attraction->id }}" {{ request('filter_attraction') == $attraction->id ? 'selected' : '' }}>
                            {{ $attraction->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Tanggal Dari --}}
            <div class="col-md-3">
                <label class="form-label">Tanggal Dari</label>
                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>

            {{-- Filter Tanggal Sampai --}}
            <div class="col-md-3">
                <label class="form-label">Tanggal Sampai</label>
                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>

            {{-- Tombol Filter --}}
            <div class="col-md-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-success me-2">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('dashboard.news.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-repeat"></i> Reset
                </a>
            </div>

        </div>
    </form>

    {{-- Tabel Berita --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Pembuat</th>
                        <th>Role</th>
                        <th>Tempat Wisata</th>
                        <th>Tanggal Dibuat</th>
                        <th>Terakhir Diubah</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                        <tr>
                            <td>
                                @if($item->photo_url)
                                    <img src="{{ asset('storage/' . $item->photo_url) }}" alt="" class="rounded" style="height:50px;width:70px;object-fit:cover;">
                                @else
                                    <span class="text-muted fst-italic">No Image</span>
                                @endif
                            </td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->user->username ?? '-' }}</td>
                            <td>{{ $item->user->role ?? '-' }}</td>
                            <td>{{ $item->user->attraction->name ?? '-' }}</td>
                            <td>
                                {{ $item->created_at->translatedFormat('l, d F Y') }} <br>
                                {{ $item->created_at->format('H:i') }}
                            </td>
                            <td>
                                {{ $item->updated_at->translatedFormat('l, d F Y') }} <br>
                                {{ $item->updated_at->format('H:i') }}
                            </td>
                            <td>
                                <a href="{{ route('dashboard.news.show', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>

                                @if($item->users_id == auth()->id())
                                    <a href="{{ route('dashboard.news.edit', $item->id) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @elseif(auth()->user()->role == 'dinas_pariwisata')
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>

                        {{-- Modal Delete --}}
                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('dashboard.news.destroy', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-header bg-gray-500">
                                            <h5 class="modal-title">Hapus Berita</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-black">
                                            Apakah Anda yakin ingin menghapus berita ini?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Tidak ada berita ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $news->withQueryString()->links() }}
    </div>
</div>

{{-- Script untuk toggle attraction filter --}}
<script>
    document.getElementById('roleFilter').addEventListener('change', function() {
        let attractionWrapper = document.getElementById('attractionFilterWrapper');
        attractionWrapper.style.display = this.value === 'pengelola' ? '' : 'none';
    });

    document.addEventListener("DOMContentLoaded", function () {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                // bootstrap alert close
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }, 3000); // 3000ms = 3 detik
        });
    });
</script>
@endsection
