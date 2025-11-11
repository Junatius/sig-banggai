@extends('partials.dashboard')

@section('content')
<div class="container mx-auto py-6">
    @if(session('success'))
        <div class="mb-4 p-4 text-green-900 bg-green-100 border border-green-200 rounded-lg shadow">
            <i class="bi bi-check-circle-fill mr-1"></i> {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
        <h1 class="text-2xl font-bold mb-4">{{ $attraction->name }}</h1>

        @if($attraction->photo_profile)
            <img src="{{ asset('storage/'.$attraction->photo_profile) }}"
                 class="w-full flex mx-auto max-w-md h-64 object-cover rounded-lg mb-4 border">
        @endif

        <p class="mb-2"><strong>Kecamatan:</strong> {{ $attraction->subdistrict->name ?? '-' }}</p>
        <p class="mb-2"><strong>Deskripsi:</strong> {{ $attraction->desc }}</p>
        <p class="mb-2"><strong>Legalitas:</strong> {{ $attraction->legality }}</p>
        <p class="mb-2"><strong>Harga Tiket:</strong> {{ $attraction->price ?: '-' }}</p>
        <p class="mb-2"><strong>Fasilitas:</strong>
            @if($attraction->has_facility)
                <span class="text-green-600 font-semibold">Ada</span>
            @else
                <span class="text-red-600 font-semibold">Tidak</span>
            @endif
        </p>

        {{-- 3D Google Maps --}}
        <div class="mt-6">
            <label class="block text-sm font-semibold text-gray-800 mb-2">Lokasi pada Peta (3D):</label>
            <div id="map-container" class="w-full h-80 rounded-lg border overflow-hidden relative"></div>
        </div>

        <div class="mt-6">
            <a href="{{ route('dashboard.attractions.edit.pengelola') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                <i class="bi bi-pencil mr-2"></i> Edit Informasi
            </a>
        </div>
    </div>
</div>
@endsection

{{-- 3D Google Maps Script --}}
<script async
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&v=beta&libraries=maps3d,marker"
    onload="init3DMap()">
</script>

<script>
async function init3DMap() {
    const lat = parseFloat("{{ $attraction->latitude ?? '-1.8694' }}");
    const lng = parseFloat("{{ $attraction->longitude ?? '123.5445' }}");
    const name = @json($attraction->name);
    const desc = @json($attraction->desc);
    const photo = @json($attraction->photo_profile ? asset('storage/'.$attraction->photo_profile) : null);

    const { Map3DElement, Marker3DInteractiveElement, PopoverElement } =
        await google.maps.importLibrary("maps3d");
    const { PinElement } = await google.maps.importLibrary("marker");

    const mapContainer = document.getElementById("map-container");

    // Initialize 3D map
    const map = new Map3DElement({
        center: { lat: lat, lng: lng, altitude: 100 },
        range: 3000,
        tilt: 65,
        heading: 20,
        mode: "HYBRID",
        gestureHandling: "COOPERATIVE"
    });
    mapContainer.append(map);

    // Marker Pin
    const pin = new PinElement({
        scale: 1.5,
        background: "#2563eb", // Tailwind blue-600
        glyphColor: "#fff",
    });

    // Popover for info
    const popover = new PopoverElement();
    const header = document.createElement("span");
    header.slot = "header";
    header.textContent = name;

    const content = document.createElement("div");
    content.innerHTML = `
        ${photo ? `<img src="${photo}" style="width:100%;border-radius:8px;margin-bottom:8px;">` : ""}
        <p>${desc}</p>
    `;

    popover.append(header);
    popover.append(content);

    // Interactive marker
    const marker = new Marker3DInteractiveElement({
        title: name,
        position: { lat: lat, lng: lng },
        gmpPopoverTargetElement: popover,
    });
    marker.append(pin);

    map.append(marker);
    map.append(popover);
}
</script>
