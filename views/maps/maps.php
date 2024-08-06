<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
    <link rel="stylesheet" href="./maps.css" />
    <link rel="icon" href="../../favicon.ico">
    <title>Maps</title>
</head>

<body>
    <div id="mapid"></div>
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
    <script>
        let map = L.map('mapid').setView([38.246242, 21.7350847], 16);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }).addTo(map);
        /*
                const baseIcon = L.icon({
                    class: 'base-marker',
                    html: '<div class="custom-marker">S</div>',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                });
                var iconOptions = {
                    iconUrl: 'logo.png',
                    iconSize: [50, 50]
                }
                var customIcon = L.icon(iconOptions);
                var markerOptions = {
                    title: "MyLocation",
                    clickable: true,
                    draggable: true,
                    icon: customIcon
                }/* */

        function createCustomIcon(type, color) {
            return L.divIcon({
                className: `${type} marker-${color}`,
                html: `<div class="${type} marker-${color}">X</div>`,
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            });
        }

        fetch('../../controller/admin/fetch_stores.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(store => {
                    let marker = L.marker([store.lat, store.long], {
                        icon: createCustomIcon('base-marker', 'black')
                    }).addTo(map);
                    marker.bindPopup(`<b>Store ID: ${store.base_id}</b>`).openPopup();
                });
            })
            .catch(error => console.error('Error fetching store data:', error));
    </script>

    <div id="mapid"></div>
</body>

</html>