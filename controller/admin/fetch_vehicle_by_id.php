<?php
include("../../model/config.php");

$veh_id = isset($_GET['veh_id']) ? $_GET['veh_id'] : '';

if($veh_id !== null && $veh_id != "") {
    // Prepare SQL query
    $query = "SELECT veh_id, first_name, surname, phone FROM dbUser WHERE veh_id=$1";
    
    // Prepare and execute the query
    $result = pg_query_params($dbconn, $query, array($veh_id));

    // Check if query was successful
    if ($result) {
        $veh_data = pg_fetch_all($result);
        echo json_encode($veh_data);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing veh_id']);
}
include("../../model/dbclose.php");
?>