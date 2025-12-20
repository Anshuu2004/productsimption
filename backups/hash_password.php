<?php
// The password we want to hash
$passwordToHash = 'password';

// Generate the hash using your server's PHP
$hash = password_hash($passwordToHash, PASSWORD_DEFAULT);

// Display the hash
echo "<h3>Your New Password Hash:</h3>";
echo "<p>Copy this entire line:</p>";
echo "<textarea rows='3' cols='70' readonly>" . htmlspecialchars($hash) . "</textarea>";
?>