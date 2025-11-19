<?php
// Destroy Admin Session
session_name("ADMINSESS");
session_start();
session_unset();
session_destroy();

// Destroy User Session
session_name("PHPSESSID");  // default session
session_start();
session_unset();
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
?>
