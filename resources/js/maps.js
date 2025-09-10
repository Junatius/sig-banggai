// resources/js/map.js

function initMap() {
    const banggai = { lat: -1.4273, lng: 123.3185 };

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: banggai,
    });

    const infoWindow = new google.maps.InfoWindow();

    // Get attractions data from Blade
    const attractions = window.attractionsData || [];

    attractions.forEach((place) => {
        if (!place.latitude || !place.longitude) return;

        const marker = new google.maps.Marker({
            position: { lat: parseFloat(place.latitude), lng: parseFloat(place.longitude) },
            map,
            title: place.name,
        });

        marker.addListener("click", () => {
            infoWindow.setContent(`
                <div style="min-width:200px">
                    <h6>${place.name}</h6>
                    <p>${place.desc ? place.desc.substring(0, 80) + '...' : ''}</p>
                </div>
            `);
            infoWindow.open(map, marker);
        });
    });

    // Search box
    const input = document.getElementById("searchBox");
    const searchBox = new google.maps.places.SearchBox(input);

    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
    });

    searchBox.addListener("places_changed", () => {
        const places = searchBox.getPlaces();
        if (!places.length) return;

        const bounds = new google.maps.LatLngBounds();
        places.forEach((place) => {
            if (!place.geometry || !place.geometry.location) return;

            new google.maps.Marker({
                map,
                title: place.name,
                position: place.geometry.location,
            });

            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
}

window.initMap = initMap;
