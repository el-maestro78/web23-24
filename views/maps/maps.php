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
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js">
    </script>

    <script>
        let map = L.map('mapid').setView([38.246242, 21.7350847], 16);

        // Set up the OpenStreetMap layer
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }).addTo(map);

        fetch('../../controller/fetch_stores.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(store => {
                    let marker = L.marker([store.lat, store.long]).addTo(map);
                    marker.bindPopup(`<b>Store ID: ${store.base_id}</b>`).openPopup();
                });
            })
            .catch(error => console.error('Error fetching store data:', error));
    </script>

    <div id="mapid"></div>
</body>

</html>