<?php

include '../../model/config.php';

// Get from  Quantity from Storage
$item_query = "SELECT * FROM items";
$item_result = pg_query($dbconn, $item_query);
if (!$item_result) die( http_response_code(500));
$items_array = pg_fetch_all($item_result);
// Get quantity from vehicles
$veh_load_query = "SELECT item_id, load FROM vehicle_load";
$veh_load_result = pg_query($dbconn, $veh_load_query);
if (!$veh_load_result) die( http_response_code(500));
$veh_load_array = pg_fetch_all($veh_load_result);

$item_assoc = [];
foreach ($items_array as $item) {
    $item_assoc[$items_array['item_id']] = $item['quantity'];
}
foreach ($veh_load_array  as $item) {
    if (!isset($item['load'])) {
        $item['load'] = 0;
    }
    if (isset($item_assoc[$item['item_id']])) {
        $item['load'] += $item_assoc[$item['item_id']];
    }
}
echo json_encode($item_assoc);

include("../../model/dbclose.php");