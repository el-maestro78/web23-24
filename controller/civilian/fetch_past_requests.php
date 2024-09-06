<?php
include '../../model/config.php';
include '../../ini.php';
include '../../auxiliary.php';
$user_id = $_SESSION['user_id'] ?? die('You are not logged in');

$query = <<< EOF
    SELECT
        items.iname as item_name,
        requests.pending,
        requests.completed,
        requests.quantity,
        requests.reg_date,
        requests.assign_date,
        requests.completed_date,
        requests.user_id,
        requests.item_id
    FROM requests JOIN items ON requests.item_id = items.item_id
    JOIN dbUser ON requests.user_id = dbUser.user_id
    WHERE requests.user_id = $1
    ;
EOF;
$result = pg_query_params($dbconn, $query, array($user_id));

if ($result) {
    $requests = pg_fetch_all($result);
    echo json_encode($requests);
}else{
    die(pg_last_error($dbconn));
}

include '../../model/dbclose.php';
