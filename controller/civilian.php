<?php
include("../model/config.php");
?>

<?php


//      1. Account Creation
//TODO:

//      2. Login-Logout
//same as admin's, no implementation needed here

//      3. Request Handling
//TODO:

//      4. Announcements & Offers
//TODO:


?>
<?php
if (pg_close($dbconn)) {
    echo "Connection with db is now closed";
}
?>