<?php
include "../../model/config.php";
include "../../ini.php";

$user_id = $_SESSION['user_id'];
$query = "SELECT veh_id FROM vehicle_rescuers WHERE user_id = $1";
$result = pg_query_params($dbconn, $query, array($user_id));

if($result){
    $row = pg_fetch_array($result);
    echo json_encode($row);
}else{
    json_encode(error_log(pg_last_error($dbconn)));
}