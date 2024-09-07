<?php

include '../../model/config.php';
include '../../ini.php';
include '../../auxiliary.php';

$query = <<< EOF
        SELECT vehicles.veh_id
        FROM vehicles
        WHERE vehicles.veh_id NOT IN (SELECT vehicle_rescuers.veh_id FROM vehicle_rescuers)
EOF;

$result = pg_query($dbconn, $query);
if (!$result) {
    echo json_encode(['exists' => false, 'error' => pg_last_error($dbconn)]);
}else{
    $vehicles = pg_fetch_all($result);
    echo json_encode(['exists' => true, 'vehicles' => $vehicles]);
}
