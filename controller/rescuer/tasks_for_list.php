<?php
include("../../model/config.php");

$veh_id = $_GET['veh_id'] ?? '';
//$veh_id = 1;

if ($veh_id !== null && $veh_id != "") {
    $req_query = "
    SELECT
        tasks.tasks_id,
        dbUser.first_name,
        dbUser.surname,
        dbUser.phone,
        requests.quantity, 
        requests.reg_date, 
        items.iname
    FROM tasks JOIN requests ON requests.req_id = tasks.req_id
    JOIN dbUser ON dbUser.user_id = requests.user_id
    JOIN items ON requests.item_id = items.item_id
    WHERE tasks.req_id IS NOT NULL AND tasks.veh_id=$1 AND requests.pending = FALSE AND requests.completed = FALSE
    ";
    $off_query = "
    SELECT
        tasks.tasks_id,
        dbUser.first_name,
        dbUser.surname,
        dbUser.phone,
        offers.quantity,
        offers.reg_date, 
        items.iname
    FROM tasks JOIN offers ON offers.off_id = tasks.off_id
    JOIN dbUser ON dbUser.user_id = offers.user_id
    JOIN items ON offers.item_id = items.item_id
    WHERE tasks.off_id IS NOT NULL AND tasks.veh_id=$1 AND offers.pending = FALSE AND offers.completed = FALSE
    ";

    $off_result = pg_query_params($dbconn, $off_query, array($veh_id));
    $req_result = pg_query_params($dbconn, $req_query, array($veh_id));
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
