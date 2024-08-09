<?php
include("../../model/config.php");

$base_id = isset($_GET['base_id']) ? $_GET['base_id'] : '';
$lat = isset($_GET['lat']) ? $_GET['lat'] : '';
$long = isset($_GET['long']) ? $_GET['long'] : '';
/*
$base_id = 0;
$lat = 38.0;
$long = 21.2;
//*/
$base_check = ($base_id !== null && $base_id != "");
$lat_check = ($lat !== null && $lat != "");
$long_check = ($long !== null && $long != "");

if ($base_check && $lat_check && $long_check) {
    $update_query = "
        UPDATE base 
        SET lat = $1, long = $2 
        WHERE base_id = $3
    ";
    $update_result = pg_query_params($dbconn, $update_query, array($lat, $long, $base_id));
    if (!$update_result) {
        die("Error updating base's pos: " . pg_last_error());
    }
}else{
    http_response_code(400);
    echo json_encode(['error' => 'Missing base_id']);
}
include("../../model/dbclose.php");
?>