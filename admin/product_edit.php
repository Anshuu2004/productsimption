<?php
require '../connection/db.php';

// SECURITY: Restrict access to admins only
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

// --- CONFIGURATION ---
define('UPLOAD_DIR', __DIR__ . '/../assets/images/products/');

$id = $_GET['id'] ?? null;
$product = null;
$errors = [];

// --- FETCH CATEGORIES FOR THE DROPDOWN ---
// This query now dynamically gets all categories from your new table.
$categoriesStmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $categoriesStmt->fetchAll(PDO::FETCH_ASSOC);

// If editing, load the existing product data
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        header('Location: products.php');
        exit;
    }
}

// --- HANDLE FORM SUBMISSION ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete']) && $id) {
        if ($product && !empty($product['image']) && file_exists(UPLOAD_DIR . $product['image'])) {
            unlink(UPLOAD_DIR . $product['image']);
        }
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: products.php?deleted=1');
        exit;
    }
    
    // We now get 'category_id' from the form instead of 'category'
    $title       = trim($_POST['title'] ?? '');
    $price       = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
    $description = trim($_POST['description'] ?? '');
    $image_name  = $product['image'] ?? '';

    // Validation
    if (empty($title)) $errors[] = 'Title is required.';
    if ($price === false || $price < 0) $errors[] = 'Please enter a valid price.';
    if (empty($category_id)) $errors[] = 'Category is required.';

    // (File upload logic is the same)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (in_array($file_ext, $allowed_ext)) {
            $image_name = uniqid('prod_', true) . '.' . $file_ext;
            $dest_path = UPLOAD_DIR . $image_name;
            if (move_uploaded_file($file_tmp_path, $dest_path)) {
                if ($id && !empty($product['image']) && file_exists(UPLOAD_DIR . $product['image'])) {
                    unlink(UPLOAD_DIR . $product['image']);
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
            // UPDATED: The SQL now updates 'category_id'
            $stmt = $pdo->prepare("UPDATE products SET title=?, price=?, category_id=?, description=?, image=? WHERE id=?");
            $stmt->execute([$title, $price, $category_id, $description, $image_name, $id]);
            header('Location: products.php?updated=1');
            exit;
        } else {
            // UPDATED: The SQL now inserts 'category_id'
            $stmt = $pdo->prepare("INSERT INTO products (title, price, category_id, description, image) VALUES (?,?,?,?,?)");
            $stmt->execute([$title, $price, $category_id, $description, $image_name]);
            header('Location: products.php?added=1');
            exit;
        }
    }
}

include '../includes/header.php';
?>

<div class="container py-5">
    <h1><?php echo $id ? "Edit Product" : "Add Product"; ?></h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0"><?php foreach ($errors as $error) echo "<li>$error</li>"; ?></ul>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($product['title'] ?? ''); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Price (₹)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category['id']); ?>" 
                        <?php if (($product['category_id'] ?? '') == $category['id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Product Image</label>
            <input type="file" name="image" class="form-control">
            <?php if ($id && !empty($product['image'])): ?>
                <div class="mt-2">
                    <small class="text-muted">Current Image:</small><br>
                    <img src="../assets/images/products/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" style="max-width: 150px; height: auto;">
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary"><?php echo $id ? "Update" : "Add"; ?> Product</button>
        <a href="products.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>