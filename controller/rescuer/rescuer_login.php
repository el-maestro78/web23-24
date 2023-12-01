<?php
// 1. Login-Logout
//same as admin's, no implementation needed here
$typed_username;
$typed_password;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["typed_username"])){
        echo "Username is required";
    } elseif (empty($_POST["typed_password"])) {
        echo "Password is required";
    } else {
        $username = validate_input($_POST["typed_username"]);
        $password = validate_input($_POST["typed_password"]);
    }
    function validate_input($data)
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
        echo "Logged in";
    }
}
?>

<?php
include("../model/dbclose.php");
?>