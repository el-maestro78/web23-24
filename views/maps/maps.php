<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"/>
    <link rel="stylesheet" href="./maps.css"/>
    <title>Maps</title>
</head>
<body>
    <div id="mapid"></div>
    <script 
        src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js">
    </script>
    
    <script>
       let map = L.map('mapid')
        let osmUrl='https://tile.openstreetmap.org/{z}/{x}/{y}.png';
        let osmAttrib='Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
        let osm = new L.TileLayer(osmUrl, {attribution: osmAttrib});
        map.addLayer(osm);
        map.setView([38.246242, 21.7350847], 16);
    </script>

    <div id="mapid"></div>
</body>
</html>