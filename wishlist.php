<?php 
require 'connection/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user']['id'];

// Handle add to wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_wishlist'])) {
    $product_id = intval($_POST['product_id']);
    
    // Check if already in wishlist
    $stmt = $pdo->prepare("SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    
    if (!$stmt->fetch()) {
        // Add to wishlist
        $stmt = $pdo->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $product_id]);
    }
}

// Handle remove from wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_wishlist'])) {
    $product_id = intval($_POST['product_id']);
    
    // Remove from wishlist
    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
}

// Get wishlist items
$stmt = $pdo->prepare("
    SELECT w.*, p.title, p.price, p.image, p.category_id 
    FROM wishlist w 
    JOIN products p ON w.product_id = p.id 
    WHERE w.user_id = ? 
    ORDER BY w.created_at DESC
");
$stmt->execute([$user_id]);
$wishlist_items = $stmt->fetchAll();
?> 

<div class="container py-5">
  <h1>My Wishlist</h1>

  <?php if (empty($wishlist_items)): ?>
    <div class="alert alert-info">Your wishlist is empty.</div>
    <a href="products.php" class="btn btn-primary">Browse Products</a>
  <?php else: ?>
    <div class="row">
      <?php foreach ($wishlist_items as $item): ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <?php
            // Determine image path
            $image_path = 'assets/images/products/' . ($item['image'] ?? 'placeholder.png');
            if (!empty($item['category_id'])) {
                switch($item['category_id']) {
                    case 1: $category_folder = 'attendance'; break;
                    case 2: $category_folder = 'lanyards'; break;
                    case 3: $category_folder = 'badges'; break;
                    case 4: $category_folder = 'erp'; break;
                    case 5: $category_folder = 'id-cards'; break;
                    default: $category_folder = 'general';
                }
                $potential_path = "assets/images/products/{$category_folder}/" . ($item['image'] ?? 'placeholder.png');
                if (file_exists(__DIR__ . '/' . $potential_path)) {
                    $image_path = $potential_path;
                }
            }
            ?>
            <img src="<?php echo htmlspecialchars($image_path); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['title']); ?>" style="height: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
              <p class="card-text fw-bold fs-5 text-primary">₹<?php echo number_format($item['price'], 2); ?></p>
              <div class="mt-auto">
                <a href="product.php?id=<?php echo $item['product_id']; ?>" class="btn btn-primary">View Details</a>
                <form method="post" class="d-inline">
                  <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                  <button type="submit" name="remove_from_wishlist" class="btn btn-outline-danger" title="Remove from Wishlist">
                    <i class="fas fa-heart-broken"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>