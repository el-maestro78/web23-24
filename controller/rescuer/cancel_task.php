<?php
include("../../model/config.php");
include("../../auxiliary.php");

$task_id = $_GET['task_id'] ?? '';
$task_id = validate_input($task_id);

$action = $_GET['action'] ?? '';
$action = validate_input($action);
if($action === 'request'){
    $request_query = <<< EOF
        SELECT req_id
        FROM tasks
        WHERE tasks_id = $1;
    EOF;
    $request_result = pg_query_params($dbconn, $request_query, array($task_id));

    if(!$request_result){
        echo json_encode(['error' => pg_last_error($dbconn)]);
        exit;
    }
    $request_result = pg_fetch_row($request_result);
    $request_id = $request_result[0];

    $request_pending_query = <<< EOF
        UPDATE requests
        SET pending = TRUE
        WHERE req_id = $1;
    EOF;
    $request_pending_result = pg_query_params($dbconn, $request_pending_query, array($request_id));

    if(!$request_pending_result){
        echo json_encode(['error' => pg_last_error($dbconn)]);
        exit;
    }
}else if($action === 'offer'){
    $offer_query = <<< EOF
        SELECT off_id
        FROM tasks
        WHERE tasks_id = $1;
    EOF;
    $offer_result = pg_query_params($dbconn, $offer_query, array($task_id));

    if(!$offer_result){
        echo json_encode(['error' => pg_last_error($dbconn)]);
        exit;
    }
    $offer_result = pg_fetch_row($offer_result);
    $offer_id = $offer_result[0];

    $offer_pending_query = <<< EOF
        UPDATE offers
        SET pending = TRUE
        WHERE off_id = $1;
    EOF;
    $offer_pending_result = pg_query_params($dbconn, $offer_pending_query, array($offer_id));

    if(!$offer_pending_result){
        echo json_encode(['error' => pg_last_error($dbconn)]);
        exit;
    }
}else{
    echo json_encode(['error' => 'Wrong action']);
    exit;
}

$tasks_query = <<< EOF
    DELETE FROM tasks
    WHERE tasks_id = $1;
EOF;
$result = pg_query_params($dbconn, $tasks_query, array($task_id));

if($result){
    echo json_encode(['cancelled' => true]);
}else{
    http_response_code(400);
    echo json_encode(['error' => pg_last_error($dbconn)]);//'Can\'t set task as finished'
}
include '../../model/dbclose.php';
