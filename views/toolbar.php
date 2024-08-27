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
    </style>

    <body>
        <!-- Only for testing!! -->
        <?php include '../ini.php';?>
        <?php //($_SESSION['role']='admin') ?>
        <?php //($_SESSION['user_id']=1) ?>
        <?php $current_page = $_SERVER['REQUEST_URI']; ?>
        <nav class="topnav">
            <a href="<?php echo $base_url; ?>/views/home_page.php" class="<?php echo strpos($current_page, 'home_page.php') !== false ? 'active' : ''; ?>">Home</a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                 <a href="<?php echo $base_url; ?>/views/maps/maps.php" class="<?php echo strpos($current_page, 'maps.php') !== false ? 'active' : ''; ?>">Maps</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'rescuer') : ?>
                <a href="<?php echo $base_url; ?>/views/maps/resc_maps.php" class="<?php echo strpos($current_page, 'resc_maps.php') !== false ? 'active' : ''; ?>">Maps</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'civilian') : ?>
                <a href="<?php echo $base_url; ?>/views/maps/civ_maps.php" class="<?php echo strpos($current_page, 'civ_maps.php') !== false ? 'active' : ''; ?>">Maps</a>
            <?php endif; ?>
            <a href="<?php echo $base_url; ?>/views/news/civ_news.php" class="<?php echo strpos($current_page, 'civ_news.php') !== false ? 'active' : ''; ?>">News</a>
            <a href="<?php echo $base_url; ?>/views/contact/contact.php" class="<?php echo strpos($current_page, 'contact.php') !== false ? 'active' : ''; ?>">Contact</a>
            <a href="<?php echo $base_url; ?>/views/about/about.php" class="<?php echo strpos($current_page, 'about.php') !== false ? 'active' : ''; ?>">About</a>

            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                <a href="<?php echo $base_url; ?>/views/news/news.php" class="<?php echo strpos($current_page, 'news.php') !== false ? 'active' : ''; ?>"> Add News</a>
                <a href="<?php echo $base_url; ?>/views/storage/storage.php" class="<?php echo strpos($current_page, 'storage.php') !== false ? 'active' : ''; ?>">View Stock</a>
                <a href="<?php echo $base_url; ?>/views/storeManage/storeManage.php" class="<?php echo strpos($current_page, 'storeManage.php') !== false ? 'active' : ''; ?>">Storage Management</a>
                <a href="<?php echo $base_url; ?>/views/statistics/stats.php" class="<?php echo strpos($current_page, 'stats.php') !== false ? 'active' : ''; ?>">Statistics</a>
                <a href="<?php echo $base_url; ?>/views/addAccount/addAccount.php" class="<?php echo strpos($current_page, 'addAccount.php') !== false ? 'active' : ''; ?>">Add Account</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'rescuer') : ?>
                <a href="<?php echo $base_url; ?>/404.php" class="<?php echo strpos($current_page, 'rescuer_link1.php') !== false ? 'active' : ''; ?>">resc1</a>
                <a href="<?php echo $base_url; ?>/404.php" class="<?php echo strpos($current_page, 'rescuer_link2.php') !== false ? 'active' : ''; ?>">resc2</a>
            <?php endif; ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'civilian') : ?>
                <a href="<?php echo $base_url; ?>/404.php" class="<?php echo strpos($current_page, 'civ_link1.php') !== false ? 'active' : ''; ?>">Add things here only for civ</a>
            <?php endif; ?>

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
