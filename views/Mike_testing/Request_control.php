<?php
session_start();
require '../../model/config.php';

if (!isset($_SESSION['civ_id'])) {
    header("Location: login.php");
    exit;
}

$civilian_id = $_SESSION['civ_id'];

$current_requests_query = "SELECT * FROM requests WHERE civilian_id = $1 AND status = 'pending'";
$past_requests_query = "SELECT * FROM requests WHERE civilian_id = $1 AND status != 'pending'";

$current_requests_result = pg_query_params($dbconn, $current_requests_query, array($civilian_id));
$past_requests_result = pg_query_params($dbconn, $past_requests_query, array($civilian_id));


$categories_query = "SELECT * FROM item_category";
$categories_result = pg_query($dbconn, $categories_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $civilian_item_id = $_POST['civ_item'];
    $civilian_quantity = $_POST['civ_quantity'];

    if (!is_numeric($civilian_quantity) || $civilian_quantity <= 0) {
        echo "Invalid quantity.";
        exit;
    }

    $item_check_query = "SELECT id FROM items WHERE id = $1";
    $item_check_result = pg_query_params($dbconn, $item_check_query, array($civilian_item_id));

    if (pg_num_rows($item_check_result) === 0) {
        echo "Invalid item.";
        exit;
    }


    $insert_query = "INSERT INTO requests (civilian_id, civilian_item_id, civilian_quantity, request_date, status) VALUES ($1, $2, $3, NOW(), 'pending')";
    $insert_result = pg_query_params($dbconn, $insert_query, array($civilian_id, $civilian_item_id, $civilian_quantity));

    if ($insert_result) {
        echo "Your request has successfully registered!";
    } else {
        echo "Error registering the request: " . pg_last_error($dbconn);
    }
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
        while ($row = pg_fetch_assoc($categories_result)) {
            echo "<optgroup label='" . htmlspecialchars($row['category_name']) . "'>";
            $items_query = "SELECT * FROM items WHERE category_id = $1";
            $items_result = pg_query_params($dbconn, $items_query, array($row['id']));

            while ($item_row = pg_fetch_assoc($items_result)) {
                echo "<option value='" . htmlspecialchars($item_row['id']) . "'>" . htmlspecialchars($item_row['item_name']) . "</option>";
            }

            echo "</optgroup>";
        }
        ?>
    </select><br><br>

    <label for="civ_quantity">Number of people:</label>
    <input type="number" name="civ_quantity" id="civ_quantity" min="1" required><br><br>

    <button type="submit">Submit request</button>
</form>

<hr>

<h2>Your Current Requests</h2>
<ul>
    <?php
    if (pg_num_rows($current_requests_result) > 0) {
        while ($request = pg_fetch_assoc($current_requests_result)) {
            echo "<li>Request for " . htmlspecialchars($request['civilian_quantity']) . " of item ID: " . htmlspecialchars($request['civilian_item_id']) . " - Status: " . htmlspecialchars($request['status']) . "</li>";
        }
    } else {
        echo "<li>No current requests.</li>";
    }
    ?>
</ul>

<hr>

<h2>Your Past Requests</h2>
<ul>
    <?php
    if (pg_num_rows($past_requests_result) > 0) {
        while ($request = pg_fetch_assoc($past_requests_result)) {
            echo "<li>Request for " . htmlspecialchars($request['civilian_quantity']) . " of item ID: " . htmlspecialchars($request['civilian_item_id']) . " - Status: " . htmlspecialchars($request['status']) . "</li>";
        }
    } else {
        echo "<li>No past requests.</li>";
    }
    ?>
</ul>

</body>
</html>

<?php
pg_close($dbconn);
?>