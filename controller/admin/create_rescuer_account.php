<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";


$name = validate_input($_POST['name']);
$surname = validate_input($_POST['surname']);
$username = validate_input($_POST['username']);
$pass = validate_input($_POST['pass']);
$email = validate_input($_POST['email']);
$phone = validate_input($_POST['phone']);
//$long = validate_input($_POST['long']);
//$lat = validate_input($_POST['lat']);
$query = "INSERT INTO dbUser(first_name, surname, username, pass, is_resc, email, phone) 
    VALUES ($1, $2, $3, crypt($4, gen_salt('bf')), TRUE, $5, $6)";
$result = pg_prepare($dbconn, "insert_query", $query);

if ($result) {
    // Execute the prepared statement with actual values
    $result = pg_execute($dbconn, "insert_query", array($name, $surname, $username, $pass, $email, $phone));
    if ($result) {
        echo json_encode(['created' => true]);
    } else {
        // Error details can be useful for debugging
        echo json_encode(['created' => false, 'error' => pg_last_error($dbconn)]);
    }
} else {
    // Error details if preparing the query fails
    echo json_encode(['created' => false, 'error' => pg_last_error($dbconn)]);
}

