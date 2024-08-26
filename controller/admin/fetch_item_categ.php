<?php
include '../../model/config.php';

$item_categ_query='SELECT
               category_id,
               category_name,
               details
            FROM item_category ';

$item_categ_result = pg_query($dbconn, $item_categ_query);
if (!$item_categ_result) die( http_response_code(500));
$categories_array = pg_fetch_all($item_categ_result);

include("../../model/dbclose.php");