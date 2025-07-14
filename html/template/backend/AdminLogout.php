<?php
session_start();
session_unset();      // Remove all session variables
session_destroy();    // Destroy the session

// Optional: clear cookies
setcookie("PHPSESSID", "", time() - 3600, "/");
header('Location: adminlogin.php');
exit();
?>