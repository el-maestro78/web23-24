<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";


$item_categ = validate_input($_POST['item_categ']);
$categ_details = validate_input($_POST['categ_details']);

$sql = <<< EOF
        SELECT category_name
        FROM item_category
        WHERE category_name = $item_categ;
       EOF;
$check_if_already_exists = pg_query($dbconn, $sql);
if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
    echo "Item category $item_categ doesn't exist";
} else {
    $sql = <<< EOF
            "UPDATE item_category 
           SET details = $categ_details
           WHERE category_name = $item_categ";
       EOF;
    $result = pg_query($dbconn, $sql);
    if (!$result) {
        $error_message = "Problem with updating details for category $item_categ";
        echo $error_message;
    }
}
