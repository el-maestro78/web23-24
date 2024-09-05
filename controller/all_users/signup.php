<?php
include "../../model/config.php";
include "../../ini.php";
include "../../auxiliary.php";

/*
 * FOR sign in
 */
/*
 *   emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const fnameInput = document.getElementById('fname');
    const lnameInput = document.getElementById('lname');
    const confPassInput = document.getElementById('conf_password');
    const countryInput = document.getElementById('country');
    const cityInput = document.getElementById('city');
    const streetInput= document.getElementById('street');
    const zcodeInput= document.getElementById('zcode');
    const phonenrInput = document.getElementById('phonenr');
    const submitButton = document.getElementById('submit');
 */


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

$query = "INSERT INTO dbUser(first_name, surname, username, pass, email, phone) 
    VALUES ($1, $2, $3, crypt($4, gen_salt('bf')), $5, $6)";
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

