<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='stylesheet' type='text/css' media='screen' href='../storage/storage.css'>
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
        <?php
        //items on storage and loaded
        include '../../controller/admin/fetch_storage.php';
        //categories
        include '../../controller/admin/fetch_item_categ.php';
        //Vehicle load
        include '../../controller/admin/fetch_veh_loaded_items.php';

        ?>
        <div id='load-json' class="load-json-div">
            <!-- LOAD from json and update through their database button TODO-->
            Load via Json &nbsp;
            <button type="button" id="add-json-button" class="button_add">Load Json</button>
            &nbsp;&nbsp;&nbsp;&nbsp;
            Update via Database &nbsp;
            <button type="button" id="update-button" class="button_modify">Update</button>
        </div>
        <hr/>
        <div id="itemFilters">
            <button type="button" id="add-item-button" class="button_add">Add Another Item</button>
            <button type="button" id="modify-item-button" class="button_modify">Modify Item</button>
            <button type="button" id="modify-items_categ-button" class="button_modify">Modify Item's Category</button>
            <button type="button" id="remove-item-button" class="button_remove">Remove Item</button>
            <?php include '../storage/filter_storage_by_quantity.php';?>
        </div>
        <?php if (!empty($combined_items)) : ?>
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
                    <tbody>
                        <?php foreach ($combined_items as $item): ?>
                            <tr data-category="<?= $item['category'] ?>">
                                <td><?= $item['item_id'] ?></td>
                                <td><?= $item['iname'] ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= $item['storage'] ?></td>
                                <td><?= $item['vehload'] ?></td>
                                <td><?= $item['category'] ?></td>
                                <td><?= $item['details'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <br/><div class='no-items-message'><b>No items to display.</b></div>
        <?php endif; ?>
        <button type="button" id="add-categ-button" class="button_add">Add Another Category</button>
        <button type="button" id="modify-categ-button" class="button_modify">Modify Category</button>
        <button type="button" id="remove-categ-button" class="button_remove">Remove Category</button>
        <!--Not Sure if Need this TODO-->
            <?php //include './filter_categories.php'; ?>
        <?php if (!empty($categories_array)) : ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Category ID</th>
                            <th>Category Name</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories_array as $categ): ?>
                            <tr >  <?php //data-category="<?= $categ['category']" ?>
                                <td><?= $categ['category_id'] ?></td>
                                <td><?= $categ['category_name'] ?></td>
                                <td><?= $categ['details'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <br/><div class='no-items-message'><b>No categories to display.</b></div>
        <?php endif; ?>
        <button type="button" id="add-vehicle-button" class="button_add">Load Item</button>
        <button type="button" id="modify-vehicle-button" class="button_modify">Modify Quantity</button>
        <button type="button" id="remove-vehicle-button" class="button_remove">Remove Item</button>
        <?php include './filter_vehicles.php'; ?>
        <?php if (!empty($vehicle_load_array)) : ?>
            <div class="table-container">
                <table id="vehicle-table">
                    <thead>
                        <tr>
                            <th>Vehicle ID</th>
                            <th>Vehicle Name</th>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vehicle_load_array as $veh): ?>
                            <tr data-category="<?= $veh['veh_id']?>">
                                <td><?= $veh['veh_id'] ?></td>
                                <td><?= $veh['username'] ?></td>
                                <td><?= $veh['item_id'] ?? '-' ?></td>
                                <td><?= $veh['iname'] ?? '-' ?></td>
                                <td><?= $veh['load'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <br/><div class='no-items-message'><b>No vehicles to display.</b></div>
        <?php endif; ?>
        <script>
            const loadJson = document.getElementById('add-json-button');
            const updateDb = document.getElementById('update-button');

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

            loadJson.addEventListener('click', function(event){
               event.preventDefault();
               alert('Nothing yet');
            });
            updateDb.addEventListener('click', function(event){
               event.preventDefault();
               alert('Nothing yet');
            });


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
            /*
            fetch(../../controller/admin/add_item.php);
            fetch(../../controller/admin/details_item_category.php);
            fetch(../../controller/admin/load_items_json.php);
            fetch(../../controller/admin/remove_item_category.php);
            //fetch(../../controller/admin/update_item.php);
            //fetch(../../controller/admin/update_item_category.php);
            fetch(../../controller/admin/update_item_details.php);
            fetch(../../controller/admin/update_item_quantity.php);
            //*/
        </script>
        <script src="../storage/storage.js" defer></script>
    </body>
</html>
