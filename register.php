<?php 
session_start();
require 'connection/db.php'; 
require 'includes/mailer_config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? ''; // Added this line

    // Updated Validation Logic
    if (!$name || !$email) {
        $error = "Please provide a name and a valid email.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } elseif ($password !== $password_confirm) { // Added this check
        $error = "Passwords do not match. Please try again.";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = "Email is already registered.";
        } else {
            // Hash password and generate verification code
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $verify_code = bin2hex(random_bytes(16));

            $stmt = $pdo->prepare(
                "INSERT INTO users (name, email, password, verify_code) VALUES (?,?,?,?)"
            );
            $stmt->execute([$name, $email, $hash, $verify_code]);

            // Send verification email
            if (sendVerificationEmail($email, $verify_code)) {
                $success = "Account created. A verification email has been sent to your inbox.";
            } else {
                $error = "Account created, but the verification email could not be sent. Please contact support.";
            }
        }
    }
}

include 'includes/header.php'; 
?> 

<main>
    <section class="page-header">
        <div class="container text-center">
            <h1 class="text-white">Create an Account</h1>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="contact-form-wrapper">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger mb-4">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success mb-4">
                                <?php echo htmlspecialchars($success); ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input name="name" type="text" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input name="password" type="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input name="password_confirm" type="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                        <div class="text-center mt-3">
                            <p>Already have an account? <a href="login.php">Login here</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>