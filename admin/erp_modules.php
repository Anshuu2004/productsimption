<?php
require '../connection/db.php';

// Security check for admin users
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

// Fetch all ERP modules from the database
$stmt = $pdo->query("SELECT * FROM erp_modules ORDER BY id ASC");
$erp_modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Manage ERP Modules</h1>
        <a class="btn btn-success" href="erp_module_edit.php">
             <i class="fas fa-plus me-2"></i>Add New ERP Module
        </a>
    </div>

    <?php if (!empty($_GET['deleted'])): ?>
        <div class="alert alert-success">ERP module deleted successfully.</div>
    <?php elseif (!empty($_GET['updated'])): ?>
        <div class="alert alert-success">ERP module updated successfully.</div>
    <?php elseif (!empty($_GET['added'])): ?>
        <div class="alert alert-success">ERP module added successfully.</div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Slug</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($erp_modules)): ?>
                    <tr>
                        <td colspan="5" class="text-center">No ERP modules have been added yet.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($erp_modules as $module): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($module['id']); ?></td>
                            <td><?php echo htmlspecialchars($module['slug']); ?></td>
                            <td><?php echo htmlspecialchars($module['title']); ?></td>
                            <td><?php echo htmlspecialchars(substr($module['description'] ?? '', 0, 60)) . (strlen($module['description'] ?? '') > 60 ? '...' : ''); ?></td>
                            <td>
                                <a href="erp_module_edit.php?id=<?php echo $module['id']; ?>" class="btn btn-sm btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="post" action="erp_module_edit.php?id=<?php echo $module['id']; ?>" class="d-inline ms-1">
                                    <button type="submit" name="delete" value="1" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this ERP module?');" title="Delete">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

