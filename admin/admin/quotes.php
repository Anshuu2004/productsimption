<?php
session_start();
require '../connection/db.php';

// Security check using the admin session
if (!isset($_SESSION['admin_user'])) {
    header('Location: login.php');
    exit;
}

// Fetch all quote requests, showing the newest ones first
$stmt = $pdo->query("SELECT * FROM quote_requests ORDER BY created_at DESC");
$quotes = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
?>
<link rel="stylesheet" href="assets/css/admin.css">

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Quote Requests</h1>
            </div>

            <div class="mb-3">
                <input type="text" class="form-control search-table-input" data-target-table="quotesTable" placeholder="Search quotes...">
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle sortable-table" id="quotesTable">
                    <thead class="table-dark">
                        <tr>
                            <th data-sort="date">Received On</th>
                            <th data-sort="string">Name</th>
                            <th data-sort="string">Company/School</th>
                            <th data-sort="string">Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($quotes)): ?>
                            <tr>
                                <td colspan="5" class="text-center">No quote requests have been received yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($quotes as $quote): ?>
                                <tr>
                                    <td><?php echo date("d M, Y", strtotime($quote['created_at'])); ?></td>
                                    <td><?php echo htmlspecialchars($quote['name']); ?></td>
                                    <td><?php echo htmlspecialchars($quote['company']); ?></td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <?php echo htmlspecialchars($quote['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="quote_view.php?id=<?php echo $quote['id']; ?>" class="btn btn-sm btn-primary" title="View Details">
                                            <i class="fas fa-eye"></i> View
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