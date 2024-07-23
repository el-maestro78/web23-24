<?php
if (!pg_close($dbconn)) {
    echo "Error with closing the connection";
}
?>