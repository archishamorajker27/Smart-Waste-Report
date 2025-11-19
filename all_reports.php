<?php
session_name("ADMINSESS");
session_start();

include "db_connect.php";

// Fetch reports by status
$pending   = mysqli_query($conn, "SELECT * FROM reports WHERE report_status='pending'");
$underproc = mysqli_query($conn, "SELECT * FROM reports WHERE report_status='underprocess'");
$resolved  = mysqli_query($conn, "SELECT * FROM reports WHERE report_status='resolved'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Reports</title>
    <link rel="stylesheet" href="css/all_reports.css">
</head>

<body>

<a href="admin_dashboard.php" class="back-btn">← Back</a>

<div class="tabs">
    <button class="tab-btn active" onclick="showTab('pendingTab')">Pending</button>
    <button class="tab-btn" onclick="showTab('underTab')">Under Process</button>
    <button class="tab-btn" onclick="showTab('resolvedTab')">Resolved</button>
</div>


<!-- -------------------- PENDING TAB -------------------- -->
<div id="pendingTab" class="tab-content">
    <h2 class="heading">Pending Reports</h2>

    <?php while ($row = mysqli_fetch_assoc($pending)) { ?>
        <div class="report-box">

            <b>ID:</b> <?= $row['id'] ?><br>
            <b>Waste:</b> <?= $row['waste_type'] ?><br>
            <b>Address:</b> <?= $row['address'] ?><br>
            <b>Status:</b> <?= $row['report_status'] ?><br><br>

            <button class="status-btn under-btn"
                onclick="updateStatus(<?= $row['id'] ?>, 'underprocess')">
                Mark Under Process
            </button>

            <button class="status-btn res-btn"
                onclick="openUploadBox(<?= $row['id'] ?>)">
                Mark Resolved
            </button>

        </div>
    <?php } ?>
</div>



<!-- -------------------- UNDER PROCESS TAB -------------------- -->
<div id="underTab" class="tab-content hidden">
    <h2 class="heading">Under Process</h2>

    <?php while ($row = mysqli_fetch_assoc($underproc)) { ?>
        <div class="report-box">

            <b>ID:</b> <?= $row['id'] ?><br>
            <b>Waste:</b> <?= $row['waste_type'] ?><br>
            <b>Address:</b> <?= $row['address'] ?><br>
            <b>Status:</b> <?= $row['report_status'] ?><br><br>

            <button class="status-btn res-btn"
                onclick="openUploadBox(<?= $row['id'] ?>)">
                Mark Resolved
            </button>

        </div>
    <?php } ?>
</div>



<!-- -------------------- RESOLVED TAB -------------------- -->

<div id="resolvedTab" class="tab-content hidden">
    <h2 class="heading">Resolved Reports</h2>
    <?php while ($row = mysqli_fetch_assoc($resolved)) { ?>
        <div class="report-box">
            <b>ID:</b> <?= $row['id'] ?><br>
            <b>Waste:</b> <?= $row['waste_type'] ?><br>
            <b>Address:</b> <?= $row['address'] ?><br>
            <b>Status:</b> <?= $row['report_status'] ?><br><br>

            <?php if (!empty($row['resolved_image'])) { ?>
                <b>Resolved Photo:</b><br>
                <img src="uploads/<?= $row['resolved_image'] ?>" class="resolved-img"><br><br>
            <?php } else { ?>
                <p>No resolved photo uploaded.</p>
            <?php } ?>

            <button class="status-btn reupload-btn"
                    onclick="openUploadBox(<?= $row['id'] ?>)">
                Upload Again
            </button>

        </div>
    <?php } ?>
</div>



<!-- -------------------- JS TAB CONTROL -------------------- -->
<script>
function showTab(tabId) {
    document.querySelectorAll(".tab-content").forEach(t => t.classList.add("hidden"));
    document.getElementById(tabId).classList.remove("hidden");

    document.querySelectorAll(".tab-btn").forEach(btn => btn.classList.remove("active"));
    event.target.classList.add("active");
}


// Update status (for "Mark Under Process")
function updateStatus(id, newStatus) {
    let formData = new FormData();
    formData.append("id", id);
    formData.append("status", newStatus);

    fetch("update_status.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.text())
    .then(result => {
        if (result.trim() === "success") {
            alert("Status Updated!");
            location.reload();
        }
    });
}
</script>



<!-- -------------------- UPLOAD POPUP -------------------- -->
<div id="uploadPopup" class="upload-popup hidden">
    <div class="popup-content">
        <h3>Upload Resolution Photo</h3>

        <form id="uploadForm" enctype="multipart/form-data">
            <input type="hidden" id="report_id" name="id">

            <input type="file" name="resolved_photo" required><br><br>

            <button type="button" onclick="submitPhoto()" class="upload-btn">Submit</button>
            <button type="button" onclick="closeUploadBox()" class="close-btn">Cancel</button>
        </form>
    </div>
</div>



<!-- -------------------- UPLOAD JS -------------------- -->
<script>
function openUploadBox(id) {
    document.getElementById("report_id").value = id;
    document.getElementById("uploadPopup").classList.remove("hidden");
}

function closeUploadBox() {
    document.getElementById("uploadPopup").classList.add("hidden");
}

function submitPhoto() {
    let formData = new FormData(document.getElementById("uploadForm"));

    fetch("upload_resolved_image.php", {
        method: "POST",
        body: formData
    })
    .then(r => r.text())
    .then(res => {
        if (res.trim() === "success") {
            alert("Report marked as resolved with photo!");
            location.reload();
        } else {
            alert("Upload failed.");
        }
    });
}
</script>


</body>
</html>
