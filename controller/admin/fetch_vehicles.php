<?php
include("../../model/config.php");
?>
<?php

// Fetch store locations
$query = "SELECT veh_id , long, lat FROM vehicles";
$result = pg_query($dbconn, $query);

if (!$result) {
    die("Error in SQL query: " . pg_last_error());
}

$bases = array();
while ($row = pg_fetch_assoc($result)) {
    $bases[] = $row;
}


header('Content-Type: application/json');
echo json_encode($bases);

pg_free_result($result);

?>
<?php
include("../../model/dbclose.php");
?>