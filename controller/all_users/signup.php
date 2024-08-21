<?php
include("../../model/config.php");
include("../../ini.php");

/*
 * FOR sign in
 */

$input = json_decode(file_get_contents('php://input'), true);
$email = validate_input($input['email']);
$password = validate_input($input['password']);

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
    $_SESSION['user_id']=$row['user_id'];
    $_SESSION['first_name']=$row['first_name'];
    $_SESSION['surname']=$row['surname'];
    $_SESSION['username']=$row['username'];
    $_SESSION['is_resc']=$row['is_resc'];
    $_SESSION['is_admin']=$row['is_admin'];
    $_SESSION['email']=$row['email'];
    $_SESSION['phone']=$row['phone'];
    $_SESSION['long']=$row['long'];
    $_SESSION['lat']=$row['lat'];

    if($_SESSION['is_resc']==='t'){
        $_SESSION['role']='rescuer';
    }else if($_SESSION['is_admin']==='t'){
        $_SESSION['role']='admin';
    }else{
        $_SESSION['role']='civilian';
    }

    echo json_encode(['exists' => true]);
} else {
    echo json_encode(['exists' => false]);
}
