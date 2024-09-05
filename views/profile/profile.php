<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="icon" href="../../views/favico/favicon.ico" type="image/x-icon">
        <title>Session Data</title>
    </head>
    <body>
        <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../../views/toolbar.php';
        echo '<b>Session Data</b><br/>';
        echo '<b>User ID: </b>' . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Not set') . '<br/>';
        echo '<b>First Name: </b>' . (isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Not set') . '<br/>';
        echo '<b/>Surname: </b>' . (isset($_SESSION['surname']) ? $_SESSION['surname'] : 'Not set') . '<br/>';
        echo '<b>Username: </b>' . (isset($_SESSION['username']) ? $_SESSION['username'] : 'Not set') . '<br/>';
        echo '<b>Is Rescuer: </b>' . (isset($_SESSION['is_resc']) ? $_SESSION['is_resc'] : 'Not set') . '<br/>';
        echo '<b>Is Admin: </b>' . (isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : 'Not set') . '<br/>';
        echo '<b>Email: </b>' . (isset($_SESSION['email']) ? $_SESSION['email'] : 'Not set') . '<br/>';
        echo '<b>Phone: </b>' . (isset($_SESSION['phone']) ? $_SESSION['phone'] : 'Not set') . '<br/>';
        echo '<b>Longitude: </b>' . (isset($_SESSION['long']) ? $_SESSION['long'] : 'Not set') . '<br/>';
        echo '<b>Latitude: </b>' . (isset($_SESSION['lat']) ? $_SESSION['lat'] : 'Not set') . '<br/>';
        ?>
    </body>
</html>