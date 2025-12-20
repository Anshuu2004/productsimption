<?php 
require 'connection/db.php';
include 'includes/header.php'; 

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
$update_success = false;
$password_success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_profile'])) {
        $name = trim($_POST['name']);
        if (!empty($name)) {
            $stmt = $pdo->prepare("UPDATE users SET name = ? WHERE id = ?");
            if ($stmt->execute([$name, $user['id']])) {
                $_SESSION['user']['name'] = $name;
                $user['name'] = $name;
                $update_success = true;
            }
        }
    }

    if (isset($_POST['change_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_new_password = $_POST['confirm_new_password'];

        if (strlen($new_password) < 6) {
            $error = "Password must be at least 6 characters long.";
        } elseif ($new_password !== $confirm_new_password) {
            $error = "New passwords do not match.";
        } else {
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$user['id']]);
            $db_password = $stmt->fetchColumn();

            if (password_verify($current_password, $db_password)) {
                $hash = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                if ($stmt->execute([$hash, $user['id']])) {
                    $password_success = true;
                }
            } else {
                $error = "Incorrect current password.";
            }
        }
    }
}

?>

<main>
    <section class="page-header">
        <div class="container text-center">
            <h1 class="text-white">My Profile</h1>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <?php if ($update_success): ?>
                        <div class="alert alert-success">Profile updated successfully!</div>
                    <?php endif; ?>
                    <?php if ($password_success): ?>
                        <div class="alert alert-success">Password changed successfully!</div>
                    <?php endif; ?>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Profile Details</h5>
                            <table class="table">
                                <tr>
                                    <th>Name</th>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                </tr>
                            </table>
                            <a href="order_history.php" class="btn btn-primary">View Order History</a>
                            <button id="editProfileBtn" class="btn btn-secondary">Edit Profile</button>
                            <button id="changePasswordBtn" class="btn btn-outline-secondary">Change Password</button>
                        </div>
                    </div>

                    <div id="editProfileForm" class="card mt-4" style="display: none;">
                        <div class="card-body">
                            <h5 class="card-title">Edit Profile</h5>
                            <form method="post">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                </div>
                                <button type="submit" name="update_profile" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <div id="changePasswordForm" class="card mt-4" style="display: none;">
                        <div class="card-body">
                            <h5 class="card-title">Change Password</h5>
                            <form method="post">
                                <div class="mb-3">
                                    <label class="form-label">Current Password</label>
                                    <input type="password" name="current_password" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="new_password" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="confirm_new_password" class="form-control" required>
                                </div>
                                <button type="submit" name="change_password" class="btn btn-primary">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    document.getElementById('editProfileBtn').addEventListener('click', function() {
        document.getElementById('editProfileForm').style.display = 'block';
        document.getElementById('changePasswordForm').style.display = 'none';
    });

    document.getElementById('changePasswordBtn').addEventListener('click', function() {
        document.getElementById('changePasswordForm').style.display = 'block';
        document.getElementById('editProfileForm').style.display = 'none';
    });
</script>

<?php include 'includes/footer.php'; ?>
