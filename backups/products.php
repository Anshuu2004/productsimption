<?php include 'connection/db.php'; include 'includes/header.php'; ?>
<h1>Products</h1>
<div class="row">
<?php
// Show all products - no limit to ensure nothing is hidden
$stmt = $pdo->query('SELECT * FROM products ORDER BY created_at DESC');
while($p = $stmt->fetch()):
  $image_path = 'assets/images/products/' . ($p['image'] ?? 'placeholder.png');
?>
  <div class="col-md-4 mb-3">
    <div class="card">
      <img src="<?=htmlspecialchars($image_path)?>" class="card-img-top" loading="lazy" alt="<?=htmlspecialchars($p['title'])?>">
      <div class="card-body">
        <h5 class="card-title"><?=htmlspecialchars($p['title'])?></h5>
        <p class="card-text"><?=htmlspecialchars(substr($p['description'] ?? '',0,120))?></p>
        <p class="fw-bold">₹<?=number_format($p['price'],2)?></p>
        <a href="product.php?id=<?=urlencode($p['id'])?>" class="btn btn-sm btn-primary">View</a>
      </div>
    </div>
  </div>
<?php endwhile; ?>
</div>
<?php include 'includes/footer.php'; ?>
