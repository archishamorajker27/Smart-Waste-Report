<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Help - Smart Waste Report</title>
    <link rel="stylesheet" href="css/help.css">
</head>

<body>

<a href="user_dashboard.php" class="back-btn">← Back</a>

<div class="container">

    <h1 class="main-title">Help & User Guidelines</h1>

    <p>
        Welcome to the Smart Waste Report Help Section. This guide will explain how to report 
        waste issues, track progress, and understand how your report is resolved by the 
        administration.
    </p>

    <h2 class="heading">🗑️ How to Report Waste</h2>
    <p>
        Reporting waste is simple and quick using the Smart Waste Report system. Follow the steps below:
    </p>

    <ul class="list">
        <li>Go to the <b>Report Waste</b> section from the menu.</li>
        <li>Upload a <b>clear photo</b> of the waste or garbage issue.</li>
        <li>Select the correct <b>waste type</b> from the dropdown menu.</li>
        <li>Use the map to <b>mark the exact location</b> or type the address manually.</li>
        <li>Add any additional <b>notes</b> (optional).</li>
        <li>Submit the report.</li>
    </ul>

    <h2 class="heading">🕒 After You Submit a Report</h2>
    <p>
        Once your report is submitted, it is stored in the system and visible to the admin for review.
        Each report goes through the following stages:
    </p>

    <ul class="list">
        <li><b>Pending:</b> Your report has been received and is waiting for admin review.</li>
        <li><b>Under Process:</b> The admin has reviewed your report and assigned it for cleaning.</li>
        <li><b>Resolved:</b> The issue has been cleaned and the admin uploads a <b>proof image</b> of the cleanup.</li>
    </ul>

    <h2 class="heading">📍 How to Track Your Report</h2>
    <p>
        You can easily track your reports by visiting the <b>My Reports</b> section.  
        It shows:
    </p>

    <ul class="list">
        <li>Report ID</li>
        <li>Your uploaded image</li>
        <li>Waste type and location</li>
        <li>Current status (Pending / Under Process / Resolved)</li>
        <li>Cleanup proof image when resolved</li>
    </ul>

    <h2 class="heading">💡 Tips for Better Reporting</h2>
    <ul class="list">
        <li>Make sure the photo is clear and captures the full waste area.</li>
        <li>Use correct waste category to assist in planning cleanup.</li>
        <li>Mark the location accurately on the map.</li>
        <li>Provide additional details if the waste is hazardous or spreading.</li>
    </ul>

    <h2 class="heading">📧 Contact & Support</h2>

    <div class="contact-box">
        <span class="mail-icon">✉️</span>
        <p class="email-text">support@smartwaste.com</p>
    </div>

</div>

</body>
</html>
