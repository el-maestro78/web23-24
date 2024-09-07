<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link rel='stylesheet' type='text/css' media='screen' href='modifyForm.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
    <title>Update Vehicle Load</title>
</head>
<body>
    <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
        //Vehicle load
        include '../../controller/admin/fetch_veh_loaded_items.php';
    ?>
    <?php
    $vehicle_items = [];
        foreach ($vehicle_load_array as $veh) {
            $vehicle = $veh['veh_id'];
            $id = $veh['item_id'];
            $name = $veh['iname'];
            $quant = $veh['load'];
            if (!isset($vehicle_items[$vehicle])) {
                $vehicle_items[$vehicle] = [];
            }
            $vehicle_items[$vehicle][] = ['id' => $id, 'name' => $name, 'quantity' => $quant];
        }
    ?>
    <div class="container">
        <div class="form_box">
            <div class="details">Update Vehicle Load</div>
            <div class="form">
                <label for="vehicle" class="insert_label">Select Vehicle</label>
                <select id="vehicle" class="select_input" required>
                    <option value="" disabled selected>Select a vehicle</option>
                    <?php foreach ($vehicle_items as $vehicle => $items): ?>
                        <option value="<?php echo $vehicle; ?>">Vehicle: <?php echo $vehicle; ?></option>
                    <?php endforeach; ?>
                </select>
                <label for="item" class="insert_label">Select Item</label>
                <select id="item" class="select_input" required>
                    <option value="" disabled selected>Select an item</option>
                </select>
                <label for="quantity" class="insert_label">Update Quantity</label>
                <input type="number" id="quantity" class="quantity_input" required step="1" min="-100" max="100">
                <input type="submit" class="button_input" id="submit" value="Submit">
            </div>
        </div>
    </div>

    <script>
        const vehicleItems = <?php echo json_encode($vehicle_items); ?>;
        const vehicleSelect = document.getElementById('vehicle');
        const itemSelect = document.getElementById('item');

        vehicleSelect.addEventListener('change', function() {
            const selectedVehicle = this.value;
            itemSelect.innerHTML = '<option value="" disabled selected>Select an item</option>';

            if (selectedVehicle && vehicleItems[selectedVehicle]) {
                vehicleItems[selectedVehicle].forEach(function(item) {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = `${item.name} - ${item.quantity}`;
                    itemSelect.appendChild(option);
                });
            }
        });
        const vehInput = document.getElementById('vehicle');
        const itemInput = document.getElementById('item');
        const quantityInput = document.getElementById('quantity');
        const submit = document.getElementById('submit');

        quantityInput.addEventListener('input', function (event) {
            event.preventDefault();
            this.value = this.value.replace(/[^0-9\-]/g, '');
        });

        submit.addEventListener('click', function (event){
            event.preventDefault();
            if(quantityInput.value.trim()  === '' && quantityInput.value.trim()  !== 0){
                alert('You have to give quantity');
            }else {
                submit_data();
            }
        });

        function submit_data(){
            const item = itemInput.value;
            const vehicle = vehInput.value;
            const quantity = quantityInput.value.trim();
            const params = new URLSearchParams();
            params.append('item', item);
            params.append('vehicle', vehicle);
            params.append('quantity', quantity);

            fetch('../../controller/admin/update_vehicle_load.php', {
                method:'POST',
                body:params
            })
            .then(response => response.json())
            .then(data =>{
                if (data.updated) {
                    let goBack = confirm('Updated successfully for vehicle ' + vehicle + '! Do you want to go back?');
                        if(goBack){
                            window.location.href ='storeManage.php';
                        }else{
                            location.reload();
                        }
                } else if(!data.exists){
                    alert('Item doesn\'t exist in the vehicle ' + vehicle);
                }else if(data.removed_all){
                    alert('You removed more than the current load');
                }else if(data.lacking){
                    alert('There isn\'t efficient quantity');
                }else{
                    alert('Error: ' + data.error);// Item is needed or loaded in a vehicle');
                }
            })
            .catch(error => console.error('Error updated the vehicle load from the database:', error));
        }
    </script>
</body>
</html>
