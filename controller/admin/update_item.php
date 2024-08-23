<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item_name = ($_POST['item_name']);
$item_quant = $_POST['item_quant'] ?? 0;
$item_categ= $_POST['item_categ'] ?? '';
$item_details= $_POST['item_details'] ??'';
$action = $_POST['action'];

$item_name = validate_input($item_name);
$item_quant = validate_input($item_quant);
$item_categ = validate_input($item_categ);
$item_details = validate_input($item_details);
$action = validate_input($action);

switch ($action) {
    case "insert":
        add_item($item_name, $item_quant, $item_categ, $item_details);
        break;
    case "remove":
        remove_item($item_name);
        break;
    case "details":
    update_item_details($item_name, $item_details);
        break;
    case "quantity":
        update_item_quantity($item_name, $item_quant);
        break;
    default:
        echo "Error with $action for $item_categ";
    }
