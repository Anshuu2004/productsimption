<?php
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

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Manage Attendance Types</h1>
        <a class="btn btn-success" href="attendance_type_edit.php">
             <i class="fas fa-plus me-2"></i>Add New Attendance Type
        </a>
    </div>

    <?php if (!empty($_GET['deleted'])): ?>
        <div class="alert alert-success">Attendance type deleted successfully.</div>
    <?php elseif (!empty($_GET['updated'])): ?>
        <div class="alert alert-success">Attendance type updated successfully.</div>
    <?php elseif (!empty($_GET['added'])): ?>
        <div class="alert alert-success">Attendance type added successfully.</div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Slug</th>
                    <th>Title</th>
                    <th>Short Description</th>
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
                                            onclick="return confirm('Are you sure you want to delete this attendance type?');" title="Delete">
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

