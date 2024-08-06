<?php /*
Update the vehicle positions on the database. 
If they exist and we are not in session(//TODO) the old positions are updated in the database

*/?>
<?php
include("../../model/config.php");

$query = "SELECT * FROM vehicles";
$result = pg_query($dbconn, $query);

if (!$result) {
    die("Error: " . pg_last_error());
}
$usernames= array();

//$count = pg_fetch_result($result, 0, 0);
//if ($count > 0){
if (pg_num_rows($result) !== 0){
    while ($row = pg_fetch_assoc($result)) {
        $usernames[] = $row['username'];
    }
    $delete_query = "DELETE FROM vehicles";
    $delete_result = pg_query($dbconn, $delete_query);

    if (!$delete_result) {
        die("Error deleting vehicles: " . pg_last_error());
    }
    $insert_query = "INSERT INTO vehicles (username, lat, long) VALUES ";
    $values = array();
    $cnt = 0;
    foreach ($vehicles as $veh) {
        // Ensure username is properly quoted and escaped
        $username = pg_escape_literal($usernames[$cnt]);
        $lat = $veh['lat'];
        $long = $veh['long'];
        $values[] = "($username, $lat, $long)";
        $cnt += 1;
    }

    $insert_query .= implode(", ", $values);
    $insert_result = pg_query($dbconn, $insert_query);

    if (!$insert_result) {
        die("Error inserting vehicles: " . pg_last_error());
    }
}else{
    $insert_query = "INSERT INTO vehicles (username, lat, long) VALUES ";
    $values = array();
    $cnt = 0;
    foreach ($vehicles as $veh) {
        $values[] = "({$cnt}, {$veh['lat']}, {$veh['long']})";
        $cnt += 1;
    }

    $insert_query .= implode(", ", $values);
    $insert_result = pg_query($dbconn, $insert_query);

    if (!$insert_result) {
        die("Error inserting vehicles: " . pg_last_error());
    }
}

echo "Vehicles updated successfully.";
?>
<?php
include("../../model/dbclose.php");
?>