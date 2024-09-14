<?php
include("../../model/config.php");
include("../../ini.php");

$off_id = $_GET['off_id'] ?? '';
//$off_id = 15;
$user_id = $_SESSION['user_id'];
//$user_id= 5;
if(!$user_id){
    die('User logged out error!');
}

// Check if tasks are more than 4
$tasks_query = <<< EOF
        SELECT count(tasks.user_id) as task_count
        FROM tasks
        WHERE tasks.user_id = $1 AND tasks.completed = FALSE;
    EOF;
$result = pg_query_params($dbconn, $tasks_query , array($user_id));
if(!$result){
    http_response_code(400);
    echo json_encode(['error' => 'Missing user_id']);
    exit;
}
$task_data = pg_fetch_all($result);
$current_tasks = (int)$task_data[0]['task_count'];
if($current_tasks > 4){
    echo json_encode(['error' => 'You have more than 4 active tasks']);
    exit;
}

// Get his vehicle
$veh_id_query = <<< EOF
        SELECT vehicle_rescuers.veh_id
        FROM vehicle_rescuers
        WHERE vehicle_rescuers.user_id = $1;
    EOF;
$veh_id_result = pg_query_params($dbconn, $veh_id_query , array($user_id));
if(!$veh_id_result){
    http_response_code(400);
    echo json_encode(['error' => 'Missing veh_id']);
}
$vehicle_data = pg_fetch_all($veh_id_result);
$veh_id = $vehicle_data[0]['veh_id'];

if($off_id !== null && $off_id != ""){
    $update_offers_query = <<< EOF
        UPDATE offers 
        SET pending = FALSE, assign_date = $1, user_id = $2
        WHERE offers.off_id = $3;
    EOF;
    $update_offers_result = pg_query_params($dbconn, $update_offers_query, array(date('Y-m-d'), $user_id, $off_id));
    if ($update_offers_result) {//$veh_id
        /*
        $update_tasks_query = <<< EOF
            UPDATE tasks
            SET user_id = $1, veh_id = $2
            WHERE tasks.off_id = $3;
        EOF;
        */
        $update_tasks_query = <<< EOF
            INSERT INTO tasks(user_id, veh_id, off_id) VALUES
                            ($1, $2, $3);
        EOF;
        $update_tasks_result = pg_query_params($dbconn, $update_tasks_query, array($user_id, $veh_id, $off_id));
        if ($update_tasks_result) {
            echo json_encode(['created' => true]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Cannot add new task']);
            //echo json_encode(['error' => pg_last_error($dbconn)]);
            exit;
        }
    } else {
        http_response_code(500);
        //echo json_encode(['error' => pg_last_error($dbconn)]);
        echo json_encode(['error' => 'Can not add new offer']);
        exit;
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing off_id']);
    exit;
}