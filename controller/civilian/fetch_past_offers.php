<?php
include '../../model/config.php';
include '../../ini.php';
include '../../auxiliary.php';
$user_id = $_SESSION['user_id'] ?? die('You are not logged in');

$query = <<< EOF
    SELECT
        offers.off_id,
        items.iname as item_name,
        offers.pending,
        offers.completed,
        offers.quantity,
        offers.reg_date,
        offers.assign_date,
        offers.completed_date,
        offers.user_id,
        offers.item_id
    FROM offers JOIN items ON offers.item_id = items.item_id
    JOIN dbUser ON offers.user_id = dbUser.user_id
    WHERE offers.user_id = $1
    ;
EOF;
$result = pg_query_params($dbconn, $query, array($user_id));

if ($result) {
    $offers = pg_fetch_all($result);
    echo json_encode($offers);
}else{
    die(pg_last_error($dbconn));
}

include '../../model/dbclose.php';
