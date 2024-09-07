<?php
include("./add_vehicles.php");
include("../../model/config.php");

$query = <<< EOF
    SELECT 
        vehicles.veh_id, 
        dbUser.username, 
        vehicles.long, 
        vehicles.lat 
    FROM vehicles JOIN vehicle_rescuers ON vehicle_rescuers.veh_id = vehicles.veh_id
    JOIN dbUser ON vehicle_rescuers.user_id = dbUser.user_id;
EOF;
$result = pg_query($dbconn, $query);

if (!$result) {
    die("Error in SQL query: " . pg_last_error());
}

$tasked_vehicles = array();
while ($row = pg_fetch_assoc($result)) {
    $tasked_vehicles[] = $row;
}
$avail_query = <<< EOF
        SELECT vehicles.veh_id
        FROM vehicles
        WHERE vehicles.veh_id NOT IN (SELECT vehicle_rescuers.veh_id FROM vehicle_rescuers)
EOF;

$avail_result = pg_query($dbconn, $avail_query);

$available_vehicles = array();
while ($row = pg_fetch_assoc($avail_result )) {
    $available_vehicles[] = $row;
}

$vehicles = [
    'tasked' => $tasked_vehicles,
    'available' => $available_vehicles,
    'merged' => array_merge($tasked_vehicles, $available_vehicles)
];
echo json_encode($vehicles);

pg_free_result($result);

