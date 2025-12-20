<?php 
require 'connection/db.php'; 
include 'includes/header.php'; 
?>

<main>
    <!-- Page Header -->
    <section class="page-header">
        <div class="container text-center">
            <h1 class="text-white">About Us</h1>
            <p class="text-white">Learn more about our journey and commitment to quality</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <img src="assets/images/general/about-image.jpg" class="img-fluid rounded shadow" alt="About Us">
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title">Our Story</h2>
                    <p class="lead">Founded in 2010, Simption Tech has been at the forefront of providing innovative ID and attendance solutions to educational institutions and corporate offices across India.</p>
                    <p>What started as a small venture with a team of 5 has now grown into a trusted partner for over 6,200 schools and colleges, delivering cutting-edge technology solutions that enhance security, efficiency, and professionalism.</p>
                    <p>Our commitment to quality, innovation, and customer satisfaction has made us a leader in the industry, with installations across all major cities in India.</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 icon me-3">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>6,200+ Schools Empowered</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 icon me-3">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>3,200+ RFID Systems</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 icon me-3">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>50+ Team Members</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 icon me-3">
                                    <i class="fas fa-check-circle text-success"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <strong>15+ Years Experience</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-title">Our Mission & Vision</h2>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-body text-center p-5">
                            <div class="icon mb-4">
                                <i class="fas fa-bullseye fa-3x" style="color: var(--primary-color);"></i>
                            </div>
                            <h3>Our Mission</h3>
                            <p class="mt-3">To empower educational institutions and businesses with innovative, reliable, and affordable ID and attendance solutions that enhance security, streamline operations, and improve overall efficiency.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card h-100">
                        <div class="card-body text-center p-5">
                            <div class="icon mb-4">
                                <i class="fas fa-eye fa-3x" style="color: var(--primary-color);"></i>
                            </div>
                            <h3>Our Vision</h3>
                            <p class="mt-3">To be the leading provider of ID and attendance solutions in India, recognized for our innovation, quality, and exceptional customer service, helping organizations create safer and more efficient environments.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-title">Our Core Values</h2>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="value-item text-center">
                        <div class="icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h4>Integrity</h4>
                        <p>We conduct business with honesty and transparency.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-item text-center">
                        <div class="icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h4>Innovation</h4>
                        <p>We constantly strive to develop better solutions.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-item text-center">
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Customer Focus</h4>
                        <p>Our customers' success is our top priority.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="value-item text-center">
                        <div class="icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <h4>Excellence</h4>
                        <p>We are committed to delivering the highest quality.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-title">Meet Our Leadership Team</h2>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <img src="assets/images/general/team-member.jpg" class="card-img-top" alt="Team Member">
                        <div class="card-body">
                            <h5>Mr. Sagar Sharma</h5>
                            <p class="text-muted">CEO & Founder</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <img src="assets/images/general/team-member.jpg" class="card-img-top" alt="Team Member">
                        <div class="card-body">
                            <h5>Ms. Priya Verma</h5>
                            <p class="text-muted">CTO</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <img src="assets/images/general/team-member.jpg" class="card-img-top" alt="Team Member">
                        <div class="card-body">
                            <h5>Mr. Rohan Gupta</h5>
                            <p class="text-muted">Operations Head</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center">
                        <img src="assets/images/general/team-member.jpg" class="card-img-top" alt="Team Member">
                        <div class="card-body">
                            <h5>Ms. Anjali Mehta</h5>
                            <p class="text-muted">Sales Director</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>