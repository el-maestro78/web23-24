<?php
session_start();
include '../../model/config.php';
include 'distance_calculator.php';

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id']; 

$query = 'SELECT veh_id FROM vehicle_rescuers WHERE user_id = $1';
$result = pg_query_params($dbconn, $query, array($user_id));
if (!$result) die( http_response_code(500));
$veh_id = pg_fetch_assoc($result);
if (!$veh_id) die("No vehicle found for this user.");

$query ='SELECT
               vehicle_load.load as load,
               items.item_id as item_id,
               items.iname as iname,
               items.quantity as base_quantity
            FROM vehicle_load JOIN vehicles ON vehicle_load.veh_id = vehicles.veh_id 
            JOIN vehicle_rescuers ON vehicles.veh_id = vehicle_rescuers.veh_id
            JOIN items ON vehicle_load.item_id = items.item_id
            WHERE vehicles.veh_id = $1;';
$result = pg_query_params($dbconn, $query, array($veh_id['veh_id']));
if (!$result) die( http_response_code(500));
$veh_info = pg_fetch_all($result);

$query='SELECT
            category_id,
            category_name
        FROM item_category';
$item_categ_result = pg_query($dbconn, $query);
if (!$item_categ_result) die( http_response_code(500));
$categories_array = pg_fetch_all($item_categ_result);

$query='SELECT
            item_id,
            iname,
            quantity,
            category
        FROM items';
$items_result = pg_query($dbconn, $query);
if (!$items_result) die( http_response_code(500));
$items_array = pg_fetch_all($items_result);

function refresh_location($dbconn, $veh_id) {
    $min_distance = PHP_INT_MAX;
    $closest_base = null;
    $query = 'SELECT
                long,
                lat
                FROM vehicles WHERE veh_id = $1;';
    $result = pg_query_params($dbconn, $query, array($veh_id));
    if (!$result) die( http_response_code(500));
    $veh_coord = pg_fetch_assoc($result);

    $query = 'SELECT
                base_id,
                lat,
                long
                FROM base;';
    $result = pg_query($dbconn, $query);
    if (!$result) die( http_response_code(500));
    $bases = pg_fetch_all($result);

    foreach ($bases as $base) {
        $distance = haversineDistance($base['lat'], $base['long'], $veh_coord['lat'], $veh_coord['long']);
        
        if ($distance < $min_distance) {
            $closest_base = $base['base_id'];
            $min_distance = $distance;
        }
    }
    
    return array($closest_base, $min_distance);
}

$current_distance = refresh_location($dbconn, $veh_id['veh_id']);
$edit_button_class = $current_distance[1] <= 100 ? 'button_edit' : 'button_not_allowed';

$vehicle_load = [
    'veh_info' => $veh_info,
    'veh_id' => $veh_id,
    'current_distance' => $current_distance,
    'edit_button_class' => $edit_button_class,
    'categories_array' => $categories_array,
    'items_array' => $items_array,
];
echo json_encode($vehicle_load);
?>

