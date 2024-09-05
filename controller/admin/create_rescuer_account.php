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

$if_email_exists_query = 'SELECT username FROM dbUser WHERE email = $1';
$check_if_email_exists = pg_query_params($dbconn, $if_email_exists_query, array($email));

$if_username_exists_query = 'SELECT email FROM dbUser WHERE username = $1';
$check_if_username_exists = pg_query_params($dbconn, $if_username_exists_query, array($username));
if (!$check_if_email_exists || !$check_if_username_exists) {
    echo json_encode(['created' => false, 'error' => pg_last_error($dbconn)]);
    exit;
}
if (pg_num_rows($check_if_email_exists) > 0){
        echo json_encode(['created' => false, 'email_exists' => true]);
        exit;
}
if (pg_num_rows($check_if_username_exists) > 0){
    echo json_encode(['created' => false, 'username_exists' => true]);
    exit;
}

$query = "INSERT INTO dbUser(first_name, surname, username, pass, is_resc, email, phone) 
    VALUES ($1, $2, $3, crypt($4, gen_salt('bf')), TRUE, $5, $6)";
$result = pg_prepare($dbconn, "insert_query", $query);

if ($result) {
    $result = pg_execute($dbconn, "insert_query", array($name, $surname, $username, $pass, $email, $phone));
    if ($result) {
        echo json_encode(['created' => true]);
    } else {
        echo json_encode(['created' => false, 'email_exists' => false, 'username_exists' => false, 'error' => pg_last_error($dbconn)]);
    }
} else {
    echo json_encode(['created' => false, 'email_exists' => false, 'username_exists' => false, 'error' => pg_last_error($dbconn)]);
}

