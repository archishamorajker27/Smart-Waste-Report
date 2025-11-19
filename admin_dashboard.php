<?php
session_name("ADMINSESS");
session_start();
include "db_connect.php";

// Only allow admin
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Fetch card values
$totalReports = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM reports"))['total'];
$totalUsers   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM users"))['total'];
$pendingCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM reports WHERE report_status='pending'"))['total'];

// Fetch pending notifications
$pendingReports = mysqli_query($conn,
    "SELECT reports.*, users.name AS user_name
     FROM reports
     JOIN users ON reports.user_id = users.id
     WHERE reports.report_status='pending'
     ORDER BY reports.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/admin_dashboard.css">
</head>

<body>

<!-- TOP BAR -->
<div class="top-bar">
    <a class="top-btn logout-btn" href="logout.php">Logout</a>
    <a class="top-btn right-btn" href="all_reports.php">All Reports</a>
</div>

<!-- MAIN CONTAINER -->
<div class="container">

    <h2>Dashboard Cards</h2>

    <div class="card-box">
        <div class="card-item">
            <strong><?= $totalReports ?></strong><br>Total Reports
        </div>

        <div class="card-item">
            <strong><?= $totalUsers ?></strong><br>Total Users
        </div>

        <div class="card-item">
            <strong><?= $pendingCount ?></strong><br>Pending Reports
        </div>
    </div>

    <!-- Notification Button -->
    <div class="notif-center">
        <a class="notif-btn" onclick="toggleNotif()">Notifications (<?= $pendingCount ?>)</a>
    </div>

    <!-- Notification Box -->
    <div id="notifBox" class="notif-box">

        <div class="notif-header">
            <h3>Pending Reports</h3>
            <span class="notif-close" onclick="toggleNotif()">×</span>
        </div>

        <?php if (mysqli_num_rows($pendingReports) == 0) { ?>
            <p style="padding: 10px; color: #ccc;">No pending reports.</p>
        <?php } ?>

        <?php while ($row = mysqli_fetch_assoc($pendingReports)) { ?>
            <div class="report-box">
                <b>ID:</b> <?= $row['id'] ?><br>
                <b>User:</b> <?= $row['user_name'] ?><br>
                <b>Waste:</b> <?= $row['waste_type'] ?><br>
                <b>Status:</b> <span style="color:orange;">Pending</span>
            </div>
        <?php } ?>

    </div>

</div>

<!-- JS -->
<script>
function toggleNotif() {
    let box = document.getElementById("notifBox");
    box.style.display = (box.style.display === "block") ? "none" : "block";
}
</script>

</body>
</html>
