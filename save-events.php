<?php
include_once 'dbconnect.php';

$eventId = $_GET['eventid'];

    mysqli_query($conn, "UPDATE events SET saved='1' WHERE eventID='$eventId' AND saved='0'") or die(mysqli_error());
    echo "success";

?>