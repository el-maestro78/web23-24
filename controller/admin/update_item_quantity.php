<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item_name = validate_input($_POST['item']);
$item_quant = validate_input($_POST['quantity']);

$sql = <<< EOF
        SELECT iname
        FROM items
        WHERE item_id = $1;
       EOF;
$check_if_already_exists = pg_query_params($dbconn, $sql, array($item_name));
if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
    echo json_encode(['exists' => false, 'created'=> false, 'error' => pg_last_error($dbconn)]);
} else {
    $sql = <<< EOF
         UPDATE items 
         SET quantity = $1
         WHERE item_id = $2;
       EOF;
    $result = pg_query_params($dbconn, $sql, array($item_quant, $item_name));
    if (!$result) {
        echo json_encode(['exists' => true, 'created'=> false, 'error' => pg_last_error($dbconn)]);
    }else{
        echo json_encode(['exists' => true, 'created'=> true]);
    }
}
