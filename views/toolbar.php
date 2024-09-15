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
          margin-top: 0;
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

        .loginbtn {
          background-color: #04aa12;
          color: white;
          padding: 14px 16px;
          font-size: 15px;
          border: none;
        }
        .logoutbtn {
            background-color: rgba(226, 15, 15, 0.94);
            color: white;
            padding: 14px 16px;
            font-size: 15px;
            border: none;
        }
        .profile{
            display: flex;
            justify-content: right;
        }
    </style>

    <body>
        <!-- Only for testing!! -->
        <?php //include '../ini.php';?>
        <?php //($_SESSION['role']='admin') ?>
        <?php //($_SESSION['user_id']=1) ?>
        <?php $current_page = $_SERVER['REQUEST_URI']; ?>
        <nav class="topnav">
            <a href="<?php echo $base_url; ?>/views/home_page.php" class="<?php echo str_contains($current_page, 'home_page.php') ? 'active' : ''; ?>">Home</a>
            <!--Specific to role-->
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                <a href="<?php echo $base_url; ?>/views/maps/maps.php" class="<?php echo str_contains($current_page, 'maps.php') ? 'active' : ''; ?>">Maps</a>
                <a href="<?php echo $base_url; ?>/views/news/news.php" class="<?php echo (str_contains($current_page, 'news.php') && !str_contains($current_page, 'civ')) ? 'active' : ''; ?>"> Add News</a>
                <!--
                <a href="<?php echo $base_url; ?>/storage/storage.php" class="<?php echo str_contains($current_page, 'storage.php') ? 'active' : ''; ?>">View Stock</a>
                -->
                <a href="<?php echo $base_url; ?>/views/storeManage/storeManage.php" class="<?php echo str_contains($current_page, 'storeManage.php') ? 'active' : ''; ?>">Storage Management</a>
                <a href="<?php echo $base_url; ?>/views/statistics/stats.php" class="<?php echo str_contains($current_page, 'stats.php') ? 'active' : ''; ?>">Statistics</a>
                <a href="<?php echo $base_url; ?>/views/addAccount/addAccount.php" class="<?php echo str_contains($current_page, 'addAccount.php') ? 'active' : ''; ?>">Add Account</a>
            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'rescuer') : ?>
                 <a href="<?php echo $base_url; ?>/views/maps/resc_maps.php" class="<?php echo str_contains($current_page, 'resc_maps.php') ? 'active' : ''; ?>">Maps</a>
                <!--
                <a href="<?php echo $base_url; ?>/views/tasks/tasks.php" class="<?php echo str_contains($current_page, 'tasks.php') ? 'active' : ''; ?>">Task Management</a>
                -->
                <a href="<?php echo $base_url; ?>/views/rescuer/vehicle_load/vehicle_load.php" class="<?php echo str_contains($current_page, 'vehicle_load.php') ? 'active' : ''; ?>">Load Management</a>
            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'civilian') : ?>
                <a href="<?php echo $base_url; ?>/views/news/civ_news.php" class="<?php echo str_contains($current_page, 'civ_news.php') ? 'active' : ''; ?>">News</a>
                <a href="<?php echo $base_url; ?>/views/offers/offers.php" class="<?php echo str_contains($current_page, 'offers.php') ? 'active' : ''; ?>">Offers</a>
                <a href="<?php echo $base_url; ?>/views/requests/requests.php" class="<?php echo str_contains($current_page, 'requests.php') ? 'active' : ''; ?>">Requests</a>
            <?php endif; ?>
            <a href="<?php echo $base_url; ?>/views/contact/contact.php" class="<?php echo str_contains($current_page, 'contact.php') ? 'active' : ''; ?>">Contact</a>
            <a href="<?php echo $base_url; ?>/views/about/about.php" class="<?php echo str_contains($current_page, 'about.php') ? 'active' : ''; ?>">About</a>
            <a class="<?php echo str_contains($current_page, 'profile.php') ? 'active' : ''; ?> ms-auto;" href="<?php echo $base_url; ?>/views/profile/profile.php">
                <i class="bi bi-person-circle"></i></a>
            <div class="Log-btns">
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <button id="logoutbtn" class="logoutbtn">Logout</button>
                <?php endif; ?>
                <?php if (!isset($_SESSION['user_id'])) : ?>
                    <button id="loginbtn" class="loginbtn">Login</button>
                <?php endif; ?>
            </div>
        </nav>
        <script defer>
            const loginBtn = document.getElementById("loginbtn");
            const logoutBtn = document.getElementById("logoutbtn");

            if (loginBtn) {
                loginBtn.addEventListener("click", function() {
                    window.location.href = "<?php echo $base_url; ?>/views/login/login.php";
                });
            }

            if (logoutBtn) {
                logoutBtn.addEventListener("click", function() {
                    window.location.href = "<?php echo $base_url; ?>/logout.php";
                });
            }
        </script>
    </body>
</html>
