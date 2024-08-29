<?php

include '../../model/config.php';
include '../../ini.php';
include '../../auxiliary.php';

/*
$descr = "offer details";
$user_id = 1;
$items = 1;
$quantity = 10;
$long = 22.945; // Example longitude
$lat = 39.656; // Example latitude
*/

$descr = validate_input($_POST['details']);
$user_id = validate_input($_POST['civilian']);
$items = json_decode($_POST['item'], true);
$quantity = validate_input($_POST['quantity']);
$long = validate_input($_POST['long']);
$lat = validate_input($_POST['lat']);
$reg_date = date('Y-m-d');

if (!is_array($items)) {
    echo json_encode(['created' => false, 'error' => 'Invalid items format', 'array' => $items]);
    exit;
}

pg_query($dbconn, "BEGIN");

$query = <<<EOF
        INSERT INTO offers(descr, user_id, item_id, quantity, reg_date, long, lat) 
        VALUES ($1, $2, $3, $4, $5, $6, $7);
EOF;

$result = pg_prepare($dbconn, "offer_insert_query", $query);
if (!$result) {
    echo json_encode(['created' => false, 'error' => pg_last_error($dbconn)]);
    pg_query($dbconn, "ROLLBACK");
    exit;
}

$success = true;
foreach ($items as $item_id) {
    $final = pg_execute($dbconn, "offer_insert_query", array($descr, $user_id, $item_id, $quantity, $reg_date, $long, $lat));
    if (!$final) {
        $success = false;
        echo json_encode(['error' => 'Error inserting data']);
        break;
    }
}

if ($success) {
    pg_query($dbconn, "COMMIT");
    echo json_encode(['created' => true]);
} else {
    pg_query($dbconn, "ROLLBACK");
    echo json_encode(['created' => false, 'error' => 'Error inserting data']);
}

include '../../model/dbclose.php';
?>