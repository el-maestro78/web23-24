<?php
include("../../model/config.php");

$vehicle_id = $_POST['vehicle_id'] ?? '';
$lat = $_POST['lat'] ?? '';
$long = $_POST['long'] ?? '';

/*
$vehicle_id = 1;
$lat = 38.0;
$long = 21.2;
//*/


$veh_check = ($vehicle_id !== null && $vehicle_id !== "");
$lat_check = ($lat !== null && $lat !== "");
$long_check = ($long !== null && $long !== "");

if ($veh_check  && $lat_check && $long_check) {
    $update_query = "
        UPDATE vehicles 
        SET lat = $1, long = $2 
        WHERE veh_id = $3
    ";
    $update_result = pg_query_params($dbconn, $update_query, array($lat, $long, $vehicle_id));
    if (!$update_result) {
        die("Error updating base's pos: " . pg_last_error());
    }
}else{
    http_response_code(400);
    echo json_encode(['error' => 'Missing vehicle_id']);
    exit;
}
