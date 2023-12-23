<?php
include("../../model/config.php");
?>
<?php
//session_start();
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
    $query = "SELECT * FROM dbuser WHERE username = $1 AND pass = $2";
    $result = pg_query_params($dbconn, $query, array($typed_username, $typed_password));

    if ($result && pg_num_rows($result) > 0) {
        // Authentication successful
        $_SESSION["username"] = $typed_username;
        header("Location: ../../views/Teo_testing/helloworld.php"); // Redirect to the dashboard or another page
        exit();
    } else {
        $error_message = "Invalid username or password";
    }
}
?>

<?php
include("../../model/dbclose.php");
?>