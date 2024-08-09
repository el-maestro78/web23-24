CREATE DATABASE webproject24;


CREATE TABLE users (
    civilian_id INT AUTO_INCREMENT PRIMARY KEY,
    civilian_username VARCHAR(50) NOT NULL UNIQUE,
    civilian_password VARCHAR(255) NOT NULL,
    civilian_full_name VARCHAR(100) NOT NULL,
    civilian_phone VARCHAR(15) NOT NULL,
    civilian_latitude FLOAT NOT NULL,
    civilian_longitude FLOAT NOT NULL
);


<?php

$host = 'localhost';
$db = 'webproject24';
$user = 'root'; 
$pass = '3289'; 


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Σφάλμα σύνδεσης στη βάση δεδομένων: " . $e->getMessage());
}

$civilians = [
    ['civilian_username' => 'user1', 'civilian_password' => 'password1', 'civilian_full_name' => 'Ioannis Papadopoulos', 'civilian_phone' => '19000000010', 'civilian_latitude' => 37.975, 'civilian_longitude' => 23.734],
    ['civilian_username' => 'user2', 'civilian_password' => 'password2', 'civilian_full_name' => 'Maria Ioannides', 'civilian_phone' => '19000000020', 'civilian_latitude' => 37.977, 'civilian_longitude' => 23.735],
    ['civilian_username' => 'user3', 'civilian_password' => 'password3', 'civilian_full_name' => 'Konstantinos Pappas', 'civilian_phone' => '19000000030', 'civilian_latitude' => 37.978, 'civilian_longitude' => 23.732],
    ['civilian_username' => 'user4', 'civilian_password' => 'password4', 'civilian_full_name' => 'Eleni Karagiannis', 'civilian_phone' => '19000000040', 'civilian_latitude' => 37.974, 'civilian_longitude' => 23.733],
    ['civilian_username' => 'user5', 'civilian_password' => 'password5', 'civilian_full_name' => 'Alexios Antoniou', 'civilian_phone' => '19000000050', 'civilian_latitude' => 37.976, 'civilian_longitude' => 23.736]
];




$sql = "INSERT INTO users (civilian_username, civilian_password, civilian_full_name, civilian_phone, civilian_latitude, civilian_longitude) VALUES (:civilian_username, :civilian_password, :civilian_full_name, :civilian_phone, :civilian_latitude, :civilian_longitude)";
$stmt = $pdo->prepare($sql);


foreach ($civilians as $civilian) {
    
    $hashedPassword = civilian_password_hash($civilian['civilian_password'], PASSWORD_BCRYPT);

    $stmt->execute([
        ':civilian_username' => $civilian['civilian_username'],
        ':civilian_password' => $hashedPassword,
        ':civilian_full_name' => $civilian['civilian_full_name'],
        ':civilian_phone' => $civilian['civilian_phone'],
        ':civilian_latitude' => $civilian['civilian_latitude'],
        ':civilian_longitude' => $civilian['civilian_longitude']
    ]);

    echo "The account of " . $civilian['civilian_full_name'] . "has successfully created.<br>";
}

echo "All accounts have successfully created.";

?>