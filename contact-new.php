<?php 
require 'connection/db.php'; 
include 'includes/header.php'; 
?>

<main>
    <!-- Page Header -->
    <section class="page-header">
        <div class="container text-center">
            <h1 class="text-white">Contact Us</h1>
            <p class="text-white">We'd love to hear from you. Get in touch with us for any queries or support.</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row g-5">
                <!-- Contact Info -->
                <div class="col-lg-4">
                    <div class="contact-info-card mb-4">
                        <h3 class="mb-4">Get In Touch</h3>
                        <div class="contact-item mb-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0 icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>Our Location</h5>
                                    <p>Simption Tech Pvt Ltd, B-32, IT Park Bhopal (M.P.) India</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-item mb-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0 icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>Phone Number</h5>
                                    <p>+91 9074822542</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-item mb-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0 icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>Email Address</h5>
                                    <p>info@simption.com</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0 icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5>Working Hours</h5>
                                    <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                                    <p>Saturday: 10:00 AM - 4:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="contact-form-wrapper">
                        <h3 class="mb-4">Send us a Message</h3>
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="subject" class="form-label">Subject *</label>
                                    <input type="text" class="form-control" id="subject" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Your Message *</label>
                                <textarea class="form-control" id="message" rows="6" required></textarea>
                            </div>
                            
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="newsletter" value="newsletter">
                                <label class="form-check-label" for="newsletter">
                                    Subscribe to our newsletter for updates and offers
                                </label>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-title">Find Us on Map</h2>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="map-container" style="height: 400px; background-color: #eee; border-radius: 10px;">
                        <!-- Map would be embedded here -->
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <div class="text-center">
                                <i class="fas fa-map-marked-alt fa-3x mb-3" style="color: var(--primary-color);"></i>
                                <h4>Interactive Map</h4>
                                <p class="mb-0">Google Maps integration would appear here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>