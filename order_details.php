<?php 
require 'connection/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user']['id'];

// Get order details
$stmt = $pdo->prepare("
    SELECT o.*, qr.name as customer_name, qr.email, qr.phone, qr.company, qr.message
    FROM orders o 
    LEFT JOIN quote_requests qr ON o.quote_request_id = qr.id 
    WHERE o.id = ? AND o.user_id = ?
");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch();

if (!$order) {
    header('Location: order_history.php');
    exit;
}

// Get order items
$stmt = $pdo->prepare("
    SELECT oi.*, p.title, p.image
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll();
?> 

<div class="container py-5">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="order_history.php">Order History</a></li>
      <li class="breadcrumb-item active" aria-current="page">Order #<?php echo $order['id']; ?></li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Order Items</h5>
        </div>
        <div class="card-body">
          <?php if (empty($order_items)): ?>
            <p>No items found for this order.</p>
          <?php else: ?>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $subtotal = 0;
                  foreach ($order_items as $item): 
                    $item_total = $item['price'] * $item['quantity'];
                    $subtotal += $item_total;
                  ?>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <?php if (!empty($item['image'])): ?>
                            <img src="assets/images/products/<?php echo htmlspecialchars($item['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                 style="width: 60px; height: 60px; object-fit: cover;" class="me-3">
                          <?php endif; ?>
                          <div>
                            <h6 class="mb-0"><?php echo htmlspecialchars($item['title']); ?></h6>
                          </div>
                        </div>
                      </td>
                      <td>₹<?php echo number_format($item['price'], 2); ?></td>
                      <td><?php echo $item['quantity']; ?></td>
                      <td>₹<?php echo number_format($item_total, 2); ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="3" class="text-end">Subtotal:</th>
                    <th>₹<?php echo number_format($subtotal, 2); ?></th>
                  </tr>
                  <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th>₹<?php echo number_format($order['total_amount'], 2); ?></th>
                  </tr>
                </tfoot>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-header">
          <h5 class="mb-0">Order Summary</h5>
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>Order ID:</span>
              <strong>#<?php echo $order['id']; ?></strong>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>Date:</span>
              <strong><?php echo date('M j, Y', strtotime($order['created_at'])); ?></strong>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>Status:</span>
              <span class="badge bg-<?php 
                echo $order['status'] == 'Completed' ? 'success' : 
                     ($order['status'] == 'Processing' ? 'warning' : 
                     ($order['status'] == 'Shipped' ? 'primary' : 'secondary')); 
              ?>">
                <?php echo htmlspecialchars($order['status']); ?>
              </span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>Total Amount:</span>
              <strong>₹<?php echo number_format($order['total_amount'], 2); ?></strong>
            </li>
          </ul>
        </div>
      </div>
      
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Customer Information</h5>
        </div>
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item">
              <small class="text-muted">Name</small>
              <div><?php echo htmlspecialchars($order['customer_name'] ?? 'N/A'); ?></div>
            </li>
            <li class="list-group-item">
              <small class="text-muted">Email</small>
              <div><?php echo htmlspecialchars($order['email'] ?? 'N/A'); ?></div>
            </li>
            <li class="list-group-item">
              <small class="text-muted">Phone</small>
              <div><?php echo htmlspecialchars($order['phone'] ?? 'N/A'); ?></div>
            </li>
            <li class="list-group-item">
              <small class="text-muted">Company</small>
              <div><?php echo htmlspecialchars($order['company'] ?? 'N/A'); ?></div>
            </li>
            <?php if (!empty($order['message'])): ?>
            <li class="list-group-item">
              <small class="text-muted">Message</small>
              <div><?php echo htmlspecialchars($order['message']); ?></div>
            </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>