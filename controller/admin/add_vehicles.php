<?php /*
Creates random position for the vehicles(in 5km radius from bases).
Then calls update_vehicles to add them in database
*/ ?>
<?php
include("../../model/config.php");
include('../admin/fetch_stores.php');
include('../../model/Classes/base.php');

$bases_obj = array();
foreach ($bases as $base) {
    $bases_obj[] = new Base($base['base_id'], $base['lat'], $base['long']);
}
function generateRandomCoordinates($lat, $lng, $radius)
{
    $earth_radius = 6371;
    $radius_in_degrees = $radius / $earth_radius;
    $random_distance = $radius_in_degrees * sqrt(mt_rand() / mt_getrandmax());
    $random_angle = mt_rand(0, 360) * (M_PI / 180); // Random angle in radians

    $new_lat = $lat + ($random_distance * cos($random_angle));
    $new_lng = $lng + ($random_distance * sin($random_angle)) / cos(deg2rad($lat));

    return array('lat' => $new_lat, 'long' => $new_lng);
}

// Create vehicles at random positions and print results
$vehicles = array();
foreach ($bases_obj as $base) {
    $vehicle_position = generateRandomCoordinates($base->lat, $base->long, 5); // 5km radius
    $vehicles[] = $vehicle_position;
    echo "Vehicle Lat: " . $vehicle_position['lat'] . ", Vehicle Long: " . $vehicle_position['long'] . "<br>\n";
    echo "Base ID: " . $base->base_id . ", Base Lat: " . $base->lat . ", Base Long: " . $base->long . "<br>\n";
}

include("./update_vehicles.php");
include("../../model/dbclose.php");
?>