<?php
include '../../model/config.php';
include '../../ini.php';
include '../../auxiliary.php';

$offer_id = validate_input($_POST['offer_id']);
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    echo json_encode(['removed' => false, 'error' => 'User logged out']);
    exit;
}

$query = <<< EOF
        DELETE FROM offers WHERE off_id = $1;
EOF;

$result = pg_prepare($dbconn, "offer_remove_query", $query);
if (!$result) {
    echo json_encode(['removed' => false, 'error' => pg_last_error($dbconn)]);
    exit;
}

$final = pg_execute($dbconn, "offer_remove_query", array($offer_id));
if (!$final) {
    echo json_encode(['removed' => false, 'error' => pg_last_error($dbconn)]);
    include '../../model/dbclose.php';
    exit;
}

echo json_encode(['removed' => true]);

include '../../model/dbclose.php';

