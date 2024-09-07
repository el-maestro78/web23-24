<?php

include '../../model/config.php';
include '../../ini.php';
include '../../auxiliary.php';

$item = validate_input($_POST['item']);
$quantity = validate_input($_POST['quantity']);
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    echo json_encode(['created' => false, 'error' => 'User logged out']);
    exit;
}

// User Lat & Long
$user_data = "SELECT dbUser.lat, dbUser.long FROM dbUser WHERE dbUser.user_id = $1";
$get_user_result = pg_query_params($dbconn, $user_data, array($user_id));
if (!$get_user_result) {
    echo json_encode(['created' => false, 'error' => pg_last_error($dbconn)]);
    exit;
}
$lat_long = pg_fetch_array($get_user_result);
if (!$lat_long) {
    echo json_encode(['created' => false, 'error' => 'Invalid lat/long format']);
}
$latitude = $lat_long['lat'];
$longitude = $lat_long['long'];

// Item id
$item_data = "SELECT items.item_id from items WHERE items.iname = $1";
$get_item_result = pg_query_params($dbconn, $item_data, array($item));
if (!$get_item_result) {
    echo json_encode(['created' => false, 'error' => pg_last_error($dbconn)]);
    exit;
}
$item_row = pg_fetch_array($get_item_result);
if (!$item_row) {
    echo json_encode(['created' => false, 'error' => 'Item not found']);
    exit;
}
$item_id = $item_row['item_id'];

$query = <<< EOF
        INSERT INTO offers(quantity, reg_date, 
                             assign_date, completed_date, user_id, item_id, long, lat)
        VALUES ($1, $2, $3, $4, $5, $6, $7, $8);
EOF;

$result = pg_prepare($dbconn, "offer_insert_query", $query);
if (!$result) {
    echo json_encode(['created' => false, 'error' => pg_last_error($dbconn)]);
    pg_query($dbconn, "ROLLBACK");
    exit;
}

$final = pg_execute($dbconn, "offer_insert_query", array($quantity, date('Y-m-d'), null, null,
    $user_id, $item_id, $longitude, $latitude));
if (!$final) {
    echo json_encode(['created' => false, 'error' => pg_last_error($dbconn)]);
    include '../../model/dbclose.php';
    exit;
}

echo json_encode(['created' => true]);

include '../../model/dbclose.php';
