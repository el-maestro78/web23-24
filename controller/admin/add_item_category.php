<?php
function add_item_category($item_categ, $categ_details = ""){
    $sql = <<< EOF
            SELECT category_name
            FROM item_category
            WHERE category_name = $item_categ;
        EOF;
    $check_if_already_exists = pg_query($dbconn, $sql);

    if ($check_if_already_exists && pg_num_rows($check_if_already_exists) > 0) {
        echo "Item category $item_categ already exists";
    } else {

        $sql = <<< EOF
                INSERT INTO item_category(category_name, details) 
                VALUES ($item_categ, $categ_details)";
            EOF;
        $result = pg_query($dbconn, $sql);

        if (!$result) {
            $error_message = "Problem with insert category $item_categ";
            echo $error_message;
        }
    }
}