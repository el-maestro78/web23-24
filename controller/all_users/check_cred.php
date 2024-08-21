<?php
include("../../model/config.php");
include("../../aux.php");
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
            long ,
            lat
        FROM dbUser 
        WHERE email = $email AND password = $password";
$result = pg_query($dbconn, $query);

if ($result && pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);
    $_SESSION['user_id']=$row['user_id'];
    $_SESSION['first_name']=$row['first_name'];
    $_SESSION['surname']=$row['surname'];
    $_SESSION['username']=$row['username'];
    $_SESSION['is_resc']=$result['is_resc'];
    $_SESSION['is_admin']=$result['is_admin'];
    $_SESSION['email']=$result['email'];
    $_SESSION['phone']=$result['phone'];
    $_SESSION['long']=$result['long'];
    $_SESSION['lat']=$result['lat'];

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

/*
     echo json_encode([
            'exists' => true,
            'user_id' => $result['user_id'],
            'first_name' => $result['first_name'],
            'surname' => $result['surname'],
            'username' => $result['username'],
            'is_resc' => $result['is_resc'],
            'is_admin' => $result['is_admin'],
            'email' => $result['email'],
            'phone' => $result['phone'],
            'long' => $result['long'],
            'lat' => $result['lat']
        ]);
 */