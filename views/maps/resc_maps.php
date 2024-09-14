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
    <div class="panel" id="tasks-panel">
        <h4>Tasks</h4>
        <table class="table">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody id="tasks-table">
                </tbody>
            </table>
    </div>
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
        //const vehicleLayer = L.layerGroup();
        //const vehicleIdleLayer= L.layerGroup();
        //const vehicleBusyLayer= L.layerGroup();
        //const myOffersLayer = L.layerGroup();
        //const offerLayer = L.layerGroup();
        const offerPendingLayer = L.layerGroup();
        const offerAssignedLayer = L.layerGroup();
        //const requestLayer = L.layerGroup();
        //const myRequestsLayer = L.layerGroup();
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
        let my_marker = null;
        let veh_lat = null;
        let veh_long = null;
        const tasksDiv = document.getElementById("tasks-panel");
        const tasksTable = document.getElementById("tasks-table");
        /*
        fetch(`../../controller/admin/fetch_tasks_for_line.php?veh_id=${encodeURIComponent(id)}`)
        .then(response=>response.json())
        .then(data=>{

        })
        .catch(error=>console.log('Error ' + error));
         */

        fetch('../../controller/rescuer/get_my_vehicle.php')
            .then(response=>response.json())
            .then(data=>{
                my_vehicle = data.veh_id;
                veh_lat = data.lat;
                veh_long = data.long;
                let vehColor = "pink";
                let marker = L.marker([veh_lat, veh_long], {
                    icon: L.AwesomeMarkers.icon({
                        icon: 'car',
                        prefix: 'fa',
                        markerColor: vehColor,
                    }),
                    draggable: true
                }).addTo(map);
                let start_pos = marker.getLatLng();
                marker.on('dragend', (event) => {
                    const userConfirm = confirm('Are you sure you want to move the vehicle here?')
                    if (userConfirm){
                        vehicleDrag(event, my_vehicle);
                        start_pos = event.target.getLatLng();
                    }else{
                        marker.setLatLng(start_pos, {
                            draggable: true
                        }).update();
                    }
                });
                marker.on('click', async () => {
                    const content = await vehiclePopup(data);
                    marker.bindPopup(content).openPopup();
                    let tasks = await getVehicleTasks(my_vehicle);
                    drawVehicleLine(marker, tasks);
                    polylineLayerGroup.clearLayers();
                });
                marker.addTo(markerLayer);
                if(my_vehicle === null){
                    setTimeout(loadRescuerTasks, 1500)
                    setTimeout(tasksList, 1500)
                }else{
                    loadRescuerTasks(my_vehicle);
                    tasksList(my_vehicle, tasksTable);
                }
            }).catch(error => console.error('Error fetching vehicle data:', error));

        async function loadRescuerTasks(id) {
            const my_tasks = await rescuersTasks(id);
            my_tasks.offers.forEach(offer=>{
                let marker = L.marker([offer.lat, offer.long], {
                    icon: L.AwesomeMarkers.icon({
                        icon: 'gift',
                        prefix: 'fa',
                        markerColor: 'green',
                    })
                }).addTo(map);
                marker.on('click', async () => {
                    const content = await offerPopup(offer);
                    //console.log(content)
                    marker.bindPopup(content);
                });
                marker.addTo(markerLayer);
                marker.addTo(offerAssignedLayer);
            });
            my_tasks.requests.forEach(req=>{
                let marker = L.marker([req.lat, req.long], {
                    icon: L.AwesomeMarkers.icon({
                        icon: 'exclamation',
                        prefix: 'fa',
                        markerColor: 'green',
                    })
                }).addTo(map);
                marker.on('click', async () => {
                    const content = await requestPopup(req);
                    marker.bindPopup(content);
                });
                marker.addTo(markerLayer);
                marker.addTo(requestAssignedLayer);
            })
        }

        //Fetching pending offers
        fetch('../../controller/admin/fetch_offers.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(offer => {
                    let type = getDataType(offer);
                    if(type === 'pending'){
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
                            const content = await offerPopupRescuer(offer);
                            //console.log(content)
                            marker.bindPopup(content);
                        });
                        marker.addTo(markerLayer);
                        marker.addTo(offerPendingLayer);
                    }
                });
            })
            .catch(error => console.error('Error fetching offer data:', error));
        //Fetching pending requests
        fetch('../../controller/admin/fetch_requests.php')
            .then(response => response.json())
            .then(data => {
                data.forEach(request => {
                    let type = getDataType(request);
                    if (type !== 'assigned'){
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
                            const content = await requestPopupRescuer(request);
                            //console.log(content)
                            marker.bindPopup(content);
                        });
                        marker.addTo(markerLayer);
                        marker.addTo(requestPendingLayer);
                    }
                })
            })
            .catch(error => console.error('Error fetching request data:', error));

        const overlayMaps = {
            "All": markerLayer,
            "Bases": baseLayer,
            "My Requests": requestAssignedLayer,
            "Requests pending": requestPendingLayer ,
            "My Offers": offerAssignedLayer,
            "Offers pending": offerPendingLayer,
        };
        let control = L.control.layers(null, overlayMaps).addTo(map);
            //control.addOverlay(vehicleLayer, "Vehicles")
        function initializeMap() {
            markerLayer.addTo(map);
        }
        initializeMap();
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

