<?php
session_name("USERSESS");
session_start();
include "db_connect.php";

// MUST BE LOGGED IN
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = "";
$success = "";

// FETCH USER DATA
$stmt = $conn->prepare("SELECT name, email, password FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$current_name = $user['name'];
$current_email = $user['email'];
$current_pass_hash = $user['password'];

// WHEN FORM SUBMITTED
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $new_name  = trim($_POST['name']);
    $new_email = trim($_POST['email']);
    $password  = trim($_POST['password']);

    // VERIFY PASSWORD
    if (!password_verify($password, $current_pass_hash)) {
        $error = "Incorrect password. Cannot update profile.";
    } else {
        // UPDATE
        $update = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
        $update->bind_param("ssi", $new_name, $new_email, $user_id);

        if ($update->execute()) {
            $success = "Profile updated successfully!";

            // UPDATE SESSION TOO
            $_SESSION['user_name']  = $new_name;
            $_SESSION['user_email'] = $new_email;

        } else {
            $error = "Something went wrong!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/edit_profile.css">
</head>

<body>

<a href="user_dashboard.php" class="back-btn">← Back</a>

<div class="page-wrap">
    <div class="container">

        <h2 class="heading">Edit Profile</h2>

        <?php if ($error) { ?>
            <p class="msg error"><?= $error ?></p>
        <?php } ?>

        <?php if ($success) { ?>
            <p class="msg success"><?= $success ?></p>
        <?php } ?>

        <form method="POST">

            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($current_name) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($current_email) ?>" required>

            <label>Enter Password to Confirm</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <button class="save-btn">Save Changes</button>

        </form>

    </div>
</div>

</body>
</html>
