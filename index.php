<?php  
require_once './model/config.php';

echo '<div style="text-align: center; font-size: 72px;"><b>ERROR 404</b></div>';

$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
