<?php
//should we use this?
/*if (!$db) {
    die("Error in connection: " . pg_last_error());
}*/
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
    $typed_username = $_POST["username"];
    $typed_password = $_POST["password"];

    // Validate the user against the database
    $query = <<<EOF
    "SELECT * FROM users 
    WHERE username = '{$username}' AND password = '{$password}'";  
    EOF; // same as $sql EOF?
    $result = pg_query($db, $query);

    if ($result && pg_num_rows($result) > 0) {
        // Authentication successful
        $_SESSION["username"] = $username;
        header("Location: dashboard.php"); // Redirect to the dashboard or another page
        exit();
    } else {
        $error_message = "Invalid username or password";
    }
}
?>

<?php
include("../model/dbclose.php");
?>