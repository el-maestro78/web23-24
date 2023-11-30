<?php
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
$lat1 = 40.7128; // Latitude of point 1
$lon1 = -74.0060; // Longitude of point 1
$lat2 = 34.0522; // Latitude of point 2
$lon2 = -118.2437; // Longitude of point 2

$distance = haversineDistance($lat1, $lon1, $lat2, $lon2);

echo "Distance between the points: " . $distance . " meters";
?>