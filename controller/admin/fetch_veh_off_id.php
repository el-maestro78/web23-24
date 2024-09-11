<?php
include("../../model/config.php");
$off_id = $_GET['off_id'] ?? '';
//$off_id = 0;
if($off_id !== null && $off_id != ""){
    $query = "
    SELECT dbUser.username 
    FROM tasks 
    JOIN vehicles ON tasks.veh_id = vehicles.veh_id 
    JOIN vehicle_rescuers ON vehicles.veh_id = vehicle_rescuers.veh_id     
    JOIN dbUser ON vehicle_rescuers.user_id = dbUser.user_id 
    WHERE tasks.off_id = $1;
    ";
    $result = pg_query_params($dbconn, $query, array($off_id));
    if ($result) {
        $task_data = pg_fetch_all($result);
        echo json_encode($task_data);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing off_id']);
}
