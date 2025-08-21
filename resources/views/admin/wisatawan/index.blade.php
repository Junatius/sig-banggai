@extends('partials.dashboard')

@section('content')
<div class="container py-4">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div id="success-alert" class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Chart: Total per Negara --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            Statistik Wisatawan per Negara
        </div>
        <div class="card-body">
            <canvas id="chartByCountry"></canvas>
        </div>
    </div>

    {{-- Chart: Total per Tujuan --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            Statistik Wisatawan per Tujuan Kedatangan
        </div>
        <div class="card-body">
            <canvas id="chartByPurpose"></canvas>
        </div>
    </div>


    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('dashboard.tourists.index') }}" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="{{ $search }}">
        </div>
        <div class="col-md-3">
            <select name="nationality" class="form-select">
                <option value="">Semua Negara</option>
                @foreach($countries as $country)
                    <option value="{{ $country }}" {{ request('nationality') == $country ? 'selected' : '' }}>
                        {{ $country }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="visit_purpose" class="form-select">
                <option value="">Semua Tujuan</option>
                @foreach($purposes as $purpose)
                    <option value="{{ $purpose }}" {{ request('visit_purpose') == $purpose ? 'selected' : '' }}>
                        {{ $purpose }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-fill">Filter</button>
            <button type="button" class="btn btn-success flex-fill" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-lg"></i> Tambah
            </button>
        </div>
    </form>

    {{-- Table --}}
    <div class="card">
        <div class="card-header bg-secondary text-white">
            Daftar Wisatawan
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Negara</th>
                        <th>Tujuan</th>
                        <th>Dibuat</th>
                        <th>Terakhir Diubah</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tourists as $index => $tourist)
                        <tr>
                            <td>{{ $tourists->firstItem() + $index }}</td>
                            <td>{{ $tourist->name }}</td>
                            <td>{{ $tourist->nationality }}</td>
                            <td>{{ $tourist->visit_purpose }}</td>
                            <td>{{ $tourist->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $tourist->updated_at->format('d-m-Y H:i') }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $tourist->id }}">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $tourist->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $tourists->links() }}
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('dashboard.tourists.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Wisatawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-2" placeholder="Nama" required>
                    <input type="text" name="nationality" class="form-control mb-2" placeholder="Negara" required>
                    <select name="visit_purpose" class="form-select mb-2" required>
                        <option value="">Pilih Tujuan Kedatangan</option>
                        <option value="bisnis">Bisnis</option>
                        <option value="berlibur">Berlibur</option>
                        <option value="pribadi">Pribadi</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit & Delete --}}
@foreach($tourists as $tourist)
    {{-- Edit --}}
    <div class="modal fade" id="editModal{{ $tourist->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('dashboard.tourists.update', $tourist->id) }}">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title">Edit Wisatawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" value="{{ $tourist->name }}" class="form-control mb-2" required>
                        <input type="text" name="nationality" value="{{ $tourist->nationality }}" class="form-control mb-2" required>
                        <select name="visit_purpose" class="form-select mb-2" required>
                            <option value="bisnis" {{ $tourist->visit_purpose == 'bisnis' ? 'selected' : '' }}>Bisnis</option>
                            <option value="berlibur" {{ $tourist->visit_purpose == 'berlibur' ? 'selected' : '' }}>Berlibur</option>
                            <option value="pribadi" {{ $tourist->visit_purpose == 'pribadi' ? 'selected' : '' }}>Pribadi</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete --}}
    <div class="modal fade" id="deleteModal{{ $tourist->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('dashboard.tourists.destroy', $tourist->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">Hapus Wisatawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body tedxt-black">
                        Apakah yakin ingin menghapus wisatawan <b>{{ $tourist->name }}</b>?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

{{-- ChartJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartByCountry = @json($chartByCountry);
    const chartByPurpose = @json($chartByPurpose);

    // Generate up to 100 distinct colors
    function generateColors(count) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            const hue = (i * 137.508) % 360; // golden angle → sebaran merata
            const saturation = 60 + (i % 3) * 15; // 60%, 75%, 90%
            const lightness = 35 + (i % 4) * 15; // 35%, 50%, 65%, 80%
            colors.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
        }
        return colors;
    }

    // Chart per Negara
    new Chart(document.getElementById('chartByCountry'), {
        type: 'doughnut',
        data: {
            labels: chartByCountry.map(row => row.nationality),
            datasets: [{
                label: 'Jumlah Wisatawan',
                data: chartByCountry.map(row => row.total),
                backgroundColor: generateColors(100), // <= 100 warna
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Total Wisatawan Berdasarkan Negara' },
                legend: { position: 'bottom' }
            }
        }
    });

    // Chart per Tujuan
    new Chart(document.getElementById('chartByPurpose'), {
        type: 'doughnut',
        data: {
            labels: chartByPurpose.map(row => row.visit_purpose),
            datasets: [{
                label: 'Jumlah Wisatawan',
                data: chartByPurpose.map(row => row.total),
                backgroundColor: generateColors(100), // <= 100 warna
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Total Wisatawan Berdasarkan Tujuan Kedatangan' },
                legend: { position: 'bottom' }
            }
        }
    });
</script>
<script>
    // Auto dismiss alert
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
