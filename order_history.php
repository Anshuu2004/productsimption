<?php 
require 'connection/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

// Get user's orders
$stmt = $pdo->prepare("
    SELECT o.*, qr.name as customer_name, qr.company 
    FROM orders o 
    LEFT JOIN quote_requests qr ON o.quote_request_id = qr.id 
    WHERE o.user_id = ? 
    ORDER BY o.created_at DESC
");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?> 

<div class="container py-5">
  <h1>My Order History</h1>

  <?php if (empty($orders)): ?>
    <div class="alert alert-info">You haven't placed any orders yet.</div>
    <a href="products.php" class="btn btn-primary">Browse Products</a>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total</th>
            <th>Customer</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $order): ?>
            <tr>
              <td><?php echo htmlspecialchars($order['id']); ?></td>
              <td><?php echo date('M j, Y', strtotime($order['created_at'])); ?></td>
              <td>
                <span class="badge bg-<?php 
                  echo $order['status'] == 'Completed' ? 'success' : 
                       ($order['status'] == 'Processing' ? 'warning' : 
                       ($order['status'] == 'Shipped' ? 'primary' : 'secondary')); 
                ?>">
                  <?php echo htmlspecialchars($order['status']); ?>
                </span>
              </td>
              <td>₹<?php echo number_format($order['total_amount'], 2); ?></td>
              <td><?php echo htmlspecialchars($order['customer_name'] ?? 'N/A'); ?></td>
              <td>
                <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-outline-primary">View Details</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>