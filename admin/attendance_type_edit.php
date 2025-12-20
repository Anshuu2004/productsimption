<?php
require '../connection/db.php';

// Security check for admin users
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

// Configuration for image uploads
define('IMAGE_UPLOAD_DIR', __DIR__ . '/../assets/images/attendance/');

$id = $_GET['id'] ?? null;
$type = null;
$errors = [];

// If editing, load the existing attendance type data
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM attendance_types WHERE id = ?");
    $stmt->execute([$id]);
    $type = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$type) {
        header('Location: attendance_types.php');
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete']) && $id) {
        if ($type && !empty($type['image']) && file_exists(IMAGE_UPLOAD_DIR . $type['image'])) {
            unlink(IMAGE_UPLOAD_DIR . $type['image']);
        }
        $stmt = $pdo->prepare("DELETE FROM attendance_types WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: attendance_types.php?deleted=1');
        exit;
    }
    
    $slug = trim($_POST['slug'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $short_desc = trim($_POST['short_desc'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $image_name = $type['image'] ?? '';

    // Validation
    if (empty($slug)) $errors[] = 'Slug is required.';
    if (empty($title)) $errors[] = 'Title is required.';
    
    // Check for unique slug (if new or slug changed)
    if (empty($errors)) {
        $checkStmt = $pdo->prepare("SELECT id FROM attendance_types WHERE slug = ? AND id != ?");
        $checkStmt->execute([$slug, $id ?? 0]);
        if ($checkStmt->fetch()) {
            $errors[] = 'Slug already exists. Please choose a different one.';
        }
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($file_ext, $allowed_ext)) {
            $image_name = uniqid('att_', true) . '.' . $file_ext;
            $dest_path = IMAGE_UPLOAD_DIR . $image_name;
            if (move_uploaded_file($file_tmp_path, $dest_path)) {
                if ($id && !empty($type['image']) && file_exists(IMAGE_UPLOAD_DIR . $type['image'])) {
                    unlink(IMAGE_UPLOAD_DIR . $type['image']);
                }
            } else {
                $errors[] = 'Failed to move uploaded file.';
            }
        } else {
            $errors[] = 'Invalid file type.';
        }
    }

    if (empty($errors)) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE attendance_types SET slug=?, title=?, short_desc=?, content=?, image=? WHERE id=?");
            $stmt->execute([$slug, $title, $short_desc, $content, $image_name, $id]);
            header('Location: attendance_types.php?updated=1');
            exit;
        } else {
            $stmt = $pdo->prepare("INSERT INTO attendance_types (slug, title, short_desc, content, image) VALUES (?,?,?,?,?)");
            $stmt->execute([$slug, $title, $short_desc, $content, $image_name]);
            header('Location: attendance_types.php?added=1');
            exit;
        }
    }
}

include '../includes/header.php';
?>

<div class="container py-5">
    <h1><?php echo $id ? "Edit Attendance Type" : "Add Attendance Type"; ?></h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0"><?php foreach ($errors as $error) echo "<li>$error</li>"; ?></ul>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Slug (URL-friendly identifier)</label>
            <input type="text" name="slug" class="form-control" value="<?php echo htmlspecialchars($type['slug'] ?? ''); ?>" required>
            <small class="text-muted">e.g., "rfid", "face", "fingerprint"</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($type['title'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Short Description</label>
            <input type="text" name="short_desc" class="form-control" value="<?php echo htmlspecialchars($type['short_desc'] ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Content (Full Description)</label>
            <textarea name="content" class="form-control" rows="6"><?php echo htmlspecialchars($type['content'] ?? ''); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
            <?php if ($id && !empty($type['image'])): ?>
                <div class="mt-2">
                    <small class="text-muted">Current Image:</small><br>
                    <img src="../assets/images/attendance/<?php echo htmlspecialchars($type['image']); ?>" alt="Attendance Type Image" style="max-width: 150px; height: auto;">
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary"><?php echo $id ? "Update" : "Add"; ?> Attendance Type</button>
        <a href="attendance_types.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>

