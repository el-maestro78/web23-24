<?php

include '../../model/config.php';
include '../../ini.php';
include '../../auxiliary.php';
/*


$descr = "spam spam";
$base_id = 1;
$items = 1;


*/
$descr = validate_input($_POST['details']);
$base_id = validate_input($_POST['base']);
$items = json_decode($_POST['items'], true);
//$items = $items[0];
if (!is_array($items)) {
    echo json_encode(['created' => false, 'error' => 'Invalid items format','array' => $items]);
    exit;
}
pg_query($dbconn, "BEGIN");
$query = <<< EOF
        INSERT INTO news(descr, base_id, item_id) 
        VALUES ($1, $2, $3);
EOF;

$result = pg_prepare($dbconn, "news_insert_query", $query);
if (!$result) {
    echo json_encode(['created'=> false, 'error' => pg_last_error($dbconn)]);
    pg_query($dbconn, "ROLLBACK");
    exit;
}
$success = true;
foreach ($items as $item_id) {
    $final = pg_execute($dbconn, "news_insert_query", array($descr, $base_id, $item_id));
    if (!$final) {
        $success = false;
        echo json_encode(['error' => 'Error inserting data']);
        break;
    }
}
if ($success) {
    pg_query($dbconn, "COMMIT");
    echo json_encode(['created'=> true]);
} else {
    pg_query($dbconn, "ROLLBACK");
    echo json_encode(['created'=> false, 'error' => 'Error inserting data']);
}




/*
$result = pg_prepare($dbconn, "news_insert_query", $query);
if ($result) {
    foreach ($items as $item) {
        $final = pg_execute($dbconn, "news_insert_query",array($descr, $base_id, $item_id));
        if (!$final) {
            $success = false;
            error_log(pg_last_error($dbconn));
            break;
        }
    }
    if($success){
        echo json_encode(['created'=> false, 'error' => pg_last_error($dbconn)]);
        exit;
    }
} else {
    echo json_encode(['created'=> false,'error' => pg_last_error($dbconn)]);
    exit;
}*/
include '../../model/dbclose.php';
