<?php
include '../../model/config.php';

// Get from  Quantity from Storage
//$item_query = "SELECT * FROM items";
$item_query='SELECT
                items.item_id,
                items.iname,
                items.quantity,
                item_category.category_name as category,
                items.details
            FROM items JOIN item_category 
            ON items.category=item_category.category_id
            ';
$item_result = pg_query($dbconn, $item_query);
if (!$item_result) die( http_response_code(500));
$items_array = pg_fetch_all($item_result);
// Get quantity from vehicles
$veh_load_query = "SELECT item_id, load FROM vehicle_load";
$veh_load_result = pg_query($dbconn, $veh_load_query);
if (!$veh_load_result) die( http_response_code(500));
$veh_load_array = pg_fetch_all($veh_load_result);

$combined_items = [];
foreach ($items_array as $item) {
    $item_id = $item['item_id'];
    $combined_items[$item_id] = $item;
}

foreach ($veh_load_array as $veh_load) {
    $item_id = $veh_load['item_id'];
    if (isset($combined_items[$item_id])) {
        $combined_items[$item_id]['quantity'] += $veh_load['load'];
    }else{
        $combined_items[$item_id]['quantity'] = $veh_load['load'];
    }
}
$categories = array_unique(array_column($combined_items, 'category'));

include("../../model/dbclose.php");