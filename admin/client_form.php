<?php
require '../connection/db.php';

// Security check for admin users
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

// --- CONFIGURATION ---
// Define the directory for client logos. Make sure this folder exists and is writable.
define('LOGO_UPLOAD_DIR', __DIR__ . '/../assets/images/clients/');

$id = $_GET['id'] ?? null;
$client = null;
$errors = [];

// If an ID is provided, we are editing, so fetch the client's data.
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
    $stmt->execute([$id]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);
    // Redirect if client with that ID doesn't exist.
    if (!$client) {
        header('Location: clients.php');
        exit;
    }
}

// --- HANDLE FORM SUBMISSION (POST request) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- HANDLE DELETE ---
    if (isset($_POST['delete']) && $id) {
        // First, delete the old logo file if it exists.
        if ($client && !empty($client['logo']) && file_exists(LOGO_UPLOAD_DIR . $client['logo'])) {
            unlink(LOGO_UPLOAD_DIR . $client['logo']);
        }
        // Then, delete the record from the database.
        $stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: clients.php?status=deleted');
        exit;
    }

    // --- HANDLE ADD/UPDATE ---
    $name = trim($_POST['name'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $logo_name = $client['logo'] ?? ''; // Keep old logo by default

    // Basic Validation
    if (empty($name)) {
        $errors[] = 'Client name is required.';
    }

    // --- HANDLE LOGO UPLOAD ---
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['logo']['tmp_name'];
        $file_name = $_FILES['logo']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];

        if (in_array($file_ext, $allowed_ext)) {
            // Create a unique filename to prevent overwriting.
            $logo_name = uniqid('client_', true) . '.' . $file_ext;
            $dest_path = LOGO_UPLOAD_DIR . $logo_name;

            if (move_uploaded_file($file_tmp_path, $dest_path)) {
                // If we are updating and a new logo is uploaded, delete the old one.
                if ($id && !empty($client['logo']) && file_exists(LOGO_UPLOAD_DIR . $client['logo'])) {
                    unlink(LOGO_UPLOAD_DIR . $client['logo']);
                }
            } else {
                $errors[] = 'Failed to move uploaded logo. Check directory permissions.';
            }
        } else {
            $errors[] = 'Invalid file type for logo. Allowed types: JPG, PNG, GIF, SVG, WEBP.';
        }
    }

    // If there are no errors, proceed with database action.
    if (empty($errors)) {
        if ($id) {
            // UPDATE existing client
            $stmt = $pdo->prepare("UPDATE clients SET name = ?, city = ?, logo = ? WHERE id = ?");
            $stmt->execute([$name, $city, $logo_name, $id]);
            header('Location: clients.php?status=updated');
        } else {
            // INSERT new client
            $stmt = $pdo->prepare("INSERT INTO clients (name, city, logo) VALUES (?, ?, ?)");
            $stmt->execute([$name, $city, $logo_name]);
            header('Location: clients.php?status=added');
        }
        exit;
    }
}

include '../includes/header.php';
?>

<div class="container py-5">
    <h1 class="mb-4"><?php echo $id ? "Edit Client" : "Add New Client"; ?></h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Client Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($client['name'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($client['city'] ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">Client Logo</label>
            <input type="file" class="form-control" id="logo" name="logo">
            <small class="text-muted">Leave blank to keep the current logo. Best results with transparent PNG or SVG.</small>
            <?php if ($id && !empty($client['logo'])): ?>
                <div class="mt-2">
                    <img src="../assets/images/clients/<?php echo htmlspecialchars($client['logo']); ?>" alt="Current Logo" style="max-width: 200px; max-height: 80px; background-color: #f8f9fa; padding: 5px; border-radius: 4px;">
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex justify-content-between">
            <div>
                <button type="submit" class="btn btn-primary"><?php echo $id ? "Update Client" : "Save Client"; ?></button>
                <a href="clients.php" class="btn btn-secondary">Cancel</a>
            </div>
            <?php if ($id): ?>
                <button type="submit" name="delete" value="1" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this client? This action cannot be undone.');">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
            <?php endif; ?>
        </div>
    </form>
</div>

<?php include '../includes/footer.php'; ?>