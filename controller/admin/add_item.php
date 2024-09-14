<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item_name = validate_input($_POST['item']);
$item_quant = validate_input($_POST['quantity']);
$item_categ = validate_input($_POST['category']);
$item_details = validate_input($_POST['details'] ?? '');


$sql = <<< EOF
        SELECT items.iname
        FROM items
        WHERE items.iname = $1;
EOF;
$check_if_already_exists = pg_query_params($dbconn, $sql, array($item_name));
if($check_if_already_exists && pg_num_rows($check_if_already_exists) >= 1){
    echo json_encode(['exists' => true, 'created'=> false, 'error' => pg_last_error($dbconn)]);
    exit;
}
else{
    if ((int)$item_quant <= 0) {
        $item_quant = 0;
    }
    $sql = <<< EOF
        INSERT INTO items(iname, quantity, category, details) 
        VALUES ($1,$2,$3,$4);
       EOF;
    $result = pg_query_params($dbconn, $sql, array($item_name, $item_quant, $item_categ, $item_details));
    if (!$result) {
        echo json_encode(['exists' => false, 'created'=> false, 'error' => pg_last_error($dbconn)]);
    }else{
        echo json_encode(['exists' => false, 'created'=> true]);
    }
}

include "../../model/dbclose.php";