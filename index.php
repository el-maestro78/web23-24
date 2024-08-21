<?php  
require_once './model/config.php';
require_once './auxiliary.php';

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: /views/login/login.php');
    exit();
}else{
    header('Location: /views/home_page.php');
}
