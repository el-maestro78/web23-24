<?php
include("../../model/config.php");
include("./add_vehicles.php");
?>
<?php
$query = "SELECT veh_id, long, lat FROM vehicles";
$result = pg_query($dbconn, $query);

if (!$result) {
    die("Error in SQL query: " . pg_last_error());
}

$vehicles = array();
while ($row = pg_fetch_assoc($result)) {
    $vehicles[] = $row;
}

header('Content-Type: application/json');
json_encode($vehicles);

pg_free_result($result);

?>
<?php
include("../../model/dbclose.php");
?>