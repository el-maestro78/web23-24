<?php
session_start();
$typed_username = $_POST["username"];
$typed_password = $_POST["password"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /*
    function validate_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
   */
    $typed_username = $_POST["username"];
    $typed_password = $_POST["password"];

    // Validate the user against the database
    $sql = <<<EOF
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