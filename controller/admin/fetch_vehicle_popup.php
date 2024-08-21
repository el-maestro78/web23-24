<?php
include("../../model/config.php");

$veh_id = isset($_GET['veh_id']) ? $_GET['veh_id'] : '';
//$veh_id = 0;

if($veh_id !== null && $veh_id != "") {
    $task_query = "
    SELECT count(veh_id) AS task_count
    FROM tasks
    WHERE veh_id=$1 AND completed = FALSE
    ";
    $load_query = "
    SELECT vehicle_load.load, items.iname
    FROM vehicle_load JOIN items ON items.item_id = vehicle_load.item_id
    WHERE veh_id=$1
    ";
    $task_result = pg_query_params($dbconn, $task_query, array($veh_id));
    $load_result = pg_query_params($dbconn, $load_query, array($veh_id));
    
    if ($task_result || $load_result) {
        $task_data = pg_fetch_assoc($task_result);
        $load_data = pg_fetch_all($load_result);
        $veh_data = array(
            'task_count' => $task_data['task_count'],
            'load_data' => $load_data
        );
        echo json_encode($veh_data);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing veh_id']);
}
