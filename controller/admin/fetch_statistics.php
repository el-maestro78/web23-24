<?php
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
// Fetch new requests within the date range
$new_requests_query = "SELECT COUNT(*) FROM requests WHERE created_at BETWEEN $1 AND $2";
$new_requests_result = pg_query_params($dbconn, $new_requests_query, array($start_date, $end_date));
$new_requests_count = pg_fetch_result($new_requests_result, 0, 0);
// Fetch new offers within the date range
$new_offers_query = "SELECT COUNT(*) FROM offers WHERE created_at BETWEEN $1 AND $2";
$new_offers_result = pg_query_params($dbconn, $new_offers_query, array($start_date, $end_date));
$new_offers_count = pg_fetch_result($new_offers_result, 0, 0);
// Fetch completed requests within the date range
$completed_requests_query = "SELECT COUNT(*) FROM requests WHERE resolved_at BETWEEN $1 AND $2";
$completed_requests_result = pg_query_params($dbconn, $completed_requests_query, array($start_date, $end_date));
$completed_requests_count = pg_fetch_result($completed_requests_result, 0, 0);
// Fetch completed offers within the date range
$completed_offers_query = "SELECT COUNT(*) FROM offers WHERE resolved_at BETWEEN $1 AND $2";
$completed_offers_result = pg_query_params($dbconn, $completed_offers_query, array($start_date, $end_date));
$completed_offers_count = pg_fetch_result($completed_offers_result, 0, 0);
// Prepare data to send back to the client
$response = array(
    "new_requests" => $new_requests_count,
    "new_offers" => $new_offers_count,
    "completed_requests" => $completed_requests_count,
    "completed_offers" => $completed_offers_count
);
header('Content-Type: application/json');
echo json_encode($response);