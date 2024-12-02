<?php
// Start the session to access session variables
session_start();

// Destroy the session to log out the user
session_destroy();

// Redirect to the login page
header('Location: login.php');
exit(); // Ensure the script stops executing after redirect
?>
