<?php
include("../../model/config.php");

$query = "SELECT 
            off_id, 
            pending, 
            completed, 
            quantity, 
            reg_date, 
            assign_date, 
            user_id, 
            item_id, 
            lat, 
            long 
            FROM offers
            WHERE completed = 'FALSE'";
$result = pg_query($dbconn, $query);

if (!$result) {
    die("Error in SQL query: " . pg_last_error());
}

$offers = array();
while ($row = pg_fetch_assoc($result)) {
    $offers[] = $row;
}

//header('Content-Type: application/json');
echo json_encode($offers);

pg_free_result($result);

?>
<?php
include("../../model/dbclose.php");
?>