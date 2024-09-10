<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link rel='stylesheet' type='text/css' media='screen' href='removeForm.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
    <title>Remove Item</title>
</head>
<body>
    <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
        //Vehicle load
        //include '../../controller/admin/fetch_veh_loaded_items.php';
    ?>
    <div class="container">
        <div class="form_box">
            <div class="details">Remove Item from Vehicle Load</div>
            <div class="form">
                <label for="vehicle" class="insert_label">Select Vehicle</label>
                <select id="vehicle" class="select_input" required>
                    <option value="" disabled selected>Select a vehicle</option>
                </select>
                <label for="item" class="insert_label">Select Item</label>
                <select id="item" class="select_input" required>
                    <option value="" disabled selected>Select an item</option>
                </select>

                <input type="submit" class="button_input" id="submit" value="Submit">
            </div>
        </div>
    </div>

    <script>
        const vehicleSelect = document.getElementById('vehicle');
        const itemSelect = document.getElementById('item');
        let vehicle_items = {}

        fetch('../../controller/admin/fetch_veh_loaded_items.php',{
            method:'POST'
        })
        .then(response=>response.json())
        .then(data=>{
            let addedVehicles = new Set();
            data.forEach(vehicle =>{
                let veh_id = vehicle.veh_id;
                if(!addedVehicles.has(veh_id)){
                    let option = document.createElement('option');
                    option.value = veh_id;
                    option.setAttribute('id', veh_id);
                    option.innerHTML = `Vehicle: ${veh_id}`;
                    vehicleSelect.appendChild(option)
                    addedVehicles.add(veh_id);
                }
                let quant = vehicle.load;
                let item_id = vehicle.item_id;
                let item_name = vehicle.iname;
                if (!vehicle_items[veh_id]) {
                    vehicle_items[veh_id] = [];
                }
                vehicle_items[veh_id].push({
                        id: item_id,
                        name: item_name,
                        quantity: quant
                    });
            })
        })
        const vehicleItems = vehicle_items;

        vehicleSelect.addEventListener('change', function() {
            const selectedVehicle = this.value;
            itemSelect.innerHTML = '<option value="" disabled selected>Select an item</option>';

            if (selectedVehicle && vehicleItems[selectedVehicle]) {
                vehicleItems[selectedVehicle].forEach(function(item) {
                    const option = document.createElement('option');
                    option.value = item.id;
                    if(item.name !== null){
                        option.textContent = `${item.name} - ${item.quantity}`;
                    }else{
                        option.textContent = 'Nothing is loaded';
                    }
                    itemSelect.appendChild(option);
                });
            }
        });
        const vehInput = document.getElementById('vehicle');
        const itemInput = document.getElementById('item');
        const submit = document.getElementById('submit');

        submit.addEventListener('click', function (event){
            event.preventDefault()
            const userConfirmed = confirm('Are you sure you want to remove this item from the vehicle?');
            if (userConfirmed) {
                submit_data();
            }else {
                alert('Removal canceled.');
            }
        });

        function submit_data(){
            const item = itemInput.value;
            const vehicle = vehInput.value;
            const params = new URLSearchParams();
            params.append('item', item);
            params.append('vehicle', vehicle);
            fetch('../../controller/admin/remove_from_vehicle.php', {
                method:'POST',
                body:params
            })
            .then(response => response.json())
            .then(data =>{
                if (data.removed) {
                    let goBack = confirm('Removed successfully from vehicle ' + vehicle);
                        if(goBack){
                            window.location.href ='storeManage.php';
                        }else{
                            location.reload();
                        }
                } else if(!data.removed && !data.exists){
                    alert('Item doesn\'t exist in the vehicle ' + vehicle);
                }else{
                    alert('Error: ' + data.error);// Item is needed or loaded in a vehicle');
                }
            })
            .catch(error => console.error('Error removing this item from the database:', error));
        }
    </script>
</body>
</html>
