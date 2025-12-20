<?php
$is_products_page = true;
require 'connection/db.php';
require 'includes/filter-logic.php';
include 'includes/header.php';
?>

<main>
    <!-- Page Header -->
    <section class="page-header bg-gradient-primary">
        <div class="container text-center">
            <h1 class="text-white fw-bold">Our Products</h1>
            <p class="text-white">Discover our wide range of custom printing solutions</p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-12">
                    <!-- Toolbar -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0 fw-bold">All Products (<span id="product-count"><?php echo $total_products; ?></span>)</h2>
                        <div class="d-flex align-items-center">
                            <!-- Filter Button -->
                            <button class="btn btn-outline-primary me-2 rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas" aria-controls="filterOffcanvas">
                                <i class="fas fa-sliders-h me-1"></i> Filters
                            </button>
                            
                            <!-- Desktop Filter and Sort -->
                            <div class="d-none d-lg-flex align-items-center">
                                <div class="me-2">
                                    <select class="form-select form-select-sm rounded-pill" id="sort-by" style="width: auto;">
                                        <option value="latest" <?php if (isset($sort_option) && $sort_option == 'latest') echo 'selected'; ?>>Sort by: Latest</option>
                                        <option value="price_asc" <?php if (isset($sort_option) && $sort_option == 'price_asc') echo 'selected'; ?>>Price: Low to High</option>
                                        <option value="price_desc" <?php if (isset($sort_option) && $sort_option == 'price_desc') echo 'selected'; ?>>Price: High to Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="row g-4" id="product-grid">
                        <?php while ($product = $stmt->fetch()): ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="card product-card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                <a href="product.php?id=<?php echo $product['id']; ?>">
                                    <img src="assets/images/products/<?php echo htmlspecialchars($product['image'] ?? 'placeholder.png'); ?>" 
                                         class="card-img-top" 
                                         alt="<?php echo htmlspecialchars($product['title']); ?>" style="height: 200px; object-fit: cover;">
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="product-title fw-bold">
                                        <a href="product.php?id=<?php echo $product['id']; ?>" class="text-decoration-none text-dark">
                                            <?php echo htmlspecialchars(substr($product['title'], 0, 30)); ?>
                                            <?php if (strlen($product['title']) > 30) echo '...'; ?>
                                        </a>
                                    </h5>
                                    <p class="product-price fw-bold fs-5 text-primary mb-0">₹<?php echo number_format($product['price'], 2); ?></p>
                                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary w-100 rounded-pill mt-3">View Details</a>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-5" id="pagination-container">
                        <ul class="pagination justify-content-center">
                            <?php
                            // Build query string for pagination links
                            $query_params = $_GET;
                            unset($query_params['page']);
                            $query_string = http_build_query($query_params);
                            ?>
                            
                            <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link rounded-pill" href="?page=<?php echo $page - 1; ?>&<?php echo $query_string; ?>">Previous</a>
                            </li>
                            <?php endif; ?>
                            
                            <?php
                            // Show first page
                            if ($page > 3) {
                                echo '<li class="page-item"><a class="page-link rounded-pill" href="?page=1&' . $query_string . '">1</a></li>';
                                if ($page > 4) echo '<li class="page-item disabled"><span class="page-link rounded-pill">...</span></li>';
                            }
                            
                            // Show pages around current page
                            for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++) {
                                if ($i == $page) {
                                    echo '<li class="page-item active"><span class="page-link rounded-pill">' . $i . '</span></li>';
                                } else {
                                    echo '<li class="page-item"><a class="page-link rounded-pill" href="?page=' . $i . '&' . $query_string . '">' . $i . '</a></li>';
                                }
                            }
                            
                            // Show last page
                            if ($page < $total_pages - 2) {
                                if ($page < $total_pages - 3) echo '<li class="page-item disabled"><span class="page-link rounded-pill">...</span></li>';
                                echo '<li class="page-item"><a class="page-link rounded-pill" href="?page=' . $total_pages . '&' . $query_string . '">' . $total_pages . '</a></li>';
                            }
                            ?>
                            
                            <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a class="page-link rounded-pill" href="?page=<?php echo $page + 1; ?>&<?php echo $query_string; ?>">Next</a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>