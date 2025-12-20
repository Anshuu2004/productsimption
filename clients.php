<?php 
require 'connection/db.php'; 
include 'includes/header.php'; 
?> 

<div class="container py-5">
  <h2>Our Clients</h2>
  <p class="text-muted">Trusted by schools, colleges and businesses.</p>

  <div class="row g-3">
    <?php 
    $stmt = $pdo->query("SELECT * FROM clients ORDER BY created_at DESC"); 
    while ($c = $stmt->fetch()): 
      $logo = 'assets/images/clients/' . ($c['logo'] ?? 'client_placeholder.png'); 
    ?>
      <div class="col-6 col-md-4 col-lg-3 text-center">
        <div class="card p-3">
          <img src="<?php echo htmlspecialchars($logo); ?>" 
               class="img-fluid client-logo mx-auto" 
               alt="<?php echo htmlspecialchars($c['name']); ?>">

          <div class="card-body">
            <h6 class="card-title mb-0">
              <?php echo htmlspecialchars($c['name']); ?>
            </h6>
            <small class="text-muted">
              <?php echo htmlspecialchars($c['city']); ?>
            </small>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
