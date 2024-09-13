<?php
include './model/dbclose.php';
session_start();
session_unset();
session_destroy();

if (isset($_COOKIE['login_session'])) {
    setcookie('login_session', '', time() - 3600, '/'); // 1 hour ago
}


header('Location: /views/login/login.php');
exit();
