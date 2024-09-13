<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="icon" href="../../views/favico/favicon.ico" type="image/x-icon">
        <title>Session Data</title>
    </head>
    <style>
        .session_data{
            display: flex;
            justify-content: center;
        }
    </style>
    <body>
        <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../../views/toolbar.php';
        function check_bool($str): string
        {
            if($str ==='t'){
                return 'Yes';
            }
            else{
                return 'No';
            }
        }

        echo '<div class="session_data"><h1><b>Session Data</b></h1><br/></div>';
        echo '<div class="session_data"><b>User ID: </b>&nbsp'  . ($_SESSION['user_id'] ?? 'Not set') . '<br/></div>';
        echo '<div class="session_data"><b>First Name: </b>&nbsp' . ($_SESSION['first_name'] ?? 'Not set') . '<br/></div>';
        echo '<div class="session_data"><b/>Surname: </b>&nbsp' . ($_SESSION['surname'] ?? 'Not set') . '<br/></div>';
        echo '<div class="session_data"><b>Username: </b>&nbsp' . ($_SESSION['username'] ?? 'Not set') . '<br/></div>';
        echo '<div class="session_data"><b>Is Rescuer: </b>&nbsp' . (isset($_SESSION['is_resc']) ? check_bool($_SESSION['is_resc']) : 'Not set') . '<br/></div>';
        echo '<div class="session_data"><b>Is Admin: </b>&nbsp' . (isset($_SESSION['is_admin']) ? check_bool($_SESSION['is_admin']) : 'Not set') . '<br/></div>';
        echo '<div class="session_data"><b>Email: </b>&nbsp' . ($_SESSION['email'] ?? 'Not set') . '<br/></div>';
        echo '<div class="session_data"><b>Phone: </b>&nbsp' . ($_SESSION['phone'] ?? 'Not set') . '<br/></div>';
        echo '<div class="session_data"><b>Longitude: </b>&nbsp' . ($_SESSION['long'] ?? 'Not set') . '<br/></div>';
        echo '<div class="session_data"><b>Latitude: </b>&nbsp' . ($_SESSION['lat'] ?? 'Not set') . '<br/></div>';
        ?>
    </body>
</html>