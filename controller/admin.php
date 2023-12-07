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
    //} elseif (empty($_POST["password"])) { // Maybe for 
    //   echo "Password is required";
    } else {
        $username = validate_input($_POST["username"]);
        $password = validate_input($_POST["password"]);
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