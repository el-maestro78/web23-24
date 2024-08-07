<?php
include("./get_store_pos.php");
header('Content-Type: application/json');
echo json_encode($bases);
?>