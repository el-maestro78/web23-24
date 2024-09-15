<?php
include("../../model/config.php");
include("../../auxiliary.php");
$task_id = $_GET['task_id'] ?? '';
$task_id = validate_input($task_id);

$tasks_query = <<< EOF
    UPDATE tasks
    SET  completed = TRUE
    WHERE tasks_id = $1;
EOF;

$result = pg_query_params($dbconn, $tasks_query, array($task_id));

if($result){
    echo json_encode(['finished_' => true]);
}else{
    http_response_code(400);
    echo json_encode(['error' => pg_last_error($dbconn)]);//'Can\'t set task as finished'
}
include '../../model/dbclose.php';
