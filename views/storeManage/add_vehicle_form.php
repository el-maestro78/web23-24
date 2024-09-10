<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <link rel='stylesheet' type='text/css' media='screen' href='addForm.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
    <title>Add new Item to Vehicle</title>
</head>
<body>
    <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
        //Vehicle load
        //include '../../controller/admin/fetch_veh_loaded_items.php';
        // $items_array
        //include '../../controller/admin/fetch_items.php';

    ?>
    <div class="container">
            <div class="form_box">
                <div class="details">Add new Item to Vehicle</div>
                <div class="form">
                    <label for="vehicle" class="insert_label">Select Vehicle</label>
                    <select id="vehicle" class="select_input" required>
                    </select>
                    <label for="item" class="insert_label">Select Item</label>
                    <select id="item" class="categ_input" required>
                    </select>
                    <label for="quantity" class="insert_quantity">Quantity</label>
                    <input type="number" id="quantity" class="insert_input" required step="1" min="0">
                    <input type="submit" class="button_input" id="submit" value="Submit">
                </div>
            </div>
    </div>
    <script>
        const itemInput = document.getElementById('item');
        const vehicleInput = document.getElementById('vehicle');
        const quantityInput = document.getElementById('quantity');
        const submit = document.getElementById('submit');

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
                    vehicleInput.appendChild(option)
                    addedVehicles.add(veh_id);
                }
            })
         })
         .catch(error=> console.log(error));

        fetch(`../../controller/admin/fetch_items.php?timestamp=${new Date().getTime()}`,{
            method:'POST'
        })
        .then(response=>response.json())
        .then(data=>{
           Object.values(data.items).forEach(item =>{
                let id = item.item_id;
                let name = item.iname;
                let quant = item.quantity;
                let option = document.createElement('option');
                option.value = id;
                option.innerHTML = `Name: ${name} - Quantity: ${quant}`;
                itemInput.appendChild(option);
            })
         })
         .catch(error=> console.log(error));



        submit.addEventListener('click', function (event){
            event.preventDefault()
            if(quantityInput.value.trim()  === ''){
                alert('You have to specify the quantity')
            }else {
                submit_data();
            }
        });
        quantityInput.addEventListener('input', function (event) {
            event.preventDefault()
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        function submit_data(){
            const item = itemInput.value;
            const vehicle = vehicleInput.value;
            const quantity = quantityInput.value;

            const params = new URLSearchParams();
            params.append('item', item);
            params.append('vehicle', vehicle);
            params.append('quantity', quantity);

            fetch('../../controller/admin/add_item_vehicle.php', {
                method:'POST',
                body:params
            })
            .then(response => response.json())
            .then(data =>{
     //['exists' => true, 'created' => false,'lacking' => false, 'error' => pg_last_error($dbconn)]);
                if (data.updated) {
                        let goBack = confirm('Updated successfully! Do you want to go back?');
                        if(goBack){
                            window.location.href ='storeManage.php';
                        }else{
                            location.reload();
                        }
                    } else if(data.lacking && data.exists){
                        alert('There is not enough quantity on the stores');
                    } else if(data.exists){
                        alert('Cant load the vehicle');
                    } else{
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => console.error('Error saving this item to the database:', error));
        }
    </script>
</body>
</html>