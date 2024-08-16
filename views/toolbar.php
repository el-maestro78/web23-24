<!DOCTYPE html>
<html lang="en">
    <style>
        .topnav {
          overflow: hidden;
          background-color: #333;
        }

        .topnav a {
          float: left;
          color: #f2f2f2;
          text-align: center;
          padding: 14px 16px;
          text-decoration: none;
          font-size: 17px;
        }

        .topnav a:hover {
          background-color: #ddd;
          color: black;
        }

        .topnav a.active {
            background-color: #04AA6D;
            color: white;
        }
    </style>

    <body>
        <!-- Only for testing!! -->
        <?php include "index.php"?>
        <?php //($_SESSION['role']='admin') ?>
        <?php $current_page = $_SERVER['REQUEST_URI']; ?>

        <nav class="topnav">
            <a href="<?php echo $base_url; ?>/views/home_page.php" class="<?php echo strpos($current_page, 'home_page.php') !== false ? 'active' : ''; ?>">Home</a>
            <a href="<?php echo $base_url; ?>/views/maps/maps.php" class="<?php echo strpos($current_page, 'maps.php') !== false ? 'active' : ''; ?>">Maps</a>
            <a href="<?php echo $base_url; ?>/views/news/news.php" class="<?php echo strpos($current_page, 'news.php') !== false ? 'active' : ''; ?>">News</a>
            <a href="<?php echo $base_url; ?>/404.php" class="<?php echo strpos($current_page, 'contact.php') !== false ? 'active' : ''; ?>">Contact</a>
            <a href="<?php echo $base_url; ?>/404.php" class="<?php echo strpos($current_page, 'about.php') !== false ? 'active' : ''; ?>">About</a>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                <a href="<?php echo $base_url; ?>/views/storage/storage.php" class="<?php echo strpos($current_page, 'storage.php') !== false ? 'active' : ''; ?>">Storage</a>
                <a href="<?php echo $base_url; ?>/views/statistics/stats.php" class="<?php echo strpos($current_page, 'stats.php') !== false ? 'active' : ''; ?>">Statistics</a>
                <a href="<?php echo $base_url; ?>/views/addAccount/addAccount.php" class="<?php echo strpos($current_page, 'addAccount.php') !== false ? 'active' : ''; ?>">Add Account</a>
            <?php endif; ?>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'rescuer') : ?>
                <a href="<?php echo $base_url; ?>/404.php" class="<?php echo strpos($current_page, 'rescuer_link1.php') !== false ? 'active' : ''; ?>">Add things here only for rescuer</a>
                <a href="<?php echo $base_url; ?>/404.php" class="<?php echo strpos($current_page, 'rescuer_link2.php') !== false ? 'active' : ''; ?>">Add things here only for rescuer</a>
            <?php endif; ?>
        </nav>


    </body>
</html>
<!--
        <nav class="topnav">
          <a class="active" href="<?php echo dirname(__DIR__) . '\views\home_page.php';?>">Home</a>
          <a href="<?php echo dirname(__DIR__) . '/views/maps/maps.php';?>">Maps</a>
          <a href="<?php echo dirname(__DIR__) . '/views/news/news.php';?>">News</a>
          <a href="<?php echo dirname(__DIR__) . '/404.php';?>">Contact</a>
          <a href="<?php echo dirname(__DIR__) . '/404.php';?>.">About</a>
          <a href="<?php echo dirname(__DIR__) . '/404.php';?>">Statistics</a>
        </nav>



-->
<!--
 <?php $base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']); ?>
-->

<!--        <div style="padding-left:16px">
          <h2>Top Navigation Example</h2>
          <p>Some content..</p>
        </div>
     <nav class="topnav">
        <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="services.php">Services</a></li>
        <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
 -->