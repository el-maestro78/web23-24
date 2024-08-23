<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item_name = validate_input($_POST['item_name']);
$item_details = validate_input($_POST['item_details']);

$sql = <<< EOF
        SELECT iname
        FROM items
        WHERE iname = $item_name;
       EOF;
$check_if_already_exists = pg_query($dbconn, $sql);
if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
    echo "Item $item_name doesn't exist";
} else {
    $sql = <<< EOF
            "UPDATE items 
           SET details = $item_details
           WHERE iname = $item_name";
       EOF;
    $result = pg_query($dbconn, $sql);
    if (!$result) {
        $error_message = "Problem with updating details for item $item_categ";
        echo $error_message;
    }
}
