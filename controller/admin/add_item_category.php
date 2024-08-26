<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item_categ = validate_input($_POST['category']);
$item_details = validate_input($_POST['details'] ?? '');

$sql = <<< EOF
        SELECT category_name
        FROM item_category
        WHERE category_name = $1;
       EOF;
$check_if_already_exists = pg_query_params($dbconn, $sql, array($item_categ));
if ($check_if_already_exists && pg_num_rows($check_if_already_exists) > 0) {
    echo json_encode(['exists' => true, 'created'=> false, 'error' => pg_last_error($dbconn)]);
} else {
    $sql = <<< EOF
            INSERT INTO item_category(category_name, details) 
            VALUES ($1, $2);
EOF;
    $result = pg_query_params($dbconn, $sql, array($item_categ, $item_details));
    if (!$result) {
        echo json_encode(['exists' => false, 'created'=> false, 'error' => pg_last_error($dbconn)]);
    }else{
        echo json_encode(['exists' => false, 'created'=> true]);
    }
}
include "../../model/dbclose.php";