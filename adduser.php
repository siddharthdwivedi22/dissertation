<?php
require 'dbconnect.php';


$userId = $_GET['userid'];
$groupId = $_GET['groupid'];

mysqli_query($conn, "INSERT INTO member_groups(userID,groupID) VALUES ('$userId','$groupId')") or die(mysqli_error());
echo "success";

?>