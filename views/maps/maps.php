<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.css" integrity="sha512-cUoWMYmv4H9TGP4hbm1mIjYo90WzIQFo/5jj+P5tQcDTf+iVR59RyIj/a9fRsBxzxt5Dnv/Ex7MzRIxcDwaOLw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/images/markers-matte.png" />
    <link rel="stylesheet" href="https: //cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/images/markers-matte@2x.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMTnDxuhMjp4Jl4biHeOeGb4bYPCh8NcUX0Enn3" crossorigin="anonymous">
    <link rel=" stylesheet" href="./maps.css" />
    <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
    <title>Maps</title>
</head>

<body>
    <div id="mapid"></div>
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.min.js" integrity="sha512-8BqQ2RH4L4sQhV41ZB24fUc1nGcjmrTA6DILV/aTPYuUzo+wBdYdp0fvQ76Sxgf36p787CXF7TktWlcxu/zyOg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.js" integrity="sha512-Oj9plGLST4IMXFXDfqMdTP+gSInbodkyno117PSjo5R08eu6TdzY9WPnnwQZGx2O2lG/kN0MzQk95ulWsRFuLA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Font Awesome Kit-->
    <script src="https://kit.fontawesome.com/b3969ea94f.js" crossorigin="anonymous"></script>
    <!-- For dynamic color determination and cleaner map.php file-->
    <script src="./map.js"></script>
    <script>
        let map = L.map('mapid').setView([38.246242, 21.7350847], 16);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }).addTo(map);

        const polylineLayerGroup = L.layerGroup().addTo(map);
        map.on('click', (event) => {
            polylineLayerGroup.clearLayers(); //clear vehicle lines
        });

        fetch('../../controller/admin/fetch_stores.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(store => {
                    let marker = L.marker([store.lat, store.long], {
                        icon: L.AwesomeMarkers.icon({
                            icon: 'house', //'spinner',
                            prefix: 'fa',
                            markerColor: 'black',
                        }),
                        draggable: true,
                    }).addTo(map);
                    marker.bindPopup(`<b>Store ID: ${store.base_id}</b>`).openPopup();
                    /*
                    marker.on('dragstart', function(event) {
                        console.log('Drag started');
                    });
                    marker.on('drag', function(event) {
                        let marker = event.target;
                        let position = marker.getLatLng();
                    });*/
                    marker.on('dragend', (event) => {
                        storedrag(event, store.base_id);
                    });
                    map.addLayer(marker);
                });
            })
            .catch(error => console.error('Error fetching store data:', error));

        fetch('../../controller/admin/fetch_vehicles.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(vehicle => {
                    let marker = L.marker([vehicle.lat, vehicle.long], {
                        icon: L.AwesomeMarkers.icon({
                            icon: 'car',
                            prefix: 'fa',
                            markerColor: 'blue'
                        })
                    }).addTo(map);
                    marker.on('click', async () => {
                        const content = await vehiclePopup(vehicle);
                        //console.log(content)
                        marker.bindPopup(content).openPopup();
                        let tasks = getVehicleTasks(vehicle.veh_id);
                        drawVehicleLine(marker, tasks);
                        polylineLayerGroup.clearLayers();
                    });
                });
            })
            .catch(error => console.error('Error fetching vehicle data:', error));

        fetch('../../controller/admin/fetch_offers.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(offer => {
                    color = getDataColor(offer);
                    let marker = L.marker([offer.lat, offer.long], {
                        icon: L.AwesomeMarkers.icon({
                            icon: 'gift',
                            prefix: 'fa',
                            markerColor: color,
                            iconColor: 'white',
                        })
                    }).addTo(map);
                    marker.on('click', async () => {
                        const content = await offerPopup(offer);
                        //console.log(content)
                        marker.bindPopup(content).openPopup();
                    });
                });
            })
            .catch(error => console.error('Error fetching offer data:', error));

        fetch('../../controller/admin/fetch_requests.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(request => {
                    color = getDataColor(request);
                    let marker = L.marker([request.lat, request.long], {
                        icon: L.AwesomeMarkers.icon({
                            icon: 'exclamation',
                            prefix: 'fa',
                            markerColor: color,
                            iconColor: 'white',
                        })
                    }).addTo(map);
                    //marker.bindPopup(requestPopup(request)).openPopup();
                    marker.on('click', async () => {
                        const content = await requestPopup(request);
                        //console.log(content)
                        marker.bindPopup(content).openPopup();
                    });
                })
            })
            .catch(error => console.error('Error fetching request data:', error));
    </script>
</body>

</html>