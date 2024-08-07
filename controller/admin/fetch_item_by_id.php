<?php
include("../../model/config.php");

$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : '';

if ($item_id) {
    $query = "SELECT item_id, iname, quantity, category FROM items WHERE item_id=$1";
    $result = pg_query_params($dbconn, $query, array($item_id));

    if ($result) {
        $item_data = pg_fetch_all($result);
        echo json_encode($item_data);
    }else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed']);
    }
}else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing item_id']);
}
include("../../model/dbclose.php");
?>