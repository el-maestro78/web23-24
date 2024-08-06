<?php
/*if (!pg_close($dbconn)) {
    echo "Error with closing the connection";
}*/
if (isset($dbconn) && $dbconn) {
    pg_close($dbconn);
    $dbconn = null; // Set to null to indicate the connection is closed
}
?>