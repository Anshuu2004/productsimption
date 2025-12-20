<?php 
require 'connection/db.php'; 
include 'includes/header.php'; 
?> 

<div class="container py-5">
  <h2>Badge Designing</h2>
  <p class="text-muted">Choose plastic, metal or premium badges for events and staff.</p>

  <div class="row g-3">
    <?php 
    // Fetch products with category_id = 3 (Badges & Reels)
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = 3 ORDER BY created_at DESC");
    $stmt->execute(); 

    while ($p = $stmt->fetch()): 
      $img = 'assets/images/products/' . ($p['image'] ?? 'placeholder.png'); 
    ?>
      <div class="col-sm-6 col-md-4 col-lg-3">
        <div class="card product-card" 
             tabindex="0" 
             data-large="<?php echo htmlspecialchars($img); ?>" 
             onclick="location.href='product.php?id=<?php echo $p['id']; ?>'">

          <img src="<?php echo htmlspecialchars($img); ?>" 
               class="card-img-top product-image" 
               alt="<?php echo htmlspecialchars($p['title']); ?>">

          <div class="card-body">
            <h6 class="card-title small">
              <?php echo htmlspecialchars($p['title']); ?>
            </h6>

            <div class="d-flex justify-content-between align-items-center">
              <div class="price">
                ₹ <?php echo number_format($p['price'], 2); ?>
              </div>
              <a href="product.php?id=<?php echo $p['id']; ?>" 
                 class="btn btn-sm btn-secondary">
                View
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
