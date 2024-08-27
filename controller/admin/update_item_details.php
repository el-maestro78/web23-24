<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item_name = validate_input($_POST['item']);
$item_details = validate_input($_POST['details']);

$sql = <<< EOF
        SELECT iname
        FROM items
        WHERE item_id = $1;
EOF;
$check_if_already_exists = pg_query_params($dbconn, $sql, array($item_name));
if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
    echo json_encode(['exists' => false, 'updated'=> false, 'error' => pg_last_error($dbconn)]);
} else {
    $sql = <<< EOF
            UPDATE items 
            SET details = $2
            WHERE item_id = $1;
EOF;
    $result = pg_query_params($dbconn, $sql, array($item_name, $item_details));
    if(!$result) {
        echo json_encode(['exists' => true, 'updated'=> false, 'error' => pg_last_error($dbconn)]);
    }else{
        echo json_encode(['exists' => true, 'updated'=> true]);
    }
}
