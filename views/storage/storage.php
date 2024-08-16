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
        <?php include '../toolbar.php'; ?>
        <?php include '../../controller/admin/fetch_storage.php';
        /*
         "item_id":"0","iname":"spam","quantity":"1","category":"0","details":"Just spam"}*/
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
                    <tbody>";

            // Loop through combined items and display in table rows
            foreach ($combined_items as $item) {
                echo "<tr>
                        <td>{$item['item_id']}</td>
                        <td>{$item['iname']}</td>
                        <td>{$item['quantity']}</td>
                        <td>{$item['category']}</td>
                        <td>{$item['details']}</td>
                      </tr>";
            }

            echo "</tbody>
                </table>";
        } else {
            echo "<br/><div class='no-items-message'><b>No items to display.<b/></div>";
        }  ?>
        <script>

        </script>
    </body>
</html>