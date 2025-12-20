<footer class="footer-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                 <h5>Why Us?</h5>
                <ul class="list-unstyled footer-links">
                <p>Creative ID & Attendance Solutions. Fast, affordable, and tailored for schools, colleges, and corporate offices.</p>
                
                <!-- Newsletter Signup -->
                <div class="mt-4">
                    <h5>Newsletter</h5>
                    <p>Subscribe to get special offers and updates</p>
                    <form id="newsletter-form" class="d-flex">
                        <input type="email" class="form-control form-control-sm me-2" placeholder="Your email" required>
                        <button type="submit" class="btn btn-primary btn-sm">Subscribe</button>
                    </form>
                    <div id="newsletter-message" class="small mt-2"></div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5>Quick Links</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="about-new.php">About Us</a></li>
                    <li><a href="products-new.php">Products</a></li>
                    <li><a href="clients.php">Our Clients</a></li>
                    <li><a href="contact-new.php">Contact Us</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5>Support</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Help Center</a></li>
                    <li><a href="contact-new.php">Contact Us</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Returns</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5>Contact Us</h5>
                <ul class="list-unstyled footer-contact">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Simption Tech Pvt Ltd, B-32, IT Park Bhopal (M.P.) India</span>
                    </li>

                    <!-- Beautiful Footer Map -->
                    <div class="footer-map mt-3">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3664.305752083129!2d77.3629089751494!3d23.30466287897707!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x397c41e7bbf11fed%3A0x81f078b386370dd3!2sSimption%20Tech%20PVT%20LTD!5e0!3m2!1sen!2sin!4v1763371715695!5m2!1sen!2sin"
                        width="100%" 
                        height="170" 
                        style="border:0; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.15);" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>



                    <li>
                        <i class="fas fa-phone"></i>
                        <span>+91 9074822542</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>info@simption.com</span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5>Follow Us</h5>
                <div class="social-icons">
                    <a href="https://www.facebook.com/simption/" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" target="_blank" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/simptionbhopal/" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/simptiontechpvtltd/" target="_blank" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <div class="row footer-bottom">
            <div class="col-12 text-center">
                <p>&copy; <?php echo date('Y'); ?> Simption Tech. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Contact Modal -->
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="contactModalLabel">Quick Contact</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="contact_send.php" method="POST">
            <div class="mb-3">
                <label for="modal_name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="modal_name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="modal_email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="modal_email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="modal_subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="modal_subject" name="subject" required>
            </div>
            <div class="mb-3">
                <label for="modal_message" class="form-label">Message</label>
                <textarea class="form-control" id="modal_message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/drift-zoom/dist/Drift.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js"></script>
<script src="assets/js/main.min.js"></script>

<script>
// Newsletter form submission
document.getElementById('newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = this.querySelector('input[type="email"]').value;
    const messageDiv = document.getElementById('newsletter-message');
    
    // Simple email validation
    if (!email || !email.includes('@')) {
        messageDiv.innerHTML = '<span class="text-danger">Please enter a valid email address</span>';
        return;
    }
    
    // In a real implementation, this would send an AJAX request to subscribe the user
    messageDiv.innerHTML = '<span class="text-success">Thank you for subscribing to our newsletter!</span>';
    this.reset();
});
</script>

<?php if (isset($is_products_page) && $is_products_page === true): ?>
<!-- Filter Sidebar Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
    <div class="offcanvas-header bg-gradient-primary text-white">
        <h5 class="offcanvas-title d-flex align-items-center" id="filterOffcanvasLabel"><i class="fas fa-sliders-h me-2"></i>Filters</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="products-new.php" method="GET" id="filter-form">
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body">
                    <!-- Category Filter -->
                    <h6 class="fw-bold text-uppercase small mb-3 text-muted">Categories</h6>
                    <div class="filter-group">
                        <?php foreach ($categories as $category): ?>
                        <div class="form-check mb-2">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="categories[]" 
                                   value="<?php echo $category['id']; ?>" 
                                   id="cat_<?php echo $category['id']; ?>"
                                   <?php if (in_array($category['id'], $category_ids)) echo 'checked'; ?>>
                            <label class="form-check-label" for="cat_<?php echo $category['id']; ?>">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Price Range Filter -->
                    <h6 class="fw-bold text-uppercase small mb-3 mt-4 text-muted">Price Range</h6>
                    <div class="filter-group">
                        <div class="mb-3">
                            <label class="form-label small">Min Price (₹)</label>
                            <input type="number" name="min_price" class="form-control form-control-sm rounded-2" placeholder="0" value="<?php echo htmlspecialchars($min_price); ?>" min="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Max Price (₹)</label>
                            <input type="number" name="max_price" class="form-control form-control-sm rounded-2" placeholder="10000" value="<?php echo htmlspecialchars($max_price); ?>" min="0">
                        </div>
                    </div>
                    
                    <!-- Sort Options -->
                    <h6 class="fw-bold text-uppercase small mb-3 mt-4 text-muted">Sort By</h6>
                    <div class="filter-group">
                        <div class="mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort" value="latest" id="sort_latest" <?php if ($sort_option == 'latest') echo 'checked'; ?>>
                                <label class="form-check-label" for="sort_latest">Latest Products</label>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort" value="price_asc" id="sort_price_asc" <?php if ($sort_option == 'price_asc') echo 'checked'; ?>>
                                <label class="form-check-label" for="sort_price_asc">Price: Low to High</label>
                            </div>
                        </div>
                        <div class="mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="sort" value="price_desc" id="sort_price_desc" <?php if ($sort_option == 'price_desc') echo 'checked'; ?>>
                                <label class="form-check-label" for="sort_price_desc">Price: High to Low</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill"><i class="fas fa-filter me-2"></i>Apply Filters</button>
                        <a href="products-new.php" class="btn btn-outline-secondary rounded-pill"><i class="fas fa-times me-2"></i>Clear Filters</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>
</body>
</html>
