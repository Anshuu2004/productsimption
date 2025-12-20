<?php 
include 'includes/header.php';

// Handle remove single item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    $id = intval($_POST['remove_id']);
    if (!empty($_SESSION['enquiry'][$id])) {
        unset($_SESSION['enquiry'][$id]);
    }
}

// Handle clear cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_cart'])) {
    $_SESSION['enquiry'] = [];
}

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    if (!empty($_SESSION['enquiry'][$id]) && $quantity > 0) {
        $_SESSION['enquiry'][$id]['quantity'] = $quantity;
    } elseif (!empty($_SESSION['enquiry'][$id]) && $quantity <= 0) {
        unset($_SESSION['enquiry'][$id]);
    }
}

// Get current cart
$cart = $_SESSION['enquiry'] ?? [];
?> 

<div class="container py-5">
  <h1>Enquiry Cart</h1>

  <?php if (empty($cart)): ?>
    <div class="alert alert-info">Your enquiry cart is empty.</div>
  <?php else: ?>
    <form method="post">
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Price (₹)</th>
            <th>Quantity</th>
            <th>Total (₹)</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $cart_total = 0;
          foreach ($cart as $item): 
            $item_total = $item['price'] * $item['quantity'];
            $cart_total += $item_total;
          ?>
            <tr>
              <td>
                <img src="assets/images/products/<?php echo htmlspecialchars($item['image']); ?>" 
                     alt="" style="width:60px;">
              </td>
              <td><?php echo htmlspecialchars($item['title']); ?></td>
              <td><?php echo number_format($item['price'], 2); ?></td>
              <td>
                <form method="post" class="d-flex align-items-center">
                  <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                  <input type="hidden" name="update_quantity" value="1">
                  <button type="button" class="btn btn-sm btn-outline-secondary qty-btn" onclick="updateQuantity(<?php echo $item['id']; ?>, -1)">-</button>
                  <input type="number" id="qty_<?php echo $item['id']; ?>" name="quantity" class="form-control form-control-sm mx-1 text-center" value="<?php echo $item['quantity']; ?>" min="1" style="width: 60px;" onchange="this.form.submit()">
                  <button type="button" class="btn btn-sm btn-outline-secondary qty-btn" onclick="updateQuantity(<?php echo $item['id']; ?>, 1)">+</button>
                </form>
              </td>
              <td><?php echo number_format($item_total, 2); ?></td>
              <td>
                <form method="post" class="d-inline">
                  <input type="hidden" name="remove_id" value="<?php echo $item['id']; ?>">
                  <button type="submit" class="btn btn-sm btn-danger"
                          onclick="return confirm('Remove this item from cart?');">
                    Remove
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        <tfoot class="table-light">
          <tr>
            <th colspan="4" class="text-end">Total:</th>
            <th>₹<?php echo number_format($cart_total, 2); ?></th>
            <th></th>
          </tr>
        </tfoot>
      </table>
    </form>

    <div class="d-flex justify-content-between mt-3">
      <form method="post">
        <input type="hidden" name="clear_cart" value="1">
        <button type="submit" class="btn btn-warning"
                onclick="return confirm('Are you sure you want to clear the entire cart?');">
          Clear Cart
        </button>
      </form>

      <a href="contact.php?enquiry=1" class="btn btn-primary">Proceed to Enquiry</a>
    </div>
  <?php endif; ?>
</div>

<script>
function updateQuantity(productId, change) {
    const qtyInput = document.getElementById('qty_' + productId);
    let newQty = parseInt(qtyInput.value) + change;
    if (newQty < 1) newQty = 1;
    qtyInput.value = newQty;
    qtyInput.form.submit();
}
</script>

<?php include 'includes/footer.php'; ?>