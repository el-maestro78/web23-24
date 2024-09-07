<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.css" integrity="sha512-cUoWMYmv4H9TGP4hbm1mIjYo90WzIQFo/5jj+P5tQcDTf+iVR59RyIj/a9fRsBxzxt5Dnv/Ex7MzRIxcDwaOLw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/images/markers-matte.png" />
    <!--
    <link rel="stylesheet" href="https: //cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/images/markers-matte@2x.png" />
    -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMTnDxuhMjp4Jl4biHeOeGb4bYPCh8NcUX0Enn3" crossorigin="anonymous">
    <link rel=" stylesheet" href="./maps.css" />
    <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
     <!-- Leaflet Control (filter-search) -->
    <link rel="stylesheet" href="../../node_modules/leaflet-search/src/leaflet-search.css" />
    <link rel="stylesheet" href="../../node_modules/leaflet-search/dist/leaflet-search.min.css" />
    <title>Maps</title>
</head>

<body>

    <?php include '../../ini.php'; ?>
    <?php include '../../check_login.php'; ?>
    <?php
        if($_SESSION['role'] !== 'rescuer'){
            header("Location: ../home_page.php", true, 302);
            exit();
        }
    ?>
    <?php include '../toolbar.php'; ?>
    <div id="mapid"></div>
    <!-- Leaflet.js -->
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"></script>
    <!-- Leaflet awesome Markers -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.min.js" integrity="sha512-8BqQ2RH4L4sQhV41ZB24fUc1nGcjmrTA6DILV/aTPYuUzo+wBdYdp0fvQ76Sxgf36p787CXF7TktWlcxu/zyOg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.js" integrity="sha512-Oj9plGLST4IMXFXDfqMdTP+gSInbodkyno117PSjo5R08eu6TdzY9WPnnwQZGx2O2lG/kN0MzQk95ulWsRFuLA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Font Awesome Kit for markers-->
    <script src="https://kit.fontawesome.com/b3969ea94f.js" crossorigin="anonymous"></script>
    <!-- Leaflet Control (filter-search) -->
    <script src="../../node_modules/leaflet-search/dist/leaflet-search.src.js"></script>
    <!-- Aux functions for a cleaner maps.php file-->
    <script src="./map.js"></script>
    <script src="./icons.js"></script>

    <script>
        //let map = L.map('mapid').setView([38.246242, 21.7350847], 16);
        let map = L.map('mapid',{
            center: [38.246242, 21.7350847],
            zoom: 16,
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Filters
        /*
        const markerLayer = L.layerGroup().addTo(map);
        const vehicleLayer = L.layerGroup().addTo(map);
        const offerLayer = L.layerGroup().addTo(map);
        const requestLayer = L.layerGroup().addTo(map);*/
        const markerLayer = L.layerGroup();
        const baseLayer = L.layerGroup();
        const vehicleLayer = L.layerGroup();
        const vehicleIdleLayer= L.layerGroup();
        const vehicleBusyLayer= L.layerGroup();
        const offerLayer = L.layerGroup();
        const offerPendingLayer = L.layerGroup();
        const offerAssignedLayer = L.layerGroup();
        const requestLayer = L.layerGroup();
        const requestPendingLayer = L.layerGroup();
        const requestAssignedLayer = L.layerGroup();

        // Vehicle Lines
        const polylineLayerGroup = L.layerGroup().addTo(map);
        map.on('click', (event) => {
            polylineLayerGroup.clearLayers(); //clear vehicle lines
        });

        // Marker fetching
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
                        draggable: false,
                    }).addTo(map);
                    marker.bindPopup(`<b>Store ID: ${store.base_id}</b>`);
                    marker.addTo(markerLayer);
                    marker.addTo(baseLayer);
                });
            })
            .catch(error => console.error('Error fetching store data:', error));

        let my_vehicle = null;
        fetch('../../controller/rescuer/get_my_vehicle.php')
            .then(response=>response.json())
            .then(data=>{
                my_vehicle = data.veh_id;
            }).catch(error => console.error('Error fetching vehicle data:', error));
        let my_marker = null;
        fetch('../../controller/admin/fetch_vehicles.php')
            .then(response => response.json())
            .then(data => {
                data.merged.forEach(vehicle => {
                    const VehId = vehicle.veh_id;
                    vehicleTasks(vehicle).then(result => {
                        const { vehStatus } = result;
                        let vehColor;
                        if(VehId === my_vehicle && my_vehicle !== null){
                            vehColor = "pink";
                        }else{
                            vehColor = (vehStatus === 1) ? "blue" : "gray";
                        }
                        const vehType = (vehStatus === 1) ? "assigned" : "pending";

                        let marker = L.marker([vehicle.lat, vehicle.long], {
                            icon: L.AwesomeMarkers.icon({
                                icon: 'car',
                                prefix: 'fa',
                                markerColor: vehColor,
                            })
                        }).addTo(map);
                        if (VehId === my_vehicle && my_vehicle !== null) {
                            my_marker = marker;
                        }
                        marker.on('click', async () => {
                            const content = await vehiclePopup(vehicle);
                            marker.bindPopup(content).openPopup();
                            let tasks = await getVehicleTasks(vehicle.veh_id);
                            drawVehicleLine(marker, tasks);
                            polylineLayerGroup.clearLayers();
                        });
                        marker.addTo(markerLayer);
                        marker.addTo(vehicleLayer);

                        if (vehType === 'assigned') marker.addTo(vehicleBusyLayer);
                        else marker.addTo(vehicleIdleLayer);
                    }).catch(error => {
                        console.error("Error occurred while fetching vehicle data: ", error);
                    });
                });
            })
            .catch(error => console.error('Error fetching vehicle data:', error));

        fetch('../../controller/admin/fetch_offers.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(offer => {
                    let color = getDataColor(offer);
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
                        marker.bindPopup(content);
                    });
                    let type = getDataType(offer);
                    marker.addTo(markerLayer);
                    marker.addTo(offerLayer);
                    if(type === 'assigned') marker.addTo(offerAssignedLayer);
                    else marker.addTo(offerPendingLayer);
                });
            })
            .catch(error => console.error('Error fetching offer data:', error));

        fetch('../../controller/admin/fetch_requests.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(request => {
                    let color = getDataColor(request);
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
                        marker.bindPopup(content);
                    });
                    let type = getDataType(request);
                    marker.addTo(markerLayer);
                    marker.addTo(requestLayer);
                    if(type === 'assigned') marker.addTo(requestAssignedLayer);
                    else marker.addTo(requestPendingLayer);
                })
            })
            .catch(error => console.error('Error fetching request data:', error));

        const overlayMaps = {
            "All": markerLayer,
            "Bases": baseLayer,
            //"Vehicles": vehicleLayer,
            "Vehicles on road": vehicleBusyLayer,
            "Vehicles Idle": vehicleIdleLayer,
            //"Requests": requestLayer,
            "Requests pending": requestPendingLayer ,
            "Requests assigned": requestAssignedLayer ,
            //"Offers": offerLayer,
            "Offers pending": offerPendingLayer,
            "Offers assigned": offerAssignedLayer
        };
        let control = L.control.layers(null, overlayMaps).addTo(map);
            //control.addOverlay(vehicleLayer, "Vehicles")
        function initializeMap() {
            markerLayer.addTo(map);
        }
        initializeMap();
        map.on('load',()=>{
            setTimeout(() => {
                my_marker.openPopup();
            }, 2000);
        })
        const checkboxes = document.querySelectorAll('.leaflet-control-layers-selector');
        let allCheckbox = null;
        checkboxes.forEach(checkbox => {
          const label = checkbox.nextElementSibling.textContent.trim();
          if (label === 'All') {
            allCheckbox = checkbox;
          }
        });
        allCheckbox.addEventListener('change', function() {
          if (this.checked) {
            checkboxes.forEach(checkbox => {
              const label = checkbox.nextElementSibling.textContent.trim();
              if (label !== 'All') {
                checkbox.checked = false;
              }
            });
          }
        });
        checkboxes.forEach(checkbox => {
          const label = checkbox.nextElementSibling.textContent.trim();
          if (label !== 'All') {
            checkbox.addEventListener('change', function() {
              if (this.checked) {
                allCheckbox.checked = false;
              }
            });
          }
        });


    </script>
</body>

</html>

