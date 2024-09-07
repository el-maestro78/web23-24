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
$vehicle = validate_input($_POST['vehicle']);

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

pg_query($dbconn, "BEGIN");

$query = "INSERT INTO dbUser(first_name, surname, username, pass, is_resc, email, phone) 
    VALUES ($1, $2, $3, crypt($4, gen_salt('bf')), TRUE, $5, $6) RETURNING user_id";

$result = pg_prepare($dbconn, "insert_query", $query);

if ($result) {
    $final = pg_execute($dbconn, "insert_query", array($name, $surname, $username, $pass, $email, $phone));

    if ($final) {
        $row = pg_fetch_assoc($final);
        $user_id = $row['user_id'];
        $combined = combine_veh_rescuers($vehicle, $user_id);
        if ($combined) {
            pg_query($dbconn, "COMMIT");
            echo json_encode(['created' => true]);
            exit;
        } else {
            pg_query($dbconn, "ROLLBACK");
            echo json_encode(['created' => false, 'error' => 'Failed to associate vehicle and rescuer']);
            exit;
        }
    } else {
        pg_query($dbconn, "ROLLBACK");
        echo json_encode(['created' => false, 'error' => pg_last_error($dbconn)]);
        exit;
    }
} else {
    pg_query($dbconn, "ROLLBACK");
    echo json_encode(['created' => false, 'error' => pg_last_error($dbconn)]);
    exit;
}

function combine_veh_rescuers($vehicle, $user_id): bool {
    global $dbconn;
    $query = "INSERT INTO vehicle_rescuers(veh_id, user_id) VALUES ($1, $2)";
    $result = pg_query_params($dbconn, $query, array($vehicle, $user_id));
    return (bool)$result;
}
