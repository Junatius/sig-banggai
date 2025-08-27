@extends('partials.dashboard')

@section('content')
<div class="container py-4">

    {{-- Notifikasi --}}
    @if(session('success'))
        <div id="success-alert" class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Chart Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        {{-- Negara --}}
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-4">
                Statistik Wisatawan per Negara
            </h2>

            {{-- chart + legend layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
                {{-- Canvas centered --}}
                <div class="lg:col-span-3 flex items-center justify-center h-72">
                    <canvas id="chartByCountry"></canvas>
                </div>
                {{-- External legend, scrollable --}}
                <div class="lg:col-span-2">
                    <div id="legend-country" class="max-h-72 overflow-auto pr-2"></div>
                </div>
            </div>
        </div>

        {{-- Tujuan --}}
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-4">
                Statistik Wisatawan per Tujuan Kedatangan
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
                <div class="lg:col-span-3 flex items-center justify-center h-72">
                    <canvas id="chartByPurpose"></canvas>
                </div>
                <div class="lg:col-span-2">
                    <div id="legend-purpose" class="max-h-72 overflow-auto pr-2"></div>
                </div>
            </div>
        </div>
    </div>


{{-- Filter & Search --}}
<form method="GET" action="{{ route('dashboard.tourists.index') }}" 
      class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <input type="text" name="search" placeholder="Cari nama..." 
           value="{{ $search }}" 
           class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

    <select name="nationality" 
            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        <option value="">Semua Negara</option>
        @foreach($countries as $country)
            <option value="{{ $country }}" {{ request('nationality') == $country ? 'selected' : '' }}>
                {{ $country }}
            </option>
        @endforeach
    </select>

    <select name="visit_purpose" 
            class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        <option value="">Semua Tujuan</option>
        @foreach($purposes as $purpose)
            <option value="{{ $purpose }}" {{ request('visit_purpose') == $purpose ? 'selected' : '' }}>
                {{ $purpose }}
            </option>
        @endforeach
    </select>

    <div class="flex gap-2">
        <button type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 flex-1">
            Filter
        </button>
        <button type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 flex-1">
            + Tambah
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartByCountry = @json($chartByCountry);
    const chartByPurpose = @json($chartByPurpose);

    // Generate up to 100 distinct colors
    function generateColors(count) {
        const colors = [];
        for (let i = 0; i < count; i++) {
            const hue = (i * 137.508) % 360;
            const saturation = 65;
            const lightness = 55 - (i % 3) * 10; // 55/45/35
            colors.push(`hsl(${hue}, ${saturation}%, ${lightness}%)`);
        }
        return colors;
    }

    // Small, clean HTML legend plugin (separate from canvas)
    const getOrCreateLegendList = (id) => {
        const container = document.getElementById(id);
        let ul = container.querySelector('ul');
        if (!ul) {
            ul = document.createElement('ul');
            ul.className = 'space-y-1 text-sm text-gray-700';
            container.appendChild(ul);
        }
        return ul;
    };

    const htmlLegendPlugin = {
        id: 'htmlLegend',
        afterUpdate(chart, args, options) {
            const ul = getOrCreateLegendList(options.containerID);
            // clear
            while (ul.firstChild) ul.firstChild.remove();
            // items from Chart.js' legend generator
            const items = chart.options.plugins.legend.labels.generateLabels(chart);
            items.forEach(item => {
                const li = document.createElement('li');
                li.className = 'flex items-center gap-2 cursor-pointer';
                li.onclick = () => chart.toggleDataVisibility(item.index) || chart.update();

                const box = document.createElement('span');
                box.className = 'inline-block w-3.5 h-3.5 rounded';
                box.style.background = item.fillStyle;
                box.style.border = '1px solid rgba(0,0,0,0.1)';

                const text = document.createElement('span');
                text.textContent = item.text;

                li.appendChild(box);
                li.appendChild(text);
                ul.appendChild(li);
            });
        }
    };

    // helper for percent in tooltip
    function tooltipLabelWithPercent(ctx) {
        const dataset = ctx.dataset;
        const total = dataset.data.reduce((a, b) => a + b, 0);
        const value = ctx.parsed;
        const pct = total ? ((value / total) * 100).toFixed(1) : 0;
        return `${ctx.label}: ${value} (${pct}%)`;
    }

    // COUNTRY CHART
    const countryLabels = chartByCountry.map(r => r.nationality);
    const countryData   = chartByCountry.map(r => r.total);
    new Chart(document.getElementById('chartByCountry'), {
        type: 'doughnut',
        data: {
            labels: countryLabels,
            datasets: [{
                data: countryData,
                backgroundColor: generateColors(Math.max(countryLabels.length, 12)),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,   // allow flex height to center it nicely
            cutout: '65%',
            layout: { padding: 8 },
            plugins: {
                title: { display: false }, // we already have a big card title
                legend: { display: false }, // legend rendered externally
                tooltip: { callbacks: { label: tooltipLabelWithPercent } },
                htmlLegend: { containerID: 'legend-country' }
            }
        },
        plugins: [htmlLegendPlugin]
    });

    // PURPOSE CHART
    const purposeLabels = chartByPurpose.map(r => r.visit_purpose);
    const purposeData   = chartByPurpose.map(r => r.total);
    new Chart(document.getElementById('chartByPurpose'), {
        type: 'doughnut',
        data: {
            labels: purposeLabels,
            datasets: [{
                data: purposeData,
                backgroundColor: generateColors(Math.max(purposeLabels.length, 6)),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            layout: { padding: 8 },
            plugins: {
                title: { display: false },
                legend: { display: false }, // use external legend for consistent look
                tooltip: { callbacks: { label: tooltipLabelWithPercent } },
                htmlLegend: { containerID: 'legend-purpose' }
            }
        },
        plugins: [htmlLegendPlugin]
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
