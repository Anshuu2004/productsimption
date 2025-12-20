<?php
// logout.php - destroy session and redirect to homepage
session_start();



// Clear all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to homepage
header('Location: index.php');
exit;
