<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$action = $_POST['action'];
$veh_id = $_POST['veh_id'];
$item_id = $_POST['item_id'];
$load = isset($_POST['load']) ? $_POST['load'] : 0;
$new_item_quantity = isset($_POST['new_item_quantity']) ? $_POST['new_item_quantity'] : 0;

switch ($action) {
    case 'update':
        updateVehicleLoad($dbconn, $veh_id, $item_id, $load, $new_item_quantity);
        break;
    case 'add':
        addToVehicleLoad($dbconn, $veh_id, $item_id, $load);
        break;
    case 'delete':
        deleteVehicleLoad($dbconn, $veh_id, $item_id, $load);
        break;
    default:
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}

function updateVehicleLoad($dbconn, $veh_id, $item_id, $new_load, $new_item_quantity){
    $query = 'UPDATE vehicle_load SET load = $1 WHERE veh_id = $2 AND item_id = $3';
    $result = pg_query_params($dbconn, $query, array($new_load, $veh_id, $item_id));
    if (!$result) die(http_response_code(500));

    $query = 'UPDATE items SET quantity = quantity $1 WHERE item_id = $2';
    $result = pg_query_params($dbconn, $query, array($new_item_quantity, $item_id));
    if (!$result) die(http_response_code(500));

    echo json_encode(['status' => 'success']);
}

function addToVehicleLoad($dbconn, $veh_id, $item_id, $load) {
    $query = 'INSERT INTO vehicle_load (veh_id, item_id, load) VALUES ($1, $2, $3)';
    $result = pg_query_params($dbconn, $query, array($veh_id, $item_id, $load));
    if (!$result) die(http_response_code(500));

    $query = 'UPDATE items SET quantity = quantity - $1 WHERE item_id = $2';
    $result = pg_query_params($dbconn, $query, array($load, $item_id));
    if (!$result) die(http_response_code(500));

    echo json_encode(['status' => 'success']);
}

function deleteVehicleLoad($dbconn, $veh_id, $item_id, $load) {
    $query = 'DELETE FROM vehicle_load WHERE veh_id = $1 AND item_id = $2';
    $result = pg_query_params($dbconn, $query, array($veh_id, $item_id));
    if (!$result) die(http_response_code(500));

    $query = 'UPDATE items SET quantity = quantity + $1 WHERE item_id = $2';
    $result = pg_query_params($dbconn, $query, array($load, $item_id));
    if (!$result) die(http_response_code(500));

    echo json_encode(['status' => 'success']);
}