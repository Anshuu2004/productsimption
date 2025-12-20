<?php
require '../connection/db.php';

// Security check for admin users
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
$module = null;
$errors = [];

// If editing, load the existing ERP module data
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM erp_modules WHERE id = ?");
    $stmt->execute([$id]);
    $module = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$module) {
        header('Location: erp_modules.php');
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete']) && $id) {
        $stmt = $pdo->prepare("DELETE FROM erp_modules WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: erp_modules.php?deleted=1');
        exit;
    }
    
    $slug = trim($_POST['slug'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Validation
    if (empty($slug)) $errors[] = 'Slug is required.';
    if (empty($title)) $errors[] = 'Title is required.';
    
    // Check for unique slug (if new or slug changed)
    if (empty($errors)) {
        $checkStmt = $pdo->prepare("SELECT id FROM erp_modules WHERE slug = ? AND id != ?");
        $checkStmt->execute([$slug, $id ?? 0]);
        if ($checkStmt->fetch()) {
            $errors[] = 'Slug already exists. Please choose a different one.';
        }
    }

    if (empty($errors)) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE erp_modules SET slug=?, title=?, description=? WHERE id=?");
            $stmt->execute([$slug, $title, $description, $id]);
            header('Location: erp_modules.php?updated=1');
            exit;
        } else {
            $stmt = $pdo->prepare("INSERT INTO erp_modules (slug, title, description) VALUES (?,?,?)");
            $stmt->execute([$slug, $title, $description]);
            header('Location: erp_modules.php?added=1');
            exit;
        }
    }
}

include '../includes/header.php';
?>

<div class="container py-5">
    <h1><?php echo $id ? "Edit ERP Module" : "Add ERP Module"; ?></h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0"><?php foreach ($errors as $error) echo "<li>$error</li>"; ?></ul>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Slug (URL-friendly identifier)</label>
            <input type="text" name="slug" class="form-control" value="<?php echo htmlspecialchars($module['slug'] ?? ''); ?>" required>
            <small class="text-muted">e.g., "school", "attendance", "college"</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($module['title'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="6"><?php echo htmlspecialchars($module['description'] ?? ''); ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><?php echo $id ? "Update" : "Add"; ?> ERP Module</button>
        <a href="erp_modules.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>

