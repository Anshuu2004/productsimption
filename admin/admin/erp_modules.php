<?php
session_start();
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
<link rel="stylesheet" href="assets/css/admin.css">

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manage ERP Modules</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a class="btn btn-success" href="erp_module_edit.php">
                        <i class="fas fa-plus me-2"></i>Add New ERP Module
                    </a>
                </div>
            </div>

            <?php if (!empty($_GET['deleted'])): ?>
                <div class="alert alert-success">ERP module deleted successfully.</div>
            <?php elseif (!empty($_GET['updated'])): ?>
                <div class="alert alert-success">ERP module updated successfully.</div>
            <?php elseif (!empty($_GET['added'])): ?>
                <div class="alert alert-success">ERP module added successfully.</div>
            <?php endif; ?>

            <div class="mb-3">
                <input type="text" class="form-control search-table-input" data-target-table="erpModulesTable" placeholder="Search ERP modules...">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle sortable-table" id="erpModulesTable">
                    <thead class="table-dark">
                        <tr>
                            <th data-sort="number">ID</th>
                            <th data-sort="string">Slug</th>
                            <th data-sort="string">Title</th>
                            <th data-sort="string">Description</th>
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
                                                                                            data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" 
                                                                                            data-confirm-message="Are you sure you want to delete this ERP module?" title="Delete">
                                                                                        <i class="fas fa-trash-alt"></i> Delete
                                                                                    </button>                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
<script src="assets/js/admin.js"></script>

