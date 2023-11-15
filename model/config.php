<?php
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbPass = $_ENV['PASS'];
try {
    $db_handle = pg_connect("host=localhost dbname=webproject24 user=postgres password= $dbPass");
    $stat = pg_connection_status($db_handle);

    if ($stat === PGSQL_CONNECTION_OK){
        echo 'Connection attempt succeeded.';
    } else {
        throw new Exception("Can't connect with database");
    }
}catch(Exception $e){
    echo $e->getMessage();
}
?>
