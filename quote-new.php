<?php 
require 'connection/db.php'; 
include 'includes/header.php'; 
?>

<main>
    <!-- Page Header -->
    <section class="page-header">
        <div class="container text-center">
            <h1 class="text-white">Get a Quote</h1>
            <p class="text-white">Tell us about your requirements and we'll get back to you with a customized quote</p>
        </div>
    </section>

    <!-- Quote Form Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body p-5">
                            <h3 class="text-center mb-4">Request a Custom Quote</h3>
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
                                        <label for="phone" class="form-label">Phone Number *</label>
                                        <input type="tel" class="form-control" id="phone" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="company" class="form-label">Company Name</label>
                                        <input type="text" class="form-control" id="company">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="interests" class="form-label">Product/Service Interest *</label>
                                    <select class="form-select" id="interests" required>
                                        <option value="">Select Product/Service</option>
                                        <option>ID Cards</option>
                                        <option>Lanyards & Badges</option>
                                        <option>Attendance Systems</option>
                                        <option>ERP Solutions</option>
                                        <option>Custom Printing</option>
                                        <option>Other</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity Required</label>
                                    <input type="number" class="form-control" id="quantity" min="1" value="1">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="message" class="form-label">Additional Details *</label>
                                    <textarea class="form-control" id="message" rows="5" placeholder="Please provide details about your requirements, specifications, and any special requests..." required></textarea>
                                </div>
                                
                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="bulkOrder" value="bulk">
                                    <label class="form-check-label" for="bulkOrder">
                                        I'm interested in bulk ordering
                                    </label>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-title">Why Choose Our Custom Printing Services</h2>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="trust-badge">
                        <div class="icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4>Quick Turnaround</h4>
                        <p>Fast delivery without compromising on quality</p>
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
                            <i class="fas fa-rupee-sign"></i>
                        </div>
                        <h4>Competitive Pricing</h4>
                        <p>Best prices for premium custom printing services</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>