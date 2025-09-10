@extends('partials.dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Card Form --}}
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200 max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 text-center">Edit Tempat Wisata</h1>

        <form action="{{ route('dashboard.attractions.update', $attraction->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Nama Wisata --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Nama Wisata</label>
                <input type="text" name="name" value="{{ old('name', $attraction->name) }}"
                       class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500"
                       required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Kecamatan --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Kecamatan</label>
                <select name="subdistrict_id"
                        class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Kecamatan</option>
                    @foreach($subdistricts as $subdistrict)
                        <option value="{{ $subdistrict->id }}" {{ old('subdistrict_id', $attraction->subdistrict_id) == $subdistrict->id ? 'selected' : '' }}>
                            {{ $subdistrict->name }}
                        </option>
                    @endforeach
                </select>
                @error('subdistrict_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Foto Profil --}}
            <div class="flex flex-col items-center">
                <label class="block text-sm font-semibold text-gray-800 mb-2">Foto Profil</label>
                @if($attraction->photo_profile)
                    <img src="{{ asset('storage/'.$attraction->photo_profile) }}"
                         class="w-40 h-32 object-cover rounded-lg mb-3 border border-gray-200 shadow">
                @endif
                <input type="file" name="photo_profile"
                       class="w-full md:w-2/3 rounded-lg border border-gray-300 p-2 focus:ring-2 focus:ring-blue-500">
                @error('photo_profile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi</label>
                <textarea name="desc" rows="4"
                          class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500">{{ old('desc', $attraction->desc) }}</textarea>
                @error('desc') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Fasilitas --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Apakah ada fasilitas?</label>
                <select name="has_facility"
                        class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500">
                    <option value="1" {{ old('has_facility', $attraction->has_facility) == '1' ? 'selected' : '' }}>Ada</option>
                    <option value="0" {{ old('has_facility', $attraction->has_facility) == '0' ? 'selected' : '' }}>Tidak</option>
                </select>
                @error('has_facility') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Jenis Wisata --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Jenis Wisata</label>
                <input type="text" name="type" value="{{ old('type', $attraction->type) }}"
                       class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500"
                       required>
                @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Legalitas --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Legalitas</label>
                <input type="text" name="legality" value="{{ old('legality', $attraction->legality) }}"
                       class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500"
                       required>
                @error('legality') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Harga Tiket --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-1">Harga Tiket</label>
                <input type="number" name="price" value="{{ old('price', $attraction->price) }}"
                       class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500"
                       placeholder="Masukkan harga tiket">
                @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            {{-- Google Maps (Pilih Lokasi) --}}
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Lokasi Peta</label>
                <div id="map" class="w-full h-64 rounded-lg border border-gray-300 mb-4"></div>

                {{-- Input Latitude & Longitude --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1">Latitude</label>
                        <input type="number" step="any" name="latitude" id="latitude"
                            value="{{ old('latitude', $attraction->latitude) }}"
                            class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500">
                        @error('latitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1">Longitude</label>
                        <input type="number" step="any" name="longitude" id="longitude"
                            value="{{ old('longitude', $attraction->longitude) }}"
                            class="w-full rounded-lg border border-gray-300 p-3 focus:ring-2 focus:ring-blue-500">
                        @error('longitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>


            {{-- Tombol Aksi --}}
            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('dashboard.attractions.index') }}"
                   class="px-6 py-3 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-500">Kembali</a>
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-500">Update</button>
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

        google.maps.event.addListener(map, 'click', function(event) {
            marker.setPosition(event.latLng);
            document.getElementById("latitude").value = event.latLng.lat();
            document.getElementById("longitude").value = event.latLng.lng();
        });

        google.maps.event.addListener(marker, 'dragend', function(event) {
            document.getElementById("latitude").value = event.latLng.lat();
            document.getElementById("longitude").value = event.latLng.lng();
        });
    }
</script>
@endsection
