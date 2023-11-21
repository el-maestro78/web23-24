<?php
include("../model/config.php");
?>

<?php


//      1. Login–Logout
//TODO:

//      2. Base Management
//TODO:

//      3. Map Managemnet
//TODO:

//      4. Map Filtering
//TODO:

//      5. Stock View
//TODO:

//      6. Statistics
//TODO:

//      7. Rescuer's Account Creation
//TODO:

//      8. Announcement Creation
//TODO:


?>
<?php
if(pg_close($dbconn)){
    echo "Connection with db is now closed";
}
?>