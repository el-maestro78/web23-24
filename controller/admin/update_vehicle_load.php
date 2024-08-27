<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item = validate_input($_POST['item']);
$item_quant = validate_input($_POST['quantity']);
$vehicle = validate_input($_POST['vehicle']);

//Checking if exists in vehicle
$sql = <<< EOF
        SELECT veh_id, load 
        FROM vehicle_load 
        WHERE item_id = $1 AND veh_id = $2;
EOF;
$check_if_already_exists = pg_query_params($dbconn, $sql, array($item, $vehicle));
if (!$check_if_already_exists || pg_num_rows($check_if_already_exists) <= 0) {
    echo json_encode(['exists' => false, 'error' => pg_last_error($dbconn)]);
    exit;
}
// Getting item quantity
$sql = "SELECT quantity FROM items WHERE item_id = $1;";
$get_quantity = pg_query_params($dbconn, $sql, array($item));
if (!$get_quantity) {
    echo json_encode(['error' => pg_last_error($dbconn)]);
    exit;
}
//store load
$result = pg_fetch_assoc($get_quantity);
$store_quantity = (int)$result['quantity'];
//vehicle load
$result = pg_fetch_assoc($check_if_already_exists);
$current_load = (int)$result['load'];


//IF it is negative we remove
if(((int)$item_quant) < 0){
    $new_quant = $store_quantity + abs((int)$item_quant);
    $new_load = $current_load - abs((int)$item_quant);
    if($new_load < 0){
        echo json_encode(['exists' => true, 'updated' => false, 'removed_all' => true, 'error' => pg_last_error($dbconn)]);
        exit;
    }
    update_vehicle($dbconn, $vehicle, $item, $new_quant, $new_load);
}else{
    if ($store_quantity < (int)$item_quant) {
        echo json_encode(['exists' => true, 'updated' => false, 'lacking' => true, 'error' => pg_last_error($dbconn)]);
        exit;
    }
    $new_load = $current_load + $store_quantity;
    $new_quant = $store_quantity - abs((int)$item_quant);
    update_vehicle($dbconn, $vehicle, $item, $new_quant, $new_load);
}

function update_vehicle($dbconn, $vehicle, $item, $new_quant, $new_load):void{
    //update the store
    if(!update_store_quantity($new_quant, $item, $dbconn)){
        echo json_encode(['exists' => true, 'updated' => false, 'lacking' => false, 'error' => pg_last_error($dbconn)]);
        exit;
    }
    $sql = <<< EOF
        UPDATE vehicle_load 
        SET load = $1 
        WHERE veh_id = $2 AND item_id = $3;
    EOF;
    $update_quant_result = pg_query_params($dbconn, $sql, array($new_load, $vehicle, $item));
    if(!$update_quant_result) {
        echo json_encode(['exists' => true, 'updated' => false, 'lacking' => false, 'error' => pg_last_error($dbconn)]);
        exit;
    }else{
        echo json_encode(['exists' => true, 'updated' => true, 'lacking' => false]);
        exit;
    }
}

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

