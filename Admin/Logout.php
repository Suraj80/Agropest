<?php
// Start the session
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: ../Index.html");
exit(); // Ensure the script stops execution after redirection
?>
