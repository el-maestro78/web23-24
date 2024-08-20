<?php  
require_once './model/config.php';

//echo '<div style="text-align: center; font-size: 72px;"><b>ERROR 404</b></div>';

$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: /views/login/login.php');
    exit();
}
