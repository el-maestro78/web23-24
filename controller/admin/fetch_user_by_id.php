<?php
include("../../model/config.php");

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';

if ($user_id) {
    // Prepare SQL query
    $query = "SELECT user_id, first_name, surname, phone FROM dbUser WHERE user_id=$1";

    // Prepare and execute the query
    $result = pg_query_params($dbconn, $query, array($user_id));

    // Check if query was successful
    if ($result) {
        $user_data = pg_fetch_all($result);
        echo json_encode($user_data);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database query failed']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing user_id']);
}
include("../../model/dbclose.php");
?>