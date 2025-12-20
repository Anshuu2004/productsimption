<?php
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

<main>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Quote Requests</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Received On</th>
                        <th>Name</th>
                        <th>Company/School</th>
                        <th>Status</th>
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
    </div>
</main>

<?php include '../includes/footer.php'; ?>