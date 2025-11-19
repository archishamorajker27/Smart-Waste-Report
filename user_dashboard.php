<?php
session_name("USERSESS");
session_start();

// If not logged in → redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/user_dashboard.css">
</head>
<body>

<div class="bg"></div>


<!-- NAVIGATION BAR -->
<nav class="top-nav">
    <ul>
        <li><a href="user_dashboard.php">Home</a></li>
        <li><a href="report_waste.php">Report Waste</a></li>
        <li><a href="my_reports.php">My Reports</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="help.php">Help</a></li>

        <!-- RIGHT SIDE NAV ITEMS -->
        <li class="logout-nav"><a href="logout.php">Logout</a></li>

        <!-- PROFILE DROPDOWN -->
<li class="profile-nav" id="profileNav">
    <button id="profileBtn" class="profile-btn" aria-expanded="false" aria-haspopup="true">
        Profile ▾
    </button>

    <div class="profile-dropdown" id="profileDropdown" role="menu" aria-hidden="true">
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></p>
        <p><strong>Email:</strong>
    <?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : "Not available"; ?>
</p>

        <hr style="border-color: rgba(255,255,255,0.08);">
        <a href="edit_profile.php" class="profile-link">Edit Profile</a><br>
        
    </div>
</li>

    </ul>
</nav>


<div class="dashboard-container">
    <h2>Hi, <?php echo $user_name; ?>! </h2>
    <h2>Welcome to SMART WASTE REPORT</h2>

  <div class="map-section">
    <h3 class="map-title">Cleanest States of India</h3>

    <div class="map-box">
        <img src="images/india_clean_states.jpg" alt="Cleanest States Map">
    </div>
  </div>

</div>

<script>
(function() {
    const profileBtn = document.getElementById('profileBtn');
    const profileNav = document.getElementById('profileNav');
    const profileDropdown = document.getElementById('profileDropdown');

    if (!profileBtn || !profileNav || !profileDropdown) return;

    function openDropdown() {
        profileNav.classList.add('open');
        profileBtn.setAttribute('aria-expanded', 'true');
        profileDropdown.setAttribute('aria-hidden', 'false');
    }

    function closeDropdown() {
        profileNav.classList.remove('open');
        profileBtn.setAttribute('aria-expanded', 'false');
        profileDropdown.setAttribute('aria-hidden', 'true');
    }

    function toggleDropdown() {
        if (profileNav.classList.contains('open')) closeDropdown();
        else openDropdown();
    }

    profileBtn.addEventListener('click', function(e) {
        e.stopPropagation(); // don't let click bubble to document
        toggleDropdown();
    });

    // Clicking inside the dropdown should not close it
    profileDropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Close when clicking anywhere else
    document.addEventListener('click', function() {
        closeDropdown();
    });

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.key === 'Esc') {
            closeDropdown();
            profileBtn.focus();
        }
    });
})();
</script>

</body>
</html>
