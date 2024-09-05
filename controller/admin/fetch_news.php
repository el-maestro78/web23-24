<?php
include '../../model/config.php';
include '../../ini.php';
include '../../auxiliary.php';

$query = <<< EOF
    SELECT news.title, news.descr, news.date, news.base_id, items.iname as item_name 
    FROM news JOIN items ON news.item_id = items.item_id
    ;
EOF;
$result = pg_query($dbconn, $query);

if ($result) {
    $news = pg_fetch_all($result);
    echo json_encode($news);
}else{
    die(pg_last_error($dbconn));
}

include '../../model/dbclose.php';