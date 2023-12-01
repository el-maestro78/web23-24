<?php
// Distance calculate with Haversine Formula
function haversineDistance($lat1, $lon1, $lat2, $lon2)
{
    $R = 6371000; // Earth radius in meters

    $lat1Rad = deg2rad($lat1);
    $lon1Rad = deg2rad($lon1);
    $lat2Rad = deg2rad($lat2);
    $lon2Rad = deg2rad($lon2);

    $dlat = $lat2Rad - $lat1Rad;
    $dlon = $lon2Rad - $lon1Rad;

    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1Rad) * cos($lat2Rad) * sin($dlon / 2) * sin($dlon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $R * $c; // Distance in meters

    return $distance;
}

// Example coordinates
$base_lat = 37.910989; // Latitude of point 1
$base_lon = 21.441535; // Longitude of point 1
$current_vehicle_lat = 37.900836; // Latitude of point 2
$current_vehicle_lon = 21.515990; // Longitude of point 2

$distance = haversineDistance($base_lat, $base_lon, $current_vehicle_lat, $current_vehicle_lon);

echo "Distance between the points: " . $distance . " meters";
?>