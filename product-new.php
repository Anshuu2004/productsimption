<?php 
require 'connection/db.php'; 
include 'includes/header.php'; 

// 1. Get the product ID from the URL and validate it
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    // If no valid ID, redirect to the homepage
    header("Location: index.php");
    exit;
}

// 2. Fetch the product from the database
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

// 3. If no product is found with that ID, redirect
if (!$product) {
    header("Location: index.php");
    exit;
}
?>

<main>
    <!-- Breadcrumb -->
    <section class="py-3" style="background-color: var(--light-gray);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="products-new.php">Products</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['title']); ?></li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Product Detail Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="product-image-gallery">
                        <?php 
                            $image_path = 'assets/images/products/' . ($product['image'] ?? 'placeholder.png'); 
                            $large_image_path = $image_path; 
                        ?>
                        <a href="assets/images/products/<?php echo htmlspecialchars($product['image'] ?? 'placeholder.png'); ?>" class="zoom-link">
                            <img src="<?php echo htmlspecialchars($image_path); ?>" 
                                class="main-product-image" 
                                data-zoom="assets/images/products/<?php echo htmlspecialchars($product['image'] ?? 'placeholder.png'); ?>"
                                alt="<?php echo htmlspecialchars($product['title']); ?>">
                        </a>
                    </div>
                    <div class="zoom-pane"></div>
                </div>

                <div class="col-lg-6">
                    <h1 class="product-page-title"><?php echo htmlspecialchars($product['title']); ?></h1>
                    <p class="product-page-price">₹<?php echo number_format($product['price'], 2); ?></p>
                    <p class="lead"><?php echo htmlspecialchars($product['description']); ?></p>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" id="quantity" class="form-control quantity-input" value="1" min="1">
                    </div>

                    <div class="mt-4">
                        <a href="quote.php?product_id=<?php echo $product['id']; ?>" class="btn btn-primary btn-lg">Get a Quote</a>
                        <a href="contact.php" class="btn btn-secondary btn-lg ms-2">Ask a Question</a>
                    </div>

                    <!-- Product Meta -->
                    <div class="mt-5">
                        <h5>Product Details</h5>
                        <table class="table">
                            <tr>
                                <td><strong>Category:</strong></td>
                                <td>Custom Printing</td>
                            </tr>
                            <tr>
                                <td><strong>Material:</strong></td>
                                <td>PVC</td>
                            </tr>
                            <tr>
                                <td><strong>Size:</strong></td>
                                <td>85.60 × 53.98 mm</td>
                            </tr>
                            <tr>
                                <td><strong>Delivery Time:</strong></td>
                                <td>5-7 Business Days</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Product Tabs -->
            <div class="row mt-5">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">Specifications</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content p-4 border border-top-0">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                            <p>Our custom printed ID cards are perfect for schools, colleges, and corporate offices. Made with high-quality PVC material, these cards are durable and long-lasting. We offer a variety of printing options including UV printing, laser engraving, and thermal transfer printing.</p>
                        </div>
                        <div class="tab-pane fade" id="specs" role="tabpanel">
                            <h5>Technical Specifications</h5>
                            <ul>
                                <li><strong>Product Type:</strong> UV Printed ID Card</li>
                                <li><strong>Material:</strong> High-quality PVC (Polyvinyl Chloride)</li>
                                <li><strong>Dimensions:</strong> Standard CR80 size (85.60 mm x 53.98 mm)</li>
                                <li><strong>Thickness:</strong> 0.76 mm (30 mil)</li>
                                <li><strong>Printing Technology:</strong> Advanced UV Printing</li>
                                <li><strong>Features:</strong>
                                    <ul>
                                        <li>Vibrant, full-color, edge-to-edge printing</li>
                                        <li>High-resolution text and graphics</li>
                                        <li>Extremely durable and resistant to fading, scratching, and water damage</li>
                                        <li>Raised, textured, or glossy spot finishes available</li>
                                        <li>Fast curing process for quick production</li>
                                        <li>Environmentally friendly with low VOC emissions</li>
                                    </ul>
                                </li>
                                <li><strong>Applications:</strong> Corporate ID badges, student IDs, membership cards, loyalty cards, gift cards, access control cards.</li>
                                <li><strong>Customization:</strong>
                                    <ul>
                                        <li>Single or double-sided printing</li>
                                        <li>Variable data printing (names, photos, numbers)</li>
                                        <li>Security features (holograms, microtext, UV ink)</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="review-item mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="assets/images/general/user-placeholder.png" class="rounded-circle" width="50" alt="User">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6>Rahul Sharma</h6>
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <p class="mt-2">Excellent quality ID cards! The printing is crisp and clear. Delivery was on time. Highly recommended!</p>
                                    </div>
                                </div>
                            </div>
                            <div class="review-item">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="assets/images/general/user-placeholder.png" class="rounded-circle" width="50" alt="User">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6>Priya Patel</h6>
                                        <div class="text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <p class="mt-2">Good quality cards with vibrant colors. The lamination makes them durable. Will order again.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">Related Products</h3>
                    <div class="row g-4">
                        <?php
                        // Fetch related products
                        $stmt = $pdo->prepare("SELECT * FROM products WHERE id != ? ORDER BY RAND() LIMIT 4");
                        $stmt->execute([$id]);
                        while ($related = $stmt->fetch()):
                        ?>
                        <div class="col-lg-3 col-md-6">
                            <div class="product-card">
                                <a href="product-new.php?id=<?php echo $related['id']; ?>">
                                    <img src="assets/images/products/<?php echo htmlspecialchars($related['image'] ?? 'placeholder.png'); ?>" 
                                         class="product-card-img" 
                                         alt="<?php echo htmlspecialchars($related['title']); ?>">
                                </a>
                                <div class="product-card-body">
                                    <h5 class="product-title">
                                        <a href="product-new.php?id=<?php echo $related['id']; ?>">
                                            <?php echo htmlspecialchars(substr($related['title'], 0, 30)); ?>
                                            <?php if (strlen($related['title']) > 30) echo '...'; ?>
                                        </a>
                                    </h5>
                                    <p class="product-price">₹<?php echo number_format($related['price'], 2); ?></p>
                                    <a href="product-new.php?id=<?php echo $related['id']; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>