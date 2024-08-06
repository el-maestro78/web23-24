<?php
include("../../model/config.php");
include('../admin/fetch_stores.php');
include('../../model/Classes/base.php');

$bases_obj = array();
foreach ($bases as $base) {
    $bases_obj[] = new Base($base['base_id'], $base['lat'], $base['long']);
}


foreach ($bases_obj as $base) {
    echo "Base ID: " . $base->base_id . ", Lat: " . $base->lat . ", Long: " . $base->long . "<br>\n";
    
}




include("../../model/dbclose.php");
