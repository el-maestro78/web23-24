<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <link rel='stylesheet' type='text/css' media='screen' href='vehicle_load.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="icon" href="../../favico/favicon.ico" type="image/x-icon">
        <title>Manage Storage</title>

    </head>

    <body>
        <?php
        include '../../../ini.php';
        include '../../../check_login.php';
        include '../../toolbar.php';
        ?>

        <div id = "info" class = "text_box"> </div>
        
        <div class = 'button_container'>
        <a href='vehicle_load.php' class="button_cancel"> Back </a>
        <p> You have to save each change separately. <br> Once you press save for a change, there is no undo. You will have to change it again manually.</p>
        </div>

        <div class="table-container">
            <form>
                <table id="vehicle-load-table">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Base Stock</th>
                            <th>Actions</th>
                        </tr>
                     </thead>
                    <tbody id = 'table_body'></tbody>
                </table>
                <table id="vehicle-load-newrow">
                    <tbody id="load_newrow">
                        <tr id = "rowButton">
                           <td><button type="button" id="addRow_button" class="button_row">Load New Item</button></td>
                           <td></td><td></td><td></td><td></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
      
        <script>
            let rowCounter=0;
            let loadedItemIds = [];
            fetch(`../../../controller/rescuer/vehicle_load_queries.php?timestamp=${new Date().getTime()}`)
            .then(response=>response.json())
            .then(data=>{
                //console.log(data);
                
                if (data.current_distance[1] > 100) {
                        alert('You are too far away from the base to edit the vehicle load.');
                    window.location.href = 'vehicle_load.php';
                    } 
                    
                const info_div = document.getElementById('info');
                let info = data.veh_id;
                let distance = data.current_distance;
                info_div.innerHTML = `
                    <h2>Assigned Vehicle (Id): ${info.veh_id}</h2>
                    <p>Closest Base's Id: ${distance[0]} |
                    Distance: ${distance[1]}m</p>`

                const table = document.getElementById('table_body');
                Object.values(data.veh_info).forEach(vehicle=>{
                    loadedItemIds.push(vehicle.item_id);
                    const row = document.createElement('tr');
                    const initial_quant = vehicle.load;
                    row.innerHTML = `
                        <td>${vehicle.item_id}</td>
                        <td>${vehicle.iname}</td>
                        <td>
                            <input type="number" id="update_quantity_input" value="${vehicle.load}"  min="0" max="${Number(vehicle.load)+Number(vehicle.base_quantity)}" class="load-input">
                        </td>
                        <td id="base_stock">${vehicle.base_quantity} units </td>
                        <td>
                            <button type="button" id="delete_item" class="button_row">Remove Item</button>
                            <button type="button" id="update_quantity" class="button_not_allowed">Save</button>
                        `
                        table.appendChild(row);

                        const load_input = row.querySelector('#update_quantity_input');
                        const save_button = row.querySelector('#update_quantity');
                        const base_stock = row.querySelector('#base_stock');
                        const updateButton = row.querySelector('#update_quantity');
                        const removeButton = row.querySelector('#delete_item');

                        updateButton.addEventListener('click', function(){
                            /*
                            console.log('Preparing to send data...');
                            console.log(`Vehicle ID: ${info.veh_id}`);
                            console.log(`Item ID: ${vehicle.item_id}`);
                            console.log(`Load: ${load_input.value}`);
                            console.log(`New Item Quantity: ${Number(vehicle.base_quantity) - Number(load_input.value)+Number(vehicle.load)}`);
                            */
                            fetch('../../../controller/rescuer/vehicle_load_actions.php', {
                                method: 'POST',
                                body: new URLSearchParams({
                                    'action': 'update',
                                    'veh_id': `${info.veh_id}`,
                                    'item_id': `${vehicle.item_id}`,
                                    'load': `${load_input.value}`,
                                    'new_item_quantity': ` ${Number(vehicle.base_quantity) - Number(load_input.value)+Number(vehicle.load)}`
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                //console.log(data)
                                if (data.action_status) {
                                    alert('Vehicle load updated successfully.');
                                    location.reload();
                                } else {
                                    alert('Failed to update vehicle load.');
                                    //alert(data.error);
                                }
                            })
                            .catch(error => console.error('Error: ' + error));
                        });

                        load_input.addEventListener('input', function(){
                            if (load_input.value !== initial_quant) {
                                save_button.disabled = false;
                                save_button.classList.remove('button_not_allowed');
                                save_button.classList.add('button_edit');

                                base_stock.innerHTML = `${Number(vehicle.base_quantity) - Number(load_input.value)+Number(vehicle.load)} units`;
                            }
                            else {
                                save_button.disabled = true; 
                                save_button.classList.remove('button_edit');
                                save_button.classList.add('button_not_allowed');

                                base_stock.innerHTML = `${Number(vehicle.base_quantity)} units`;
                            }
                        });

                        removeButton.addEventListener('click', function(){
                            /*
                            console.log('Preparing to send data...');
                            console.log(`Vehicle ID: ${info.veh_id}`);
                            console.log(`Item ID: ${vehicle.item_id}`);
                            console.log(`Load: ${load_input.value}`);
                            console.log(`New Item Quantity: ${Number(vehicle.base_quantity) - Number(load_input.value)+Number(vehicle.load)}`);
                            */
                            fetch('../../../controller/rescuer/vehicle_load_actions.php', {
                                method: 'POST',
                                body: new URLSearchParams({
                                    'action': 'delete',
                                    'veh_id': `${info.veh_id}`,
                                    'item_id': `${vehicle.item_id}`,
                                    'load': `${load_input.value}`,
                                    'new_item_quantity': ` ${Number(vehicle.base_quantity) - Number(load_input.value)+Number(vehicle.load)}`
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                //console.log(data)
                                if (data.action_status) {
                                    alert('Vehicle load removed successfully.');
                                    location.reload();
                                } else {
                                    alert('Failed to update vehicle load.');
                                    //alert(data.error);
                                }
                            })
                            .catch(error => console.error('Error: ' + error));
                        });
                });
                
                const new_items = document.getElementById('load_newrow');
                document.getElementById('addRow_button').addEventListener('click', function () {
                    rowCounter++;
                    if (rowCounter===1)
                    {const buttonRow = document.getElementById('rowButton');
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td id="selected_item_id">Choose an item:</td>
                        <td> 
                            <select id="select_item_cat">
                                <option value="null" selected> Category </option>
                            </select>
                            <select id="select_item">
                                <option value="null" disabled selected> Item </option>
                            </select>
                        </td>
                        <td id="select_quantity">
                            <input type="number" id="select_quantity_input" value="0" min="0" max="0" class="load-input">
                        </td>
                        <td id="new_base_stock"> </td>
                        <td>
                            <button type="button" class="button_row" onclick="removeRow(this);">Cancel</button>
                            <button type="button"  id="load_item" class="button_not_allowed" disabled>Load Item</button>
                        </td>
                    `;
                    new_items.insertBefore(newRow, buttonRow);

                    const loadButton = newRow.querySelector('#load_item');
                    loadButton.addEventListener('click', function(){
                        /*
                            console.log('Preparing to send data...');
                            console.log(`Vehicle ID: ${info.veh_id}`);
                            console.log(`Item ID: ${vehicle.item_id}`);
                            console.log(`Load: ${load_input.value}`);
                            console.log(`New Item Quantity: ${Number(vehicle.base_quantity) - Number(load_input.value)+Number(vehicle.load)}`);
                            */
                        const load_input = newRow.querySelector('#select_quantity_input');
                        const selectedItem = newRow.querySelector('#select_item').value;
                        const baseStock = newRow.querySelector('#new_base_stock').textContent.trim();

                        fetch('../../../controller/rescuer/vehicle_load_actions.php', {
                                method: 'POST',
                                body: new URLSearchParams({
                                    'action': 'add',
                                    'veh_id': `${info.veh_id}`,
                                    'item_id': `${selectedItem}`,
                                    'load': `${load_input.value}`,
                                    'new_item_quantity': ` ${Number(baseStock) - Number(load_input.value)+Number(load_input.value)}`
                                })
                        })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data)
                                if (data.action_status) {
                                    alert('Item loaded successfully.');
                                    location.reload();
                                } else {
                                    //alert('Failed to load vehicle.');
                                    alert(data.error);
                                }
                            })
                            .catch(error => console.error('Error: ' + error));
                        });

                    const select_cat = document.getElementById(`select_item_cat`);
                    Object.values(data.categories_array).forEach(category=>{
                        const option_cat = document.createElement('option');
                        option_cat.value = category.category_id;
                        option_cat.textContent = category.category_name;
                        select_cat.appendChild(option_cat);
                    })
                    
                    const select_items = document.getElementById(`select_item`);
                    const availableItems = data.items_array.filter(item => !loadedItemIds.includes(item.item_id));
                    Object.values(availableItems).forEach(item=>{
                            const option_items = document.createElement('option');
                            option_items.value = item.item_id;
                            option_items.textContent = item.iname;
                            select_items.appendChild(option_items)
                    })

                    const selected_item_id = document.getElementById('selected_item_id');
                    const new_base_stock = document.getElementById('new_base_stock');
                    const select_quantity_input = document.getElementById('select_quantity_input');
                    const load_button = document.getElementById('load_item');
                    

                    select_cat.addEventListener('change', function(){
                        const selected_category = select_cat.value;
                        selected_item_id.innerHTML = 'Choose an item:'
                        select_items.innerHTML = '<option value="null" disabled selected> Item </option>';

                        if (selected_category!=='null')
                        {
                            Object.values(availableItems).forEach(item=>{
                                if (item.category === selected_category) {
                                    const option_items = document.createElement('option');
                                    option_items.value = item.item_id;
                                    option_items.textContent = item.iname;
                                    select_items.appendChild(option_items)
                                }
                            })
                        }
                        else {
                            Object.values(availableItems).forEach(item=>{
                                const option_items = document.createElement('option');
                                option_items.value = item.item_id;
                                option_items.textContent = item.iname;
                                select_items.appendChild(option_items);
                            })
                        }
                    })

                    select_items.addEventListener('change', function(){
                        const selected_item = data.items_array.find(item => item.item_id === select_items.value);
                        selected_item_id.innerHTML = `${select_items.value}`
                        new_base_stock.innerHTML = `${selected_item.quantity} units`
                        select_quantity_input.max = `${selected_item.quantity}`
                        select_quantity_input.value = 0
                    })

                    select_quantity_input.addEventListener('input', function(){
                        const selected_item = data.items_array.find(item => item.item_id === select_items.value);
                        if (Number(select_quantity_input.value) > 0) {
                            load_button.disabled = false;
                            load_button.classList.remove('button_not_allowed');
                            load_button.classList.add('button_edit');

                            new_base_stock.innerHTML = `${Number(selected_item.quantity) - Number(select_quantity_input.value)} units`
                        }
                        else {
                            load_button.disabled = false;
                            load_button.classList.add('button_not_allowed');
                            load_button.classList.remove('button_not_edit');

                            new_base_stock.innerHTML = `${Number(selected_item.quantity)} units`
                        }
                    })
                    }
                })

            })
            .catch(error=>console.log(error))

            function removeRow(button) { 
                const row = button.closest('tr');
                row.remove();
                rowCounter=0;
            }

        </script>
    </body>
</html>
