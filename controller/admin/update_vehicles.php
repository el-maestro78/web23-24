<?php
/*
Update the vehicle positions on the database.
If they exist and we are not in session
*/
include("../../model/config.php");

$query = "SELECT * FROM vehicles";
$result = pg_query($dbconn, $query);

if (!$result) {
    die("Error: " . pg_last_error());
}
$usernames= array();
$ids = array();
if (pg_num_rows($result) !== 0){
    while ($row = pg_fetch_assoc($result)) {
        $usernames[] = $row['username'];
        $ids[] = $row['veh_id'];
    }
}
    $cnt = 0;
    foreach ($vehicles as $veh) {
        $id = pg_escape_literal($ids[$cnt]);
        $username = pg_escape_literal($usernames[$cnt]);
        $lat = pg_escape_literal($veh['lat']);
        $long = pg_escape_literal($veh['long']);
        $cnt += 1;
        try{
            $update_query = "UPDATE vehicles SET lat = $lat, long = $long WHERE veh_id = $id";
            $update_result = pg_query($dbconn, $update_query);
            if (!$update_result) {
                die("Error updating vehicle: " . pg_last_error());
            }
        } catch (Exception $e) {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        $insert_query = "INSERT INTO vehicles (veh_id, username, lat, long) VALUES ($id, $username, $lat, $long)";
        $insert_result = pg_query($dbconn, $insert_query);
        if (!$insert_result) {
            die("Error inserting vehicle: " . pg_last_error());
            }
        }
            
}

//echo "Vehicles updated successfully."; //DEBUG

include("../../model/dbclose.php");
