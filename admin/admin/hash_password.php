<?php
// The password we want to hash
$passwordToHash = 'password';

// Generate the hash using your server's PHP
$hash = password_hash($passwordToHash, PASSWORD_DEFAULT);

// Display the hash
include '../includes/header.php';
?>
<link rel="stylesheet" href="assets/css/admin.css">

<div class="container py-5">
    <h1 class="h2 mb-4">Password Hash Generator</h1>
    <p class="lead">Use this tool to generate a secure hash for a password. Copy the generated hash and use it when manually setting admin passwords in the database.</p>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h3 class="card-title">Password to Hash:</h3>
            <p class="card-text"><code><?php echo htmlspecialchars($passwordToHash); ?></code></p>
            <hr>
            <h3 class="card-title">Generated Hash:</h3>
            <p class="card-text">Copy this entire line:</p>
            <textarea class="form-control" rows="3" readonly><?php echo htmlspecialchars($hash); ?></textarea>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>