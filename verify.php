<?php 
require 'connection/db.php';

$code = $_GET['code'] ?? '';

if (!$code) {
    $message = "Missing or invalid verification code.";
} else {
    // Check if user exists with this code and is not yet verified
    $stmt = $pdo->prepare("SELECT id FROM users WHERE verify_code = ? AND is_verified = 0");
    $stmt->execute([$code]);

    if ($user = $stmt->fetch()) {
        // Mark user as verified
        $update = $pdo->prepare("UPDATE users SET is_verified = 1, verify_code = NULL WHERE id = ?");
        $update->execute([$user['id']]);

        $message = "✅ Email verified successfully! You may now log in.";
        // Optional: redirect after 5 seconds
        header("Refresh: 5; URL=login.php");
    } else {
        $message = "⚠️ Verification failed. Link may be invalid or already used.";
    }
}

include 'includes/header.php'; 
?> 

<div class="container py-5">
  <div class="alert alert-info">
    <?php echo htmlspecialchars($message); ?>
  </div>
  <a href="login.php" class="btn btn-primary">Go to Login</a>
</div>

<?php include 'includes/footer.php'; ?>
