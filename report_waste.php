<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Waste</title>
    <link rel="stylesheet" href="css/report_waste.css">
</head>
<body>

<a href="user_dashboard.php" class="back-btn">← Back</a>

<div class="report-container">

    <h2>Report Waste</h2>

    <form id="reportForm" method="POST" action="save_report.php" enctype="multipart/form-data">

        <!-- Upload Image -->
        <label>Upload Image</label>
        <input type="file" name="waste_image" id="wasteImage" accept="image/*" required>
        <img id="previewImg" class="previewImg" style="display:none;">

        <!-- Waste Type Dropdown -->
        <label>Waste Type</label>

        <div class="multi-select-dropdown">
            <button type="button" class="waste-btn" id="dropdownBtn">Select Waste Types ▼</button>

            <div class="dropdown-content" id="dropdownContent">
                <label><input type="checkbox" value="Plastic" class="wasteOption"> Plastic</label>
                <label><input type="checkbox" value="Glass" class="wasteOption"> Glass</label>
                <label><input type="checkbox" value="Organic" class="wasteOption"> Organic</label>
                <label><input type="checkbox" value="E-waste" class="wasteOption"> E-waste</label>

                <label><input type="checkbox" id="otherCheckbox"> Other</label>

                <input type="text" id="otherWasteInput" placeholder="Enter custom waste type">
            </div>

            <input type="hidden" name="waste_types" id="selectedWasteTypes">
            <input type="hidden" name="other_waste" id="otherWasteValue">
        </div>

        <!-- Address -->
        <label>Address</label>
        <input type="text" id="addressInput" name="address" required>

        <!-- Notes -->
        <label>Notes (Optional)</label>
        <textarea name="notes"></textarea>

        <button type="submit" class="btn">Submit Report</button>
    </form>
</div>

<script src="js/report_waste.js"></script>

</body>
</html>
