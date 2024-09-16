<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='stylesheet' type='text/css' media='screen' href='storeManage.css'>
        <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
        <title>Manage Storage</title>

    </head>

    <body>
        <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
        ?>
        <div id='load-json' class="load-json-div">
            Load via Json &nbsp;
            <button type="button" id="add-json-button" class="button_add">Load Json</button>
            <input type="file" id="fileInput" accept=".json" style="display:none;">
            Update via Remote Database &nbsp;
            <button type="button" id="update-button" class="button_modify">Update</button>
        </div>
        <hr/>
        <div id="itemFilters">
            <button type="button" id="add-item-button" class="button_add">Add Another Item</button>
            <button type="button" id="modify-item-button" class="button_modify">Modify Item</button>
            <button type="button" id="modify-items_categ-button" class="button_modify">Modify Item's Category</button>
            <button type="button" id="remove-item-button" class="button_remove">Remove Item</button>
            <label for="categoryFilter">Filter by Category: </label>
            <select id="categoryFilter">
                <option value="all">All</option>
            </select>
        </div>
        <div class="table-container">
            <table id="items-table">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>On Storage</th>
                        <th>On Vehicle</th>
                        <th>Item Category</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody id="items-table-body">
                </tbody>
            </table>
        </div>
        <button type="button" id="add-categ-button" class="button_add">Add Another Category</button>
        <button type="button" id="modify-categ-button" class="button_modify">Modify Category</button>
        <button type="button" id="remove-categ-button" class="button_remove">Remove Category</button>
        <div class="table-container">
            <table id ="category-table">
                <thead>
                    <tr>
                        <th>Category ID</th>
                        <th>Category Name</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody id='category-table-body'>
                </tbody>
            </table>
        </div>
        <button type="button" id="add-vehicle-button" class="button_add">Load Item</button>
        <button type="button" id="modify-vehicle-button" class="button_modify">Modify Quantity</button>
        <button type="button" id="remove-vehicle-button" class="button_remove">Remove Item</button>
        <label for="vehicleFilter">Filter by Vehicle: </label>
        <select id="vehicleFilter">
            <option value="all">All</option>
        </select>
        <div class="table-container">
            <table id="vehicle-table">
                <thead>
                    <tr>
                        <th>Vehicle ID</th>
                        <th>Rescuers Name</th>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody id="vehicle-table-body">
                </tbody>
            </table>
        </div>
        <script>
            const loadJson = document.getElementById('add-json-button');
            const updateDb = document.getElementById('update-button');
            const fileInput = document.getElementById('fileInput');

            updateDb.addEventListener('click', function(event){
               event.preventDefault();
               fetch('../../controller/admin/load_remote_db.php')
               .then(response=>response.json())
               .then(data=>{
                    if(data.added){
                        alert('Updated successfully');
                        location.reload();
                    }else{
                        alert('Error' + data.error);
                    }
               }).catch(error => alert(`${error}`))
            });

            loadJson.addEventListener('click', function() {
                fileInput.click();
            });
            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    if (file.type === 'application/json') {
                        //document.getElementById('status').innerText = `Selected file: ${file.name}`;
                        const formData = new FormData();
                        formData.append('file', file);
                        fetch('../../controller/admin/load_items_json.php', {
                            method: 'POST',
                            body: formData
                        }).then(response => response.json())
                        .then(data => {
                            if(data.added){
                                alert('Updated successfully');
                                location.reload();
                            }else{
                                alert('Error' + data.error);
                            }
                        }).catch(error => {
                             alert('Upload failed.' + error);
                        });
                    } else {
                        alert('Please select a valid JSON file.');
                    }
                }
            });

            const categoryFilter = document.getElementById('categoryFilter');
            const itemsTable = document.getElementById("items-table");
            const itemsTableBody = document.getElementById('items-table-body');

            const categoryTable = document.getElementById("category-table");
            const categoryTableBody = document.getElementById('category-table-body');

            const vehicleFilter = document.getElementById('vehicleFilter');
            const vehicleTable = document.getElementById("vehicle-table");
            const vehicleTableBody = document.getElementById('vehicle-table-body');

            fetch('../../controller/admin/fetch_item_categ.php',{method:'POST'})
            .then(response=>response.json())
            .then(data=>{
                if(data){
                    Object.values(data).forEach(category=>{
                        let name = category.category_name;
                        let id = category.category_id;
                        let details = category.details;
                        //Category filter
                        let option = document.createElement('option');
                        option.value = name;
                        option.innerHTML = name;
                        option.setAttribute('data-category', name);
                        categoryFilter.appendChild(option);
                        //Category Table
                        let tr = document.createElement('tr')
                        tr.setAttribute('data-category', name)
                        tr.innerHTML = `
                                <td>${id}</td>
                                <td>${name}</td>
                                <td>${details}</td>`
                        categoryTableBody.appendChild(tr)
                    })
                }else{
                        let div = document.createElement('div');
                        div.className = 'no-items-message';
                        div.innerHTML = '<b>No categories to display.</b>';
                        categoryTable.appendChild(div)
                }
            })
            .catch(error=>console.log(error))

            fetch('../../controller/admin/fetch_storage.php',{method:'POST'})
            .then(response=>response.json())
            .then(data=>{
                if(data){
                    Object.values(data.items).forEach(item=> {
                        let item_id = item.item_id;
                        let name = item.iname;
                        let quantity = item.quantity;
                        let storage = item.storage;
                        let vehload = item.vehload;
                        let category = item.category;
                        let details = item.details;
                        let tr = document.createElement('tr');
                        tr.setAttribute('data-category', category);
                        tr.innerHTML =
                            `
                                <td>${item_id}</td>
                                <td>${name}</td>
                                <td>${quantity}</td>
                                <td>${storage}</td>
                                <td>${vehload}</td>
                                <td>${category}</td>
                                <td>${details}</td>`
                        itemsTableBody.appendChild(tr)
                    });
                    //Category Filter
                    const rows = document.querySelectorAll('#items-table-body tr');
                    categoryFilter.addEventListener('change', function() {
                        const selectedCategory = this.value;
                        rows.forEach(row => {
                            const itemCategory = row.getAttribute('data-category');
                            if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    });

                }else{
                        let div = document.createElement('div');
                        div.className = 'no-items-message';
                        div.innerHTML = '<b>No items to display.</b>';
                        itemsTable.appendChild(div)
                    }
            })
            .catch(error=>console.log(error))

            fetch('../../controller/admin/fetch_veh_loaded_items.php',{method:'POST'})
                .then(response=>response.json())
                .then(data=>{
                    let addedVehicles = new Set();
                    if(data){
                        Object.values(data).forEach(vehicle=>{
                            let veh_id = vehicle.veh_id;
                            let username = vehicle.username;
                            let item_id;
                            let iname;
                            let load;
                            if(username !== null){
                                item_id = vehicle.item_id;
                                iname = vehicle.iname;
                                load = vehicle.load;
                            }else{
                                username = '-';
                                item_id = '-';
                                iname = '-';
                                load = '-';
                            }
                            //Vehicle FIlter
                            if(!addedVehicles.has(veh_id)){
                                let option = document.createElement('option');
                                option.value = veh_id;
                                option.innerHTML = veh_id;
                                option.setAttribute('data-vehicle', veh_id);
                                vehicleFilter.appendChild(option);
                                addedVehicles.add(veh_id);
                            }
                            //Vehicle Table
                            let tr = document.createElement('tr');
                            tr.setAttribute('data-vehicle', veh_id);
                            tr.innerHTML =
                                `<td>${veh_id}</td>
                                <td>${username}</td>
                                <td>${item_id}</td>
                                <td>${iname}</td>
                                <td>${load}</td>
                                `;
                            vehicleTableBody.appendChild(tr)
                        });
                        const vehicleRows = document.querySelectorAll('#vehicle-table-body tr');
                         vehicleFilter.addEventListener('change', function() {
                             const selectedVehicle = this.value;
                             vehicleRows.forEach(row => {
                                 const vehicle = row.getAttribute('data-vehicle');
                                 if (selectedVehicle === 'all' || vehicle === selectedVehicle) {
                                     row.style.display = '';
                                 } else {
                                     row.style.display = 'none';
                                 }
                             });
                         });
                    }else{
                        let div = document.createElement('div');
                        div.className = 'no-items-message';
                        div.innerHTML = '<b>No vehicle is loaded.</b>';
                        vehicleTable.appendChild(div)
                    }
                })
                .catch(error=>console.log(error));

            const addItem = document.getElementById('add-item-button');
            const modifyItem = document.getElementById('modify-item-button');
            const modifyItemsCategory = document.getElementById('modify-items_categ-button');
            const removeItem = document.getElementById('remove-item-button');

            const addCategory = document.getElementById('add-categ-button');
            const modifyCategory = document.getElementById('modify-categ-button');
            const removeCategory = document.getElementById('remove-categ-button');

            const addVehicle = document.getElementById('add-vehicle-button');
            const modifyVehicle = document.getElementById('modify-vehicle-button');
            const removeVehicle = document.getElementById('remove-vehicle-button');




            addItem.addEventListener('click', function(event){
               event.preventDefault();
               window.location.href = 'add_item_form.php';
            });
            modifyItemsCategory.addEventListener('click', function(event){
               event.preventDefault();
               window.location.href = 'modify_category_of_item.php';
            });
            modifyItem.addEventListener('click', function(event){
               event.preventDefault();
               window.location.href = 'modify_item_form.php';
            });
            removeItem.addEventListener('click', function(event){
               event.preventDefault();
               window.location.href = 'remove_item_form.php';
            });

            addCategory.addEventListener('click', function(event){
               event.preventDefault();
               window.location.href = 'add_category_form.php';
            });
            modifyCategory.addEventListener('click', function(event){
               event.preventDefault();
               window.location.href = 'modify_category_form.php';
            });
            removeCategory.addEventListener('click', function(event){
               event.preventDefault();
               window.location.href = 'remove_category_form.php';
            });

            addVehicle.addEventListener('click', function(event){
               event.preventDefault();
               window.location.href = 'add_vehicle_form.php';
            });
            modifyVehicle.addEventListener('click', function(event){
               event.preventDefault();
               window.location.href = 'modify_vehicle_form.php';
            });
            removeVehicle.addEventListener('click', function(event){
               event.preventDefault();
               window.location.href = 'remove_vehicle_form.php';
            });
        </script>
    </body>
</html>
