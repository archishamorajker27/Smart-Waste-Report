<?php
session_name("USERSESS");
session_start();
include "db_connect.php";

$wasteTypes = $_POST["waste_types"];
$otherWaste = $_POST["other_waste"];

if (!empty($otherWaste)) {
    $wasteTypes .= ", " . $otherWaste;
}

$address = $_POST["address"];
$notes = $_POST["notes"];

$uploadDir = "uploads/";
if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

$imgName = uniqid() . "_" . $_FILES["waste_image"]["name"];
$path = $uploadDir . $imgName;

move_uploaded_file($_FILES["waste_image"]["tmp_name"], $path);

$sql = "INSERT INTO reports (waste_type, address, notes, image_path, status)
        VALUES (?, ?, ?, ?, 'pending')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $wasteTypes, $address, $notes, $path);
$stmt->execute();

header("Location: user_dashboard.php?report=success");
exit;
?>
