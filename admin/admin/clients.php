<?php
session_start();
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
<link rel="stylesheet" href="assets/css/admin.css">

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Manage Clients</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a class="btn btn-success" href="client_form.php">
                        <i class="fas fa-plus me-2"></i>Add New Client
                    </a>
                </div>
            </div>

            <?php if (!empty($_GET['status'])): ?>
                <div class="alert alert-success">Client <?php echo htmlspecialchars($_GET['status']); ?> successfully.</div>
            <?php endif; ?>

            <div class="mb-3">
                <input type="text" class="form-control search-table-input" data-target-table="clientsTable" placeholder="Search clients...">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle sortable-table" id="clientsTable">
                    <thead class="table-dark">
                        <tr>
                            <th data-sort="number">ID</th>
                            <th>Logo</th>
                            <th data-sort="string">Name</th>
                            <th data-sort="string">City</th>
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
        </main>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
<script src="assets/js/admin.js"></script>