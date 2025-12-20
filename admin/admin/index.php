<?php
session_start(); 
require '../connection/db.php';

// SECURITY CHECK: Redirect to login page if the user is not a logged-in admin.
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

// --- FETCH DASHBOARD STATS ---
try {
    $stmt = $pdo->query("
        SELECT
            (SELECT COUNT(*) FROM products) AS totalProducts,
            (SELECT COUNT(*) FROM clients) AS totalClients,
            (SELECT COUNT(*) FROM contact_messages) AS totalMessages,
            (SELECT COUNT(*) FROM users WHERE is_admin = 0) AS totalUsers,
            (SELECT COUNT(*) FROM quote_requests) AS totalQuotes
    ");
    $stats = $stmt->fetch();

    $totalProducts = $stats['totalProducts'] ?? 0;
    $totalClients = $stats['totalClients'] ?? 0;
    $totalMessages = $stats['totalMessages'] ?? 0;
    $totalUsers = $stats['totalUsers'] ?? 0;
    $totalQuotes = $stats['totalQuotes'] ?? 0;
} catch (PDOException $e) {
    $totalProducts = $totalClients = $totalMessages = $totalUsers = $totalQuotes = "Error";
}

include '../includes/header.php';
?>
<link rel="stylesheet" href="assets/css/admin.css">

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <div class="mb-4">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_user']['name']); ?> 👋</h2>
                <p class="lead text-muted">Here’s a quick overview of your application's activity.</p>
            </div>

            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-primary h-100">
                        <div class="card-body">
                            <h5 class="card-title">Total Products</h5>
                            <p class="card-text fs-2 fw-bold"><?php echo $totalProducts; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-success h-100">
                        <div class="card-body">
                            <h5 class="card-title">Total Clients</h5>
                            <p class="card-text fs-2 fw-bold"><?php echo $totalClients; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-danger h-100">
                        <div class="card-body">
                            <h5 class="card-title">New Messages</h5>
                            <p class="card-text fs-2 fw-bold"><?php echo $totalMessages; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-info h-100">
                        <div class="card-body">
                            <h5 class="card-title">Registered Users</h5>
                            <p class="card-text fs-2 fw-bold"><?php echo $totalUsers; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h3>Management Areas</h3>
                <div class="list-group">
                    <a href="products.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Manage Products
                        <span class="badge bg-primary rounded-pill"><?php echo $totalProducts; ?></span>
                    </a>
                    <a href="clients.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Manage Clients
                        <span class="badge bg-success rounded-pill"><?php echo $totalClients; ?></span>
                    </a>
                    <a href="quotes.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Manage Quote Requests
                        <span class="badge bg-warning rounded-pill"><?php echo $totalQuotes; ?></span>
                    </a>
                    <a href="messages.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        View Contact Messages
                        <span class="badge bg-danger rounded-pill"><?php echo $totalMessages; ?></span>
                    </a>
                    <a href="attendance_types.php" class="list-group-item list-group-item-action">Manage Attendance Types</a>
                    <a href="erp_modules.php" class="list-group-item list-group-item-action">Manage ERP Modules</a>
                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../includes/footer.php'; ?>