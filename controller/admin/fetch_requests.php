<?php
include("../../model/config.php");

$query = "SELECT req_id, pending, quantity, reg_date, assign_date, user_id, item_id, lat, long FROM requests";
$result = pg_query($dbconn, $query);

if (!$result) {
    die("Error in SQL query: " . pg_last_error());
}

$requests = array();
while ($row = pg_fetch_assoc($result)) {
    $requests[] = $row;
}

//header('Content-Type: application/json');
echo json_encode($requests);

pg_free_result($result);


include("../../model/dbclose.php");
?>