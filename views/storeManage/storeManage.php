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
        <?php include '../storage/filter_storage_by_quantity.php';?>
        <?php if (!empty($combined_items)) : ?>
            <div class="table-container">
                <table id="items-table">
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
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
                                <td><?= $item['category'] ?></td>
                                <td><?= $item['details'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <br/><div class='no-items-message'><b>No items to display.<b/></div>
        <?php endif; ?>
        <?php include './filter_categories.php'; ?>
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
            <br/><div class='no-items-message'><b>No categories to display.<b/></div>
        <?php endif; ?>
        <?php include './filter_vehicles.php'; ?>
        <?php if (!empty($vehicle_load_array)) : ?>
            <div class="table-container">
                <table>
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
                            <tr >  <?php //data-category="<?= $categ['category']" ?>
                                <td><?= $veh['veh_id'] ?></td>
                                <td><?= $veh['username'] ?></td>
                                <td><?= $veh['item_id'] ?></td>
                                <td><?= $veh['iname'] ?></td>
                                <td><?= $veh['load'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <br/><div class='no-items-message'><b>No vehicles to display.<b/></div>
        <?php endif; ?>
        <script>

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
