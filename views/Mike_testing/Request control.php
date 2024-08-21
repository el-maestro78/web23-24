<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM categories";
$categories_result = mysqli_query($conn, $query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $civilian_id = $_SESSION['civ_id'];
    $civilian_item_id = $_POST['civ_item'];
    $civilian_quantity = $_POST['civ_quantity'];

    
    $insert_query = "INSERT INTO requests (civilian_id, civilian_item_id, civilian_quantity, request_date) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, 'iii', $citizen_id, $item_id, $quantity);

    if (mysqli_stmt_execute($stmt)) {
        echo "Your request has successfully registered!";
    } else {
        echo "Error registering the request: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>New request</title>
</head>
<body>

<h2>New request</h2>

<form action="new_request.php" method="post">
    <label for="civ_item">Select category:</label>
    <select name="civ_item" id="civ_item" required>
        <?php
        while ($row = mysqli_fetch_assoc($categories_result)) {
            echo "<optgroup label='" . htmlspecialchars($row['category_name']) . "'>";
            $items_query = "SELECT * FROM items WHERE category_id = " . $row['id'];
            $items_result = mysqli_query($conn, $items_query);

            while ($item_row = mysqli_fetch_assoc($items_result)) {
                echo "<option value='" . htmlspecialchars($item_row['id']) . "'>" . htmlspecialchars($item_row['item_name']) . "</option>";
            }

            echo "</optgroup>";
        }
        ?>
    </select><br><br>

    <label for="quantity">Number of people:</label>
    <input type="number" name="civ_quantity" id="civ_quantity" min="1" required><br><br>

    <button type="submit">Submit request</button>
</form>

</body>
</html>

<?php
mysqli_close($conn);
?>