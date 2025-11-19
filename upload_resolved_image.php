<?php
session_name("ADMINSESS");
session_start();

include "db_connect.php";

if (!isset($_POST['id'])) {
    echo "error";
    exit;
}

$report_id = $_POST['id'];

if (isset($_FILES['resolved_photo']) && $_FILES['resolved_photo']['error'] == 0) {

    $fileName = time() . "_" . basename($_FILES["resolved_photo"]["name"]);
    $targetPath = "uploads/" . $fileName;

    // Move file to uploads folder
    if (move_uploaded_file($_FILES["resolved_photo"]["tmp_name"], $targetPath)) {

        // Update database with photo name + set status resolved
        $query = "UPDATE reports 
                  SET resolved_image='$fileName', report_status='resolved' 
                  WHERE id='$report_id'";

        if (mysqli_query($conn, $query)) {
            echo "success";
        } else {
            echo "db_error";
        }

    } else {
        echo "upload_error";
    }

} else {
    echo "no_file";
}
?>
