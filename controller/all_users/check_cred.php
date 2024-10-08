<?php
include("../../model/config.php");
include("../../auxiliary.php");
$input = json_decode(file_get_contents('php://input'), true);
$username = validate_input($input['username']);
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
        lat FROM dbUser WHERE username = $1 AND pass = crypt($2, pass)";
$result = pg_query_params($dbconn, $query, array($username, $password));
if (!$result) {
    echo json_encode(['exists' => false, 'error' => pg_last_error($dbconn)]);
    exit;
}
if (pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);
    session_start();
    $GLOBALS['logged_in'] = true;
    $_SESSION['logged_in'] = true;
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

    if($_SESSION['is_resc']=='t'){
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
