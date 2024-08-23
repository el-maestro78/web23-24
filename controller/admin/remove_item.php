<?php
function remove_item($item_name){
    $sql = <<< EOF
            SELECT iname
            FROM items
            WHERE iname = $item_name;
        EOF;
    $check_if_already_exists = pg_query($dbconn, $sql);

    if ($check_if_already_exists && pg_num_rows($check_if_already_exists) <= 0) {
        echo "Item $item_name doesn't exist";
    } else {

        $sql = "DELETE FROM items WHERE iname = $item_name";
        $result = pg_query($dbconn, $sql);

        if (!$result) {
            $error_message = "Problem with deleting item $item_name";
            echo $error_message;
        }
    }
}