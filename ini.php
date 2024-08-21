<?php
require_once "model/config.php";
/*
if(!isset($_SESSION["user_id"])){
    header("Location: logout.php");
    exit();
}else{
    session_start();
}*/

session_start();
$base_url = 'http://' . $_SERVER['HTTP_HOST']; //   . dirname($_SERVER['SCRIPT_NAME']);
$GLOBALS['base_url'] = $base_url;
