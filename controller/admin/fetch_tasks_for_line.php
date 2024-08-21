<?php
include("../../model/config.php");

$veh_id = isset($_GET['veh_id']) ? $_GET['veh_id'] : '';
//$veh_id = 0;

if ($veh_id !== null && $veh_id != "") {
    $req_query = "
    SELECT requests.lat, requests.long
    FROM tasks JOIN requests ON requests.req_id = tasks.req_id
    WHERE veh_id=$1
    ";
    $off_query = "
    SELECT offers.lat, offers.long
    FROM tasks JOIN offers ON offers.off_id = tasks.off_id
    WHERE veh_id=$1
    ";
    $req_result = pg_query_params($dbconn, $req_query, array($veh_id));
    $off_result = pg_query_params($dbconn, $off_query, array($veh_id));
    if ($req_result && $off_result) {
        $off_data = pg_fetch_all($off_result);
        $req_data = pg_fetch_all($req_result);
        $task_data = array(
            'offers' => $off_data,
            'requests' => $req_data
        );
        echo json_encode($task_data);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing veh_id']);
}
