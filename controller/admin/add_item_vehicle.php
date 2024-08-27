<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item = validate_input($_POST['item']);
$item_quant = validate_input($_POST['quantity']);
$vehicle = validate_input($_POST['vehicle']);

$sql = <<< EOF
        SELECT quantity
        FROM items
        WHERE item_id=$1;
EOF;
$get_quantity = pg_query_params($dbconn, $sql,array($item));
if(!$get_quantity){
    echo json_encode(['error' => pg_last_error($dbconn)]);
}
$result = pg_fetch_assoc($get_quantity);
$store_quantity = (int)$result['quantity'];
if ($store_quantity < $item_quant) {
    echo json_encode(['exists' => true, 'updated' => false, 'lacking' => true]);
    exit;
}
$new_quantity = $store_quantity - $item_quant;

$sql = <<< EOF
        SELECT veh_id, load
        FROM vehicle_load
        WHERE item_id=$1 AND vehicle_id=$2;
EOF;

$check_if_already_exists = pg_query_params($dbconn, $sql,array($item, $vehicle));
if($check_if_already_exists && pg_num_rows($check_if_already_exists) > 0){
    if(!update_store_quantity($new_quantity, $item, $dbconn)){
        echo json_encode(['error' => pg_last_error($dbconn)]);
    }
    $result = pg_fetch_assoc($check_if_already_exists);
    $quantity = (int)$result['load'];
    $item_quant += $quantity;
    $sql = <<< EOF
        UPDATE vehicle_load
        SET load = $1
        WHERE veh_id = $2 AND item_id=$3;
    EOF;
    $update_quant_result = pg_query_params($dbconn, $sql,array($item_quant, $vehicle, $item));
    if($update_quant_result){
        echo json_encode(['exists' => true, 'updated' => true, 'lacking' => false]);
    }else{
        echo json_encode(['exists' => true, 'updated' => false,'lacking' => false, 'error' => pg_last_error($dbconn)]);
    }
}else{ // Αν δεν υπαρχει ηδη, απλα προσθετουμε
    if(!update_store_quantity($new_quantity, $item, $dbconn)){
        echo json_encode(['error' => pg_last_error($dbconn)]);
    }
    $sql = <<< EOF
        INSERT INTO vehicle_load(veh_id, item_id, load) 
        VALUES ($1,$2,$3);
       EOF;
    $result = pg_query_params($dbconn, $sql, array($vehicle, $item, $item_quant));
    if (!$result) {
        echo json_encode(['exists' => false, 'updated'=> false, 'error' => pg_last_error($dbconn)]);
    }else{
        echo json_encode(['exists' => false, 'updated'=> true]);
    }
}
// remove from store
function update_store_quantity($new_quantity, $item, $dbconn): bool
{
    $sql = <<< EOF
        UPDATE items
        SET quantity = $1
        WHERE item_id=$2;
    EOF;
    $result = pg_query_params($dbconn, $sql, array($new_quantity , $item));
    if (!$result) {
        return false;
    }else{
        return true;
    }
}



include "../../model/dbclose.php";