<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    </head>
    <style>
        .topnav {
          overflow: hidden;
          background-color: #333;
          z-index: 1;
        }

        .topnav a {
          float: left;
          color: #f2f2f2;
          text-align: center;
          padding: 14px 16px;
          text-decoration: none;
          font-size: 15px;
        }

        .topnav a:hover {
          background-color: #ddd;
          color: black;
        }

        .topnav a.active {
            background-color: #04AA6D;
            color: white;
        }
        /* NEW */

        .profile-icon {
            font-size: 30px;
            cursor: pointer;
            color: #f2f2f2;
        }
        .dropbtn {
          background-color: #04AA6D;
          color: white;
          padding: 16px;
          font-size: 16px;
          border: none;
        }

        /* The container <div> - needed to position the dropdown content */
        .dropdown {
          position: relative;
          display: inline-block;
        }

        /* Dropdown Content (Hidden by Default) */
        .dropdown-content {
          display: none;
          position: absolute;
          background-color: #f1f1f1;
          min-width: 160px;
          box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
          z-index: 1;
        }

        /* Links inside the dropdown */
        .dropdown-content a {
          color: black;
          padding: 12px 16px;
          text-decoration: none;
          display: block;
        }

        /* Change color of dropdown links on hover */
        .dropdown-content a:hover {background-color: #ddd;}

        /* Show the dropdown menu on hover */
        .dropdown:hover .dropdown-content {display: block;}

        /* Change the background color of the dropdown button when the dropdown content is shown */
        .dropdown:hover .dropbtn {background-color: #3e8e41;}
    </style>

    <body>
        <!-- Only for testing!! -->
        <?php include "index.php"?>
        <?php ($_SESSION['role']='admin') ?>
        <?php ($_SESSION['user_id']=0) ?>
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
            <div class="dropdown">
                  <i class="bi bi-person-circle profile-icon" id="profileIcon"></i>
                  <div class="dropdown-content">
                    <a href="#">Link 1</a>
                    <a href="#">Link 2</a>
                    <a href="#">Link 3</a>
                  </div>
            </div>

        </nav>
        <script>
            document.getElementById("profileIcon").addEventListener("click", function() {
                var popup = document.getElementById("profilePopup");
                popup.style.display = (popup.style.display === "block") ? "none" : "block";
            });

            // Close the popup if the user clicks outside of it
            window.addEventListener("click", function(event) {
                var popup = document.getElementById("dropdown-content");
                if (event.target !== document.getElementById("profileIcon") && event.target !== popup) {
                    popup.style.display = "none";
                }
            });

        </script>

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