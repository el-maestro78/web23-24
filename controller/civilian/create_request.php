<?php
include '../../model/config.php';
include '../../ini.php';
include '../../auxiliary.php';

$people = validate_input($_POST['people']);
$category = validate_input($_POST['category']);
$items = json_decode($_POST['items'], true);
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    echo json_encode(['created' => false, 'error' => 'User logged out']);
    exit;
}

if (!is_array($items)) {
    echo json_encode(['created' => false, 'error' => 'Invalid items format', 'array' => $items]);
    exit;
}

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
$quantity = (int)$people;

pg_query($dbconn, "BEGIN");

$query = <<< EOF
        INSERT INTO requests(quantity, reg_date, 
                             assign_date, completed_date, user_id, item_id, long, lat)
        VALUES ($1, $2, $3, $4, $5, $6, $7, $8);
EOF;

$result = pg_prepare($dbconn, "req_insert_query", $query);
if (!$result) {
    echo json_encode(['created' => false, 'error' => pg_last_error($dbconn)]);
    pg_query($dbconn, "ROLLBACK");
    exit;
}

foreach ($items as $item_id) {
    $item_id = (int)$item_id;
    $final = pg_execute($dbconn, "req_insert_query", array($quantity, date('Y-m-d'), null, null, $user_id, $item_id, $longitude, $latitude));
    if (!$final) {
        pg_query($dbconn, "ROLLBACK");
        echo json_encode(['created' => false, 'error' => pg_last_error($dbconn)]);
        include '../../model/dbclose.php';
        exit;
    }
}

pg_query($dbconn, "COMMIT");
echo json_encode(['created' => true]);

include '../../model/dbclose.php';
