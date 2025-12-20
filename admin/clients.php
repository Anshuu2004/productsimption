<?php
require '../connection/db.php';

// Security check for admin users
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

// Fetch all clients from the database, ordering them by name
$stmt = $pdo->query("SELECT * FROM clients ORDER BY name ASC");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Manage Clients</h1>
        <a class="btn btn-success" href="client_form.php">
             <i class="fas fa-plus me-2"></i>Add New Client
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th style="width: 120px;">Logo</th>
                    <th>Name</th>
                    <th>City</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clients)): ?>
                    <tr>
                        <td colspan="5" class="text-center">No clients have been added yet.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($client['id']); ?></td>
                            <td>
                                <?php if (!empty($client['logo']) && file_exists('../assets/images/clients/' . $client['logo'])): ?>
                                    <img src="../assets/images/clients/<?php echo htmlspecialchars($client['logo']); ?>" 
                                         alt="<?php echo htmlspecialchars($client['name']); ?>" 
                                         style="width: 100px; height: auto; max-height: 60px; object-fit: contain;">
                                <?php else: ?>
                                    <div class="text-muted">No Logo</div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($client['name']); ?></td>
                            <td><?php echo htmlspecialchars($client['city']); ?></td>
                            <td>
                                <a href="client_form.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../includes/footer.php'; ?>