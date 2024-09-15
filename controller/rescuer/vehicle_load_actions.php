<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";
//*
$action = $_POST['action'];
$veh_id = $_POST['veh_id'];
$item_id = $_POST['item_id'];
$load = $_POST['load'] ?? 0;
$load = (int)$load;
$new_item_quantity = $_POST['new_item_quantity'] ?? 0;
$new_item_quantity =(int)$new_item_quantity;
 //*/
/*
$action = 'update';
$veh_id = 1;
$item_id = 1;
$load = 3;
$new_item_quantity = 0;
*/
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
        echo json_encode(['error' => 'Invalid action']);
}

function updateVehicleLoad($dbconn, $veh_id, $item_id, $new_load, $new_item_quantity): void
{
    $query = 'UPDATE vehicle_load SET load = $1 WHERE veh_id = $2 AND item_id = $3';
    $result = pg_query_params($dbconn, $query, array($new_load, $veh_id, $item_id));
    if (!$result) {
        echo json_encode(['error' => pg_last_error($dbconn)]);
        exit;
    }

    $items_query = 'UPDATE items SET quantity = $1 WHERE item_id = $2';
    $items_result = pg_query_params($dbconn, $items_query, array($new_item_quantity, $item_id));
    if (!$items_result) {
        echo json_encode(['error' => pg_last_error($dbconn)]);
        exit;
    }

    echo json_encode(['action_status' => true]);
}

function addToVehicleLoad($dbconn, $veh_id, $item_id, $load) {
    $query = 'INSERT INTO vehicle_load (veh_id, item_id, load) VALUES ($1, $2, $3)';
    $result = pg_query_params($dbconn, $query, array($veh_id, $item_id, $load));
    if (!$result) {
        echo json_encode(['error' => pg_last_error($dbconn)]);
        exit;
    }

    $query = 'UPDATE items SET quantity = $3 WHERE item_id = $2';
    $result = pg_query_params($dbconn, $query, array($load, $item_id, $new_item_quantity));
    if (!$result) {
        echo json_encode(['error' => pg_last_error($dbconn)]);
        exit;
    }
    echo json_encode(['action_status' => true]);
}

function deleteVehicleLoad($dbconn, $veh_id, $item_id, $load) {
    $query = 'DELETE FROM vehicle_load WHERE veh_id = $1 AND item_id = $2';
    $result = pg_query_params($dbconn, $query, array($veh_id, $item_id));
    if (!$result) {
        echo json_encode(['error' => pg_last_error($dbconn)]);
        exit;
    }

    $query = 'UPDATE items SET quantity = quantity + $1 WHERE item_id = $2';
    $result = pg_query_params($dbconn, $query, array($load, $item_id));
    if (!$result) {
        echo json_encode(['error' => pg_last_error($dbconn)]);
        exit;
    }

    echo json_encode(['action_status' => true]);
}