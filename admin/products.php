<?php
require '../connection/db.php';

if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

// ##### NEW SQL QUERY WITH LEFT JOIN #####
$sql = "SELECT p.*, c.name AS category_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY p.created_at DESC";
$products = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
// ##### END OF CHANGE #####

include '../includes/header.php';
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Manage Products</h1>
        <a class="btn btn-success" href="product_edit.php">
             <i class="fas fa-plus me-2"></i>Add New Product
        </a>
    </div>

    <?php if (!empty($_GET['deleted'])): ?>
        <div class="alert alert-success">Product deleted successfully.</div>
    <?php elseif (!empty($_GET['updated'])): ?>
        <div class="alert alert-success">Product updated successfully.</div>
    <?php elseif (!empty($_GET['added'])): ?>
        <div class="alert alert-success">Product added successfully.</div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th style="width: 100px;">Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td>
                            <?php if (!empty($product['image']) && file_exists('../assets/images/products/' . $product['image'])): ?>
                                <img src="../assets/images/products/<?php echo htmlspecialchars($product['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['title']); ?>" 
                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <div class="text-muted text-center" style="width: 80px; height: 80px; line-height: 80px; background-color: #f8f9fa;">No Image</div>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($product['title']); ?></td>
                        <td><?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></td>
                        <td><?php echo '₹' . htmlspecialchars(number_format($product['price'], 2)); ?></td>
                        <td>
                            <a href="product_edit.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form method="post" action="product_edit.php?id=<?php echo $product['id']; ?>" class="d-inline ms-1">
                                <button type="submit" name="delete" value="1" class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Are you sure you want to delete this product?');" title="Delete">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>