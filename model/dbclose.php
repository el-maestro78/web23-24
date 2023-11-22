<?php
if (pg_close($dbconn)) {
    echo "Connection with db is now closed";
}
?>