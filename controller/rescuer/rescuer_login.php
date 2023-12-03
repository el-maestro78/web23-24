<?php
session_start();
// 1. Login-Logout
//same as admin's, no implementation needed here
$typed_username = $_POST["username"];
$typed_password = $_POST["password"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //empty() can be replpaced from required in frontend
    /*if (empty($typed_username)){ 
        echo "Username is required";
    } elseif (empty($typed_password)) {
        echo "Password is required";
    } else {
        $username = validate_input($typed_username);
        $password = validate_input($typed_password);
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
      WHERE username={$typed_username} AND pass={$typed_password};
    EOF;
    if(pg_num_rows($dbconn, $sql) > 0){
        echo "Logged in";
    }*/
}
?>

<?php
include("../model/dbclose.php");
?>