<?php /*
Creates random position for the vehicles(in 5km radius from bases).
Then calls update_vehicles to add them in database
*/ ?>
<?php
include('../admin/get_store_pos.php');
include("../../model/config.php");
include('../../model/Classes/base.php');

$bases_obj = array();
foreach ($bases as $base) {
    $bases_obj[] = new Base($base['base_id'], $base['lat'], $base['long']);
}
function generateRandomCoordinates($lat, $lng, $min_radius, $max_radius): array
{ //$sea_lat=38.250114, $sea_long=21.735844
    $earth_radius = 6371; // Earth's radius in kilometers
    $max_radius_in_degrees = $max_radius / $earth_radius;
    $min_radius_in_degrees = $min_radius / $earth_radius;
    do {
        $random_distance = $max_radius_in_degrees * sqrt(mt_rand() / mt_getrandmax());
    } while ($random_distance < $min_radius_in_degrees); // Ensure it is not too close

    $random_angle = mt_rand(0, 360) * (M_PI / 180); // Random angle in radians

    $new_lat = $lat + ($random_distance * cos($random_angle));
    $new_lng = $lng + ($random_distance * sin($random_angle)) / cos(deg2rad($lat));
    
    return array('lat' => $new_lat, 'long' => $new_lng);
}

// Create vehicles at random positions and print results
$vehicles = array();
$min_distance = 1;
$max_distance = 5;
foreach ($bases_obj as $base) {
    $vehicle_position = generateRandomCoordinates($base->lat, $base->long, 1, 5); // 5km radius
    $vehicles[] = $vehicle_position;
}

include("./update_vehicles.php");
