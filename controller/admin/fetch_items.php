<?php
include '../../model/config.php';

// Get from  Quantity from Storage
//$item_query = "SELECT * FROM items";
$item_query='SELECT
                items.item_id,
                items.iname,
                items.quantity,
                item_category.category_name as category,
                item_category.category_id,
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
$categories = [];
foreach ($items_array as $item) {
    $item_id = $item['item_id'];
    $combined_items[$item_id] = $item;
    $category_id = $item['category_id'];
    $category_name = $item['category'];
    if (!isset($categories[$category_id])) {
        $categories[$category_id] = $category_name;
    }
}

foreach ($veh_load_array as $veh_load) {
    $item_id = $veh_load['item_id'];
    if (isset($combined_items[$item_id])) {
        $combined_items[$item_id]['quantity'] += $veh_load['load'];
    }else{
        $combined_items[$item_id]['quantity'] = $veh_load['load'];
    }
}
//$categories = array_unique(array_column($combined_items, 'category'));
$categories_n_items = [
    'items' => $items_array,
    'combined_items' => $combined_items,
    'categories' => $categories
];
echo json_encode($categories_n_items);

include("../../model/dbclose.php");
