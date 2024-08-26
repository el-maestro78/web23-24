<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item = validate_input($_POST['item']);
$vehicle = validate_input($_POST['vehicle']);
$sql = <<< EOF
            SELECT veh_id
            FROM vehicle_load 
            WHERE item_id = $1 AND veh_id = $2;
EOF;
$check_if_already_exists = pg_query_params($dbconn, $sql, array($item, $vehicle));
if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
    echo json_encode(['exists' => false, 'removed'=> false, 'error' => pg_last_error($dbconn)]);
} else {
    $sql = "DELETE FROM vehicle_load WHERE item_id = $1 AND veh_id = $2";
    $result = pg_query_params($dbconn, $sql, array($item, $vehicle));
    if (!$result) {
        echo json_encode(['exists' => true, 'removed'=> false, 'error' => pg_last_error($dbconn)]);
    }else{
        echo json_encode(['exists' => true, 'removed'=> true]);
    }
}

