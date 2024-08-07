<?php
include("../../model/config.php");
include("./fetch_item_by_id.php"); //??

$query = "SELECT veh_id, username FROM tasks WHERE item_id=$1";
$result = pg_query_params($dbconn, $query, array($item_id));

if ($result) {
    $item_data = pg_fetch_all($result);
    echo json_encode($item_data);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Database query failed']);
}

//TODO. Join tasks with vehicle tables to get its name through req_id


include("../../model/dbclose.php");
