<footer class="footer-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                 <h5>Why Us?</h5>
                <ul class="list-unstyled footer-links">
                <p>Creative ID & Attendance Solutions. Fast, affordable, and tailored for schools, colleges, and corporate offices.</p>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5>Quick Links</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="clients.php">Our Clients</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6">
                <h5>Support</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="#">Help Center</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
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


                 <li>
                        <i class="fas fa-phone"></i>
                        <span>+91 9074822542</span>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <span>info@simption.com</span>
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
<script src="assets/js/main.min.js"></script>

</body>
</html>