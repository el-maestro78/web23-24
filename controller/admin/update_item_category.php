<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

$item_categ = $_POST['item_categ'];
$categ_details = $_POST['categ_details'] ?? "";
$action = $_POST['action'];

$item_categ = validate_input($item_categ);
$categ_details = validate_input($categ_details);
$action = validate_input($action);

switch($action){
    case "insert":
        add_item_category($item_categ, $categ_details);
        break;
    case "remove":
        remove_item_category($item_categ);
        break;
    case "details":
        details_item_category($item_categ, $categ_details);
        break;
    default:
        echo "Error with $action for $item_categ";
}
