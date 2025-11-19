<?php
session_name("USERSESS");
session_start();
include "db_connect.php";

// USER MUST BE LOGGED IN
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// FETCH ONLY THIS USER'S REPORTS
$query = "SELECT * FROM reports WHERE user_id='$user_id' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Reports</title>
    <link rel="stylesheet" href="css/my_reports.css">
</head>

<body>

<a href="user_dashboard.php" class="back-btn">← Back</a>

<div class="container">

    <h2 class="heading">My Reports</h2>

    <?php 
    if (mysqli_num_rows($result) == 0) {
        echo "<p class='no-report'>You have not submitted any reports yet.</p>";
    }

    while ($row = mysqli_fetch_assoc($result)) { 
    ?>

    <div class="report-box">

        <b>Report ID:</b> <?= $row['id'] ?><br><br>

        <?php if (!empty($row['image'])) { ?>
            <img src="uploads/<?= $row['image'] ?>" class="report-img">
        <?php } ?>

        <b>Waste Type:</b> <?= $row['waste_type'] ?><br>
        <b>Address:</b> <?= $row['address'] ?><br>
        <b>Notes:</b> <?= $row['notes'] ?><br><br>

        <b>Status:</b> 
        <?php if ($row['report_status'] == 'pending') { ?>
            <span class="pending">Pending</span>
        <?php } elseif ($row['report_status'] == 'underprocess') { ?>
            <span class="under">Under Process</span>
        <?php } elseif ($row['report_status'] == 'resolved') { ?>
            <span class="resolved">Resolved</span>
        <?php } ?>

        <?php if (!empty($row['resolved_image'])) { ?>
            <br><br>
            <b>Resolved Image:</b><br>
            <img src="uploads/<?= $row['resolved_image'] ?>" class="report-img">
        <?php } ?>

    </div>

    <?php } ?>

</div>

</body>
</html>
