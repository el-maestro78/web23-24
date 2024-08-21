<?php
require_once "model/config.php";
session_start();
//$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
$base_url = 'http://' . $_SERVER['HTTP_HOST'];
//echo $base_url;
$GLOBALS['base_url'] = $base_url;
function validate_input($data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}
