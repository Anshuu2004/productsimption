<?php
require 'connection/db.php';
include 'includes/header.php';
?>

<main>
    <!-- Hero Section (Carousel) -->
    <section class="hero-section p-0">
        <div class="hero-carousel" id="heroCarousel" aria-label="Featured promotions">
            <div class="carousel-track">
                <?php
                $dir = __DIR__ . '/assets/images/general';
                $slides = [];
                if (is_dir($dir)) {
                    $all = scandir($dir);
                    foreach ($all as $f) {
                        if ($f === '.' || $f === '..') continue;
                        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                        if (in_array($ext, ['jpg', 'jpeg'])) {
                            $slides[] = $f;
                        }
                    }
                }
                sort($slides, SORT_NATURAL | SORT_FLAG_CASE);
                $index = 0;
                foreach ($slides as $file):
                    $url = 'assets/images/general/' . rawurlencode($file);
                ?>
                <?php if ($index == 4): ?>
                <div class="carousel-slide" data-index="<?php echo $index; ?>" style="background-image: url('<?php echo $url; ?>');">
                    <div class="carousel-overlay container">
                        <div class="row">
                            <div class="col-lg-8">
                                <h1 class="hero-title">School Management Software</h1>
                                <p class="hero-subtitle lead my-4">School Software Development, Website Designing, RFID Card & Face base Attendance System & Android App.</p>
                                <a href="quote.php" class="btn btn-primary btn-lg me-2">Get a Quote</a>
                                <a href="products.php" class="btn btn-secondary btn-lg">Explore Products</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="carousel-slide" data-index="<?php echo $index; ?>" style="background-image: url('<?php echo $url; ?>');">
                    <div class="carousel-overlay container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="promo-badge">Featured</div>
                                <h1 class="hero-title">Discover What’s New</h1>
                                <p class="hero-subtitle lead my-4">High-quality solutions tailored for schools and businesses.</p>
                                <a href="quote.php" class="btn btn-primary btn-lg me-2">Get a Quote</a>
                                <a href="products.php" class="btn btn-secondary btn-lg">Explore Products</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php $index++; endforeach; ?>
            </div>
            <button class="carousel-arrow prev" aria-label="Previous slide">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-arrow next" aria-label="Next slide">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="carousel-dots" role="tablist" aria-label="Carousel Pagination"></div>
        </div>
    </section>

    <!-- Most Popular Products -->
    <section class="section-padding">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-title">Most Popular Products</h2>
                    <p class="lead">Discover our best selling custom printing solutions</p>
                </div>
            </div>

            <div class="row g-4">
                <?php
                // Fetch popular products from the database
                $stmt = $pdo->query("SELECT * FROM products ORDER BY id ASC LIMIT 8");
                while ($product = $stmt->fetch()):
                ?>
                <div class="col-lg-3 col-md-6">
                    <div class="product-card">
                        <?php if ($product['id'] <= 2): ?>
                        <span class="product-badge">NEW</span>
                        <?php elseif ($product['id'] == 5): ?>
                        <span class="product-badge">FEATURED</span>
                        <?php endif; ?>
                        <?php 
                        // Determine category folder for index page product images
                        $category_folder = 'general';
                        if (!empty($product['category_id'])) {
                            switch($product['category_id']) {
                                case 1: $category_folder = 'attendance'; break;
                                case 2: $category_folder = 'lanyards'; break;
                                case 3: $category_folder = 'badges'; break;
                                case 4: $category_folder = 'erp'; break;
                                default: $category_folder = 'general';
                            }
                        } else {
                            // For products without category, try to determine from title
                            $title = strtolower($product['title']);
                            if (strpos($title, 'id card') !== false || strpos($title, 'pvc') !== false || strpos($title, 'rfid') !== false || strpos($title, 'uv') !== false) {
                                $category_folder = 'id-cards';
                            } else if (strpos($title, 'lanyard') !== false) {
                                $category_folder = 'lanyards';
                            } else if (strpos($title, 'badge') !== false) {
                                $category_folder = 'badges';
                            }
                        }
                        
                        // Construct image path
                        $image_filename = $product['image'] ?? 'placeholder.png';
                        $image_path = "assets/images/products/{$category_folder}/{$image_filename}";
                        
                        // Fallback to general if specific category image doesn't exist
                        if (!file_exists(__DIR__ . "/{$image_path}")) {
                            $image_path = "assets/images/products/{$image_filename}";
                        }
                        ?>
                        <a href="product.php?id=<?php echo $product['id']; ?>">
                            <img src="<?php echo htmlspecialchars($image_path); ?>" 
                                 class="product-card-img" 
                                 loading="lazy"
                                 alt="<?php echo htmlspecialchars($product['title']); ?>">
                        </a>
                        <div class="product-card-body">
                            <h5 class="product-title">
                                <a href="product.php?id=<?php echo $product['id']; ?>">
                                    <?php echo htmlspecialchars(substr($product['title'], 0, 30)); ?>
                                    <?php if (strlen($product['title']) > 30) echo '...'; ?>
                                </a>
                            </h5>
                            <p class="product-price">₹<?php echo number_format($product['price'], 2); ?></p>
                            <a href="product.php?id=<?php echo $product['id']; ?>" class="btn">Order Now</a>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Category Cards / Quick Shop -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-title">Quick Shop by Category</h2>
                    <p class="lead">Find exactly what you're looking for</p>
                </div>
            </div>

            <div class="category-scroll-container">
                <a href="id-cards.php" class="category-card text-decoration-none">
                    <div class="icon"><i class="fas fa-id-card"></i></div>
                    <h5>ID Cards</h5>
                </a>
                <a href="attendance.php" class="category-card text-decoration-none">
                    <div class="icon"><i class="fas fa-user-check"></i></div>
                    <h5>Attendance Devices</h5>
                </a>
                <a href="lanyard.php" class="category-card text-decoration-none">
                    <div class="icon"><i class="fas fa-link"></i></div>
                    <h5>Lanyards</h5>
                </a>
                <a href="badge.php" class="category-card text-decoration-none">
                    <div class="icon"><i class="fas fa-award"></i></div>
                    <h5>Badges</h5>
                </a>
                <a href="erp.php" class="category-card text-decoration-none">
                    <div class="icon"><i class="fas fa-laptop-code"></i></div>
                    <h5>ERP & Software</h5>
                </a>
                <a href="products.php" class="category-card text-decoration-none">
                    <div class="icon"><i class="fas fa-print"></i></div>
                    <h5>Printing & Branding</h5>
                </a>
                <a href="products.php" class="category-card text-decoration-none">
                    <div class="icon"><i class="fas fa-toolbox"></i></div>
                    <h5>Accessories</h5>
                </a>
            </div>
        </div>
    </section>

    <!-- Trust Badges -->
    <section class="section-padding">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-title">Why Choose Us</h2>
                    <p class="lead">Trusted by thousands of customers across India</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="trust-badge">
                        <div class="icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4>Quick Delivery</h4>
                        <p>Fast turnaround times without compromising on quality</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="trust-badge">
                        <div class="icon">
                            <i class="fas fa-paint-brush"></i>
                        </div>
                        <h4>Custom Design</h4>
                        <p>Professional designers to bring your vision to life</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="trust-badge">
                        <div class="icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <h4>Premium Quality</h4>
                        <p>Only the best materials and printing techniques</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="trust-badge">
                        <div class="icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>24/7 Support</h4>
                        <p>Dedicated customer service team always ready to help</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-title">Trusted by Thousands Across India</h2>
                </div>
            </div>

            <div class="row text-center mb-5">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <h3>6,200+</h3>
                        <p>Schools Empowered</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <h3>2,800+</h3>
                        <p>Websites Delivered</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <h3>3,200+</h3>
                        <p>RFID Systems Installed</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <h3>50+</h3>
                        <p>Team Members</p>
                    </div>
                </div>
            </div>

            <div class="row align-items-center g-4">
                <?php
                // Fetch clients from the database
                $stmt = $pdo->query("SELECT * FROM clients ORDER BY name ASC LIMIT 12");
                while ($client = $stmt->fetch()):
                    // Make sure the path to your client logos is correct
                    $logo_path = 'assets/images/clients/' . ($client['logo'] ?? 'placeholder.png');
                ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="client-logo">
                        <img src="<?php echo htmlspecialchars($logo_path); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($client['name']); ?>">
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="section-padding final-cta">
        <div class="container text-center">
            <h2 class="text-white">Ready to Start Your Project?</h2>
            <p class="lead text-white-50">Let's create a solution that fits your needs and budget.</p>
            <a href="quote.php" class="btn btn-primary btn-lg mt-4">Get a Quote</a>
        </div>
    </section>
</main>

<!-- Floating Chat Bubble -->
<div class="floating-chat">
    <i class="fas fa-comments"></i>
</div>

<?php include 'includes/footer.php'; ?>