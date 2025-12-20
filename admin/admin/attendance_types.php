<?php
session_start();
require '../connection/db.php';

// Security check for admin users
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

// Fetch all attendance types from the database
$stmt = $pdo->query("SELECT * FROM attendance_types ORDER BY id ASC");
$attendance_types = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
?>
<link rel="stylesheet" href="assets/css/admin.css">

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manage Attendance Types</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a class="btn btn-success" href="attendance_type_edit.php">
                        <i class="fas fa-plus me-2"></i>Add New Attendance Type
                    </a>
                </div>
            </div>

            <?php if (!empty($_GET['deleted'])): ?>
                <div class="alert alert-success">Attendance type deleted successfully.</div>
            <?php elseif (!empty($_GET['updated'])): ?>
                <div class="alert alert-success">Attendance type updated successfully.</div>
            <?php elseif (!empty($_GET['added'])): ?>
                <div class="alert alert-success">Attendance type added successfully.</div>
            <?php endif; ?>

            <div class="mb-3">
                <input type="text" class="form-control search-table-input" data-target-table="attendanceTypesTable" placeholder="Search attendance types...">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle sortable-table" id="attendanceTypesTable">
                    <thead class="table-dark">
                        <tr>
                            <th data-sort="number">ID</th>
                            <th data-sort="string">Slug</th>
                            <th data-sort="string">Title</th>
                            <th data-sort="string">Short Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($attendance_types)): ?>
                            <tr>
                                <td colspan="5" class="text-center">No attendance types have been added yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($attendance_types as $type): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($type['id']); ?></td>
                                    <td><?php echo htmlspecialchars($type['slug']); ?></td>
                                    <td><?php echo htmlspecialchars($type['title']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($type['short_desc'] ?? '', 0, 60)) . (strlen($type['short_desc'] ?? '') > 60 ? '...' : ''); ?></td>
                                    <td>
                                        <a href="attendance_type_edit.php?id=<?php echo $type['id']; ?>" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form method="post" action="attendance_type_edit.php?id=<?php echo $type['id']; ?>" class="d-inline ms-1">
                                                                                    <button type="submit" name="delete" value="1" class="btn btn-sm btn-danger" 
                                                                                            data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" 
                                                                                            data-confirm-message="Are you sure you want to delete this attendance type?" title="Delete">
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

