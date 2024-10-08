<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item_name = validate_input($_POST['item']);

$sql = <<< EOF
        SELECT iname
        FROM items
        WHERE item_id = $1;
       EOF;
$check_if_already_exists = pg_query_params($dbconn, $sql, array($item_name));
if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
    echo json_encode(['exists' => false, 'removed'=> false, 'error' => pg_last_error($dbconn)]);
} else {
    $sql = "DELETE FROM items WHERE item_id = $1";
    $result = pg_query_params($dbconn, $sql, array($item_name));
    if (!$result) {
        echo json_encode(['exists' => true, 'removed'=> false, 'error' => pg_last_error($dbconn)]);
    }else{
        echo json_encode(['exists' => true, 'removed'=> true]);
    }
}
