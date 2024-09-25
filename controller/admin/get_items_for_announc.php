<?php
include '../../model/config.php';
include '../../ini.php';



$bases_query = "SELECT base_id FROM base";
$bases_result = pg_prepare($dbconn, "bases_query", $bases_query);
$bases = array();
if ($bases_result) {
    $bases_final = pg_execute($dbconn, "bases_query", []);
    if (!$bases_final) {
        echo json_encode(['error' => pg_last_error($dbconn)]);
        exit;
    }
} else {
    echo json_encode(['error' => pg_last_error($dbconn)]);
    exit;
}
$items_query = <<< EOF
        SELECT items.item_id, items.iname, items.quantity, item_category.category_name, 
               requests.req_id, requests.quantity, requests.reg_date
        FROM items JOIN requests ON items.item_id = requests.item_id
        JOIN item_category ON items.category = item_category.category_id
        WHERE requests.pending = TRUE AND requests.completed = FALSE
EOF;

$items_result = pg_prepare($dbconn, "items_query",$items_query);
if ($items_result) {
    $items_final = pg_execute($dbconn, "items_query", []);
    if (!$items_final) {
        echo json_encode(['error' => pg_last_error($dbconn)]);
        exit;
    }
}else {
    // Error details if preparing the items_query fails
    echo json_encode(['error' => pg_last_error($dbconn)]);
    exit;
}

if ($bases_final) {
    $item_data = pg_fetch_all($items_final);
    $bases_data = pg_fetch_all($bases_final);
    $data = array(
            'items' => $item_data,
            'bases' => $bases_data
        );
        echo json_encode($data);
}
include '../../model/dbclose.php';
