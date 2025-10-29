@extends('partials.dashboard')

@section('content')
<div class="container mx-auto py-6">
    <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
        <h1 class="text-2xl font-bold mb-6">Edit Informasi Tempat Wisata</h1>

        <form method="POST" action="{{ route('dashboard.attractions.update.pengelola') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Nama</label>
                <input type="text"
                    name="name"
                    value="{{ old('name', $attraction->name) }}"
                    disabled
                    title="Hanya dinas pariwisata yang bisa mengubah ini. Hubungi mereka jika ingin mengubah nama tempat wisatamu."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed"
                    required>
            </div>


            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi</label>
                <textarea name="desc" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('desc', $attraction->desc) }}</textarea>
            </div>

            {{-- Legalitas --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Legalitas</label>
                <input type="text" name="legality" value="{{ old('legality', $attraction->legality) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Harga Tiket --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Harga Tiket</label>
                <input type="text" name="price" value="{{ old('price', $attraction->price) }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Fasilitas --}}
            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="has_facility" value="1" {{ old('has_facility', $attraction->has_facility) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-gray-800">Memiliki Fasilitas</span>
                </label>
            </div>

            {{-- Foto Profil --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Foto Profil</label>
                <input type="file" name="photo_profile"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @if($attraction->photo_profile)
                    <p class="mt-2 text-sm text-gray-600">Foto saat ini:</p>
                    <img src="{{ asset('storage/'.$attraction->photo_profile) }}"
                         class="w-40 h-28 object-cover mx-auto rounded-md mt-1 border">
                @endif
            </div>

            {{-- Lokasi di Google Maps --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Lokasi Peta</label>
                <div id="map" class="w-full h-72 rounded-lg border mb-3"></div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700">Latitude</label>
                        <input type="number" step="any" id="latitude" name="latitude"
                               value="{{ old('latitude', $attraction->latitude) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700">Longitude</label>
                        <input type="number" step="any" id="longitude" name="longitude"
                               value="{{ old('longitude', $attraction->longitude) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-1">Klik pada peta untuk mengatur lokasi</p>
            </div>

            {{-- Buttons --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('dashboard.attractions.show.pengelola') }}"
                   class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg">Batal</a>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Google Maps --}}
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
<script>
    function initMap() {
        const initialLat = parseFloat(document.getElementById("latitude").value) || -1.8694;
        const initialLng = parseFloat(document.getElementById("longitude").value) || 123.5445;

        const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: initialLat, lng: initialLng },
            zoom: 12
        });

        let marker = new google.maps.Marker({
            position: { lat: initialLat, lng: initialLng },
            map: map,
            draggable: true
        });

        // Update lat/lng saat map di-klik
        google.maps.event.addListener(map, 'click', function(event) {
            marker.setPosition(event.latLng);
            document.getElementById("latitude").value = event.latLng.lat();
            document.getElementById("longitude").value = event.latLng.lng();
        });

        // Update lat/lng saat marker digeser
        google.maps.event.addListener(marker, 'dragend', function(event) {
            document.getElementById("latitude").value = event.latLng.lat();
            document.getElementById("longitude").value = event.latLng.lng();
        });
    }
</script>
@endsection

