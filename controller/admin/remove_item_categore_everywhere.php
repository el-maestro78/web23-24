<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item_categ = validate_input($_POST["category"]);
$sql = "DELETE FROM item_category WHERE category_id = $1";
$result = pg_query_params($dbconn, $sql, array($item_categ));
if (!$result) {
    echo json_encode(['exists' => true, 'removed'=> false, 'error' => pg_last_error($dbconn)]);
}else{
    echo json_encode(['exists' => true, 'removed'=> true]);
}


//include "./remove_item_category.php";