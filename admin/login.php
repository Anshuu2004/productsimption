<?php
// Always start the session at the very top
session_start();

// If the admin is already logged in, redirect them to the dashboard
if (isset($_SESSION['admin_user'])) {
    header("Location: index.php");
    exit;
}

require '../connection/db.php';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error_message = 'Please enter both email and password.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND is_admin = 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // SUCCESS! Create a UNIQUE session variable for admins.
            $_SESSION['admin_user'] = [
                'id' => $user['id'],
                'name' => $user['name']
            ];
            
            header("Location: index.php");
            exit;
        } else {
            $error_message = 'Invalid email or password.';
        }
    }
}

include '../includes/header.php'; 
?>

<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body p-5">
            <h3 class="card-title text-center mb-4">Admin Login</h3>
            
            <?php if ($error_message): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <form method="post" action="login.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>