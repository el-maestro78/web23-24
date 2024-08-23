<?php
require_once "model/config.php";
/*
if(!isset($_SESSION["user_id"])){
    header("Location: logout.php");
    exit();
}else{
    session_start();
}*/
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
session_start();
$base_url = 'http://' . $_SERVER['HTTP_HOST']; //   . dirname($_SERVER['SCRIPT_NAME']);
$GLOBALS['base_url'] = $base_url;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 1800) {
    // Last request was more than 30 minutes ago
    session_unset();     // Unset $_SESSION variable for the run-time
    session_destroy();   // Destroy session data in storage
}
$_SESSION['last_activity'] = time();