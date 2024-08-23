<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item_categ = validate_input($_POST["item_categ"]);
$sql = <<< EOF
        FROM item_category
        WHERE category_name = $item_categ;
       EOF;
$check_if_already_exists = pg_query($dbconn, $sql);
if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
    echo "Item category $item_categ doesn't exist";
} else {
    $sql = "DELETE FROM item_category WHERE category_name = $item_categ";
    $result = pg_query($dbconn, $sql);
    if (!$result) {
        $error_message = "Problem with deleting category $item_categ";
        echo $error_message;
    }
}

