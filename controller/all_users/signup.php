<?php
include("../../model/config.php");
include("../../ini.php");

/*
 * FOR sign in
 */

$email = validate_input($_POST['email']);
$password = validate_input($_POST['password']);

$query = "
        SELECT
        user_id,
        first_name,
        surname,
        username,
        pass,
        is_resc,
        is_admin,
        email,
        phone,
        long,
        lat FROM dbUser WHERE email = $1 AND pass = $2";
$result = pg_query_params($dbconn, $query, array($email, $password));
if (!$result) {
    echo json_encode(['exists' => false, 'error' => pg_last_error($dbconn)]);
    exit;
}
if (pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);

    echo json_encode(['exists' => true]);
} else {
    echo json_encode(['exists' => false]);
}
