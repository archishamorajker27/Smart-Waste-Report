<?php
session_start();
include "db_connect.php";

// If user already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: user_dashboard.php");
    exit;
}

// When form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email exists
    $check = $conn->prepare("SELECT id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "Email already exists. Please login!";
    } else {

        // Hash password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users(name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed);

        if ($stmt->execute()) {
            $success = "Signup successful! Redirecting to login...";
            header("refresh:2; url=login.php");
        } else {
            $error = "Something went wrong!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup - Smart Waste</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<a href="index.php" class="back-btn">← Back</a>

<div class="bg"></div>

<div class="login-container">
    <h2>Signup</h2>

    <?php if(isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>

    <?php if(isset($success)) { ?>
        <p style="color: lightgreen;"><?php echo $success; ?></p>
    <?php } ?>

    <form method="POST">

        <div class="input-box">
            <input type="text" name="name" placeholder="Full Name" required>
        </div>

        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-box password-wrapper">
            <input type="password" name="password" id="signupPassword" placeholder="Password" required>

            <span class="toggle-password" onclick="toggleSignupPassword()">
                <svg id="signupEyeOpen" class="eye-icon" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24">
                    <path fill="#ffffff"
                        d="M12 5C4.4 5 0 12 0 12s4.4 7 12 7 12-7 12-7-4.4-7-12-7zm0 12a5 5 0 110-10 5 5 0 010 10z" />
                </svg>

                <svg id="signupEyeClosed" class="eye-icon" style="display:none;"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="#ffffff"
                        d="M2 5.3l1.3 1.3C1.5 8.1 0 10 0 12s4.4 7 12 7c2.2 0 4.3-.5 6.1-1.3l1.3 1.3 1.4-1.4L3.4 3.9 2 5.3zM12 17c-5 0-8.8-4-9.8-5 1.3-1.3 2.6-2.5 4.2-3.3l1.6 1.6a5 5 0 006.6 6.6l1.6 1.6c-1.6.9-3.3 1.5-5.2 1.5z" />
                </svg>
            </span>
        </div>

        <button type="submit" class="login-btn">Create Account</button>

        <p class="signup-text">
            Already have an account? <a href="login.php">Login</a>
        </p>
    </form>
</div>

<script>
function toggleSignupPassword() {
    let pwd = document.getElementById("signupPassword");
    let openEye = document.getElementById("signupEyeOpen");
    let closedEye = document.getElementById("signupEyeClosed");

    if (pwd.type === "password") {
        pwd.type = "text";
        openEye.style.display = "none";
        closedEye.style.display = "block";
    } else {
        pwd.type = "password";
        openEye.style.display = "block";
        closedEye.style.display = "none";
    }
}
</script>

</body>
</html>
