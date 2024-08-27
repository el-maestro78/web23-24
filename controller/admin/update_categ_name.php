<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$category = validate_input($_POST['category']);
$name = validate_input($_POST['name']);

$sql = <<< EOF
        SELECT category_name
        FROM item_category
        WHERE category_id = $1;
EOF;

$check_if_already_exists = pg_query_params($dbconn, $sql, array($category));
if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
    echo json_encode(['exists' => false, 'updated'=> false, 'error' => pg_last_error($dbconn)]);
} else {
    $sql = <<< EOF
            UPDATE item_category 
            SET category_name = $2
            WHERE category_id = $1;
EOF;
    $result = pg_query_params($dbconn, $sql, array($category, $name));
    if(!$result) {
        echo json_encode(['exists' => true, 'updated'=> false, 'error' => pg_last_error($dbconn)]);
    }else{
        echo json_encode(['exists' => true, 'updated'=> true]);
    }
}
