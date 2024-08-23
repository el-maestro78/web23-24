<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item_name = validate_input($_POST['item_name']);
$item_quant = validate_input($_POST['item_quant']);
$item_categ = validate_input($_POST['item_categ']);
$item_details = validate_input($_POST['item_details'] ?? '');


$sql = <<< EOF
        SELECT iname
        FROM item
        WHERE iname=$item_name;
       EOF;
$check_if_already_exists = pg_query($dbconn, $sql);
if($check_if_already_exists && pg_num_rows($check_if_already_exists) > 0){
    echo "Item $item_name already exists";
}
else{
    if ($item_quant <= 0) {
        $item_quant == 0;
    }
    $sql = <<< EOF
        INSERT INTO items(iname, quantity, category, details) 
        VALUES ($item_name, $item_quant, $item_categ, $item_details)";
       EOF;
    $result = pg_query($dbconn, $sql);
    if (!$result) {
        $error_message = "Problem with item $item_name";
        echo $error_message;
    }
}
