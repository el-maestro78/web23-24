<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="../favico/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="./storage.css">
        <title>Items Storage</title>

    </head>

    <body>
        <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../toolbar.php';
        include '../../controller/admin/fetch_storage.php';
        include './filter_storage_by_quantity.php';
        if (!empty($combined_items)) {
            echo "<table>
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Item Category</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>";?>
             <?php foreach ($combined_items as $item): ?>
                        <tr data-category="<?= $item['category'] ?>">
                            <td><?= $item['item_id'] ?></td>
                            <td><?= $item['iname'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= $item['category'] ?></td>
                            <td><?= $item['details'] ?></td>
                        </tr>
                    <?php endforeach; ?>
        <?php
            echo "</tbody>
                </table>";
        } else {
            echo "<br/><div class='no-items-message'><b>No items to display.<b/></div>";
        }  ?>
        <script src="storage.js" defer></script>
    </body>
</html>