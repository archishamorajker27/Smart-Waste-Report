<?php
session_name("ADMINSESS");
session_start();

include "db_connect.php";

$id = $_POST['id'];
$status = $_POST['status'];

$query = "UPDATE reports SET report_status='$status' WHERE id='$id'";
mysqli_query($conn, $query);

echo "success";
?>
