<?php
include "../../model/config.php";
include "../../ini.php";

$user_id = $_SESSION['user_id'];
$query = "SELECT veh_id FROM vehicle_rescuers WHERE user_id = $1";
$result = pg_query_params($dbconn, $query, array($user_id));

if($result){
    $row = pg_fetch_array($result);
}else{
    echo json_encode(error_log(pg_last_error($dbconn)));
    exit;
}
$veh_id = $row['veh_id'];
$veh_data_query = "SELECT lat, long FROM vehicles WHERE veh_id = $1";
$veh_data_result = pg_query_params($dbconn, $veh_data_query, array($veh_id));

if($veh_data_result){
    $final = pg_fetch_array($veh_data_result);
    $lat = $final['lat'];
    $long = $final['long'];
    $data = [
        'lat' => $lat,
        'long' => $long,
        'veh_id' => $veh_id,
        'username' => $_SESSION['username']
    ];
    echo json_encode($data);
}else{
    echo json_encode(error_log(pg_last_error($dbconn)));
    exit;
}