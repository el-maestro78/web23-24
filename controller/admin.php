<?php
    include("../model/config.php");
?>

<?php
//      1. Login–Logout
//TODO:
$username;
$password;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])){
        echo "Name is required";
    } elseif (empty($_POST["password"])) {
        echo "Password is required";
    } else {
        $username = test_input($_POST["username"]);
        $password = test_input($_POST["password"]);
    }
    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $sql = <<<EOF
      SELECT username, pass 
      FROM dbUser 
      WHERE username={$username} AND pass={$password};
    EOF;
    if(pg_num_rows($dbconn, $sql) > 0){
        echo "logged in";
    }
}
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
    include("../model/dbclose.php");
?>