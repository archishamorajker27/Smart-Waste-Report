<?php
include "db_connect.php";

/* ---------------------------------------
   CHECK ADMIN SESSION
---------------------------------------- */
session_name("ADMINSESS");
session_start();
$admin_logged = isset($_SESSION['admin']);
session_write_close();

/* ---------------------------------------
   CHECK USER SESSION
---------------------------------------- */
session_name("USERSESS");
session_start();
$user_logged = isset($_SESSION['user_id']);
session_write_close();

/* ---------------------------------------
   REDIRECT IF ALREADY LOGGED IN
---------------------------------------- */
if ($admin_logged) {
    header("Location: admin_dashboard.php");
    exit;
}

if ($user_logged) {
    header("Location: user_dashboard.php");
    exit;
}

$error = "";

/* ---------------------------------------
   HANDLE LOGIN FORM SUBMISSION
---------------------------------------- */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    /* ---------------------------------------
       ADMIN LOGIN
    ---------------------------------------- */
    if ($email === "admin@waste.com" && $password === "admin123") {

        session_name("ADMINSESS");
        session_start();
        $_SESSION['admin'] = true;
        session_write_close();

        header("Location: admin_dashboard.php");
        exit;
    }

    /* ---------------------------------------
       USER LOGIN (DATABASE)
    ---------------------------------------- */
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {

            session_name("USERSESS");
            session_start();

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $email;

            session_write_close();

            header("Location: user_dashboard.php");
            exit;

        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Email not found. Please sign up.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Smart Waste Report</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>

<div class="login-container">

    <a href="index.php" class="back-arrow">←</a>

    <h2 class="login-title">Login</h2>

    <?php if (!empty($error)) { ?>
        <p style="color: red; font-size: 14px;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST">

        <div class="input-box">
            <input type="email" name="email" placeholder="Email" required>
        </div>

        <div class="input-box password-wrapper">
            <input name="password" id="loginPassword" type="password" placeholder="Password" required>

            <span class="toggle-password" onclick="toggleLoginPassword()">
                <svg id="loginEyeOpen" class="eye-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="#ffffff" d="M12 5C4.4 5 0 12 0 12s4.4 7 12 7 12-7 12-7-4.4-7-12-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/>
                </svg>

                <svg id="loginEyeClosed" class="eye-icon" style="display:none;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="#ffffff" d="M2 5.3l1.3 1.3C1.5 8.1 0 10 0 12s4.4 7 12 7c2.2 0 4.3-.5 6.1-1.3l1.3 1.3 1.4-1.4L3.4 3.9 2 5.3zM12 17c-5 0-8.8-4-9.8-5 1.3-1.3 2.6-2.5 4.2-3.3l1.6 1.6a5 5 0 006.6 6.6l1.6 1.6c-1.6.9-3.3 1.5-5.2 1.5z"/>
                </svg>
            </span>
        </div>

        <button type="submit" class="login-btn">Login</button>

        <p class="signup-text">
            No account? <a href="signup.php">Sign up</a>
        </p>
    </form>
</div>

<script>
function toggleLoginPassword() {
    let pwd = document.getElementById("loginPassword");
    let openEye = document.getElementById("loginEyeOpen");
    let closedEye = document.getElementById("loginEyeClosed");

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
