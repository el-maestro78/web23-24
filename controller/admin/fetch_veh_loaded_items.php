<?php
include '../../model/config.php';

$veh_load='SELECT
               vehicles.veh_id as veh_id,
               vehicles.username as username,
               vehicle_load.load as load,
               items.item_id as item_id,
               items.iname as iname
            FROM vehicle_load JOIN vehicles ON vehicle_load.veh_id = vehicles.veh_id 
            JOIN items ON vehicle_load.item_id = items.item_id';

$veh_load_result = pg_query($dbconn, $veh_load);
if (!$veh_load_result) die( http_response_code(500));
$vehicle_load_array = pg_fetch_all($veh_load_result);

$vehicle_bases = array_unique(array_column($vehicle_load_array, 'veh_id'));


$vehicles= <<<EOF
            SELECT
            veh_id,
            username
            FROM vehicles;
EOF;
$vehicles_result = pg_query($dbconn, $vehicles);
if (!$vehicles_result) die( http_response_code(500));
$vehicles = pg_fetch_all($vehicles_result);


$loaded_vehicle_ids = array_column($vehicle_load_array, 'veh_id');
$complete_vehicle_load_array = $vehicle_load_array;
foreach ($vehicles as $vehicle) {
    if (!in_array($vehicle['veh_id'], $loaded_vehicle_ids)) {
        $complete_vehicle_load_array[] = [
            'veh_id' => $vehicle['veh_id'],
            'username' => $vehicle['username'],
            'load' => 0,
            'item_id' => null,
            'iname' => null
        ];
    }
}
$vehicle_load_array = $complete_vehicle_load_array;
include("../../model/dbclose.php");
