<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="icon" href="./favico/favicon.ico" type="image/x-icon">
        <title>Volunteers for Natural Disasters</title>
    </head>
    <style>
        .out-container {
            background-color: #790e0e;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }
        .in-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;

            width: 50%;
        }
        img {
            max-width: 200px;
            height: auto;
            margin-top: 2px;
        }
    </style>
    <body>
        <?php
        include '../ini.php';
        include '../check_login.php';
        include './toolbar.php';
        ?>
        <script>

        </script>
        <div class="out-container">
            <div class="in-container">
                <img src="favico/rescue_logo.png" alt="Volunteer's Page Logo">
                <h2> Volunteers for Natural Disasters </h2>
                <p> Welcome to our platform, <?= $_SESSION['first_name']?>!
                    <?php if($_SESSION['role']=='rescuer') :?>
                        Thanks for your service. Look in the map for active tasks
                    <?php elseif ($_SESSION['role'] == 'civilian') : ?>
                        You can navigate through the bar on the top. For Requests go to...
                    <?php else : ?>
                        You 're an admin
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </body>
</html>