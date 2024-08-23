<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="icon" href="../../views/favico/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <?php
        include '../../ini.php';
        include '../../check_login.php';
        include '../../views/toolbar.php';
        echo 'Session Data<br/>';
        echo 'User ID: ' . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Not set') . '<br/>';
        echo 'First Name: ' . (isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Not set') . '<br/>';
        echo 'Surname: ' . (isset($_SESSION['surname']) ? $_SESSION['surname'] : 'Not set') . '<br/>';
        echo 'Username: ' . (isset($_SESSION['username']) ? $_SESSION['username'] : 'Not set') . '<br/>';
        echo 'Is Rescuer: ' . (isset($_SESSION['is_resc']) ? $_SESSION['is_resc'] : 'Not set') . '<br/>';
        echo 'Is Admin: ' . (isset($_SESSION['is_admin']) ? $_SESSION['is_admin'] : 'Not set') . '<br/>';
        echo 'Email: ' . (isset($_SESSION['email']) ? $_SESSION['email'] : 'Not set') . '<br/>';
        echo 'Phone: ' . (isset($_SESSION['phone']) ? $_SESSION['phone'] : 'Not set') . '<br/>';
        echo 'Longitude: ' . (isset($_SESSION['long']) ? $_SESSION['long'] : 'Not set') . '<br/>';
        echo 'Latitude: ' . (isset($_SESSION['lat']) ? $_SESSION['lat'] : 'Not set') . '<br/>';


        /*
echo $_SESSION['user_id'] . '<br/>';
echo $_SESSION['first_name'] . '<br/>';
echo $_SESSION['surname'] . '<br/>';
echo $_SESSION['username'] . '<br/>';
echo $_SESSION['is_resc'] . '<br/>';
echo $_SESSION['is_admin'] . '<br/>';
echo $_SESSION['email'] . '<br/>';
echo $_SESSION['phone'] . '<br/>';
echo $_SESSION['long'] . '<br/>';
echo $_SESSION['lat'] . '<br/>';
 */
        ?>
    </body>
</html>