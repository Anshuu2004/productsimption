<?php 
require 'connection/db.php'; 
include 'includes/header.php'; 
?> 

<main>
    <section class="page-header">
        <div class="container text-center">
            <h1 class="text-white">About Simption Tech</h1>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">Our Story</h2>
                    <p class="lead">
                        Welcome to Simption Tech, where we blend creativity with technology to provide fast, affordable, and reliable solutions. Our mission is to empower schools, colleges, and corporate offices with the tools they need to succeed in a modern world. From custom ID cards to comprehensive ERP systems, we are dedicated to quality and customer satisfaction.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding" style="background-color: var(--light-gray);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4">
                    <h2 class="section-title">What We Do</h2>
                    <p>We provide a wide range of services to cover all your institutional needs.</p>
                </div>
                <div class="col-lg-7 offset-lg-1">
                    <ul class="list-unstyled service-list">
                        <li><i class="fas fa-check-circle"></i> School & College Management ERP</li>
                        <li><i class="fas fa-check-circle"></i> Advanced Attendance Systems</li>
                        <li><i class="fas fa-check-circle"></i> Custom ID Cards, Lanyards & Badges</li>
                        <li><i class="fas fa-check-circle"></i> Dynamic Website Development</li>
                        <li><i class="fas fa-check-circle"></i> Custom Android App Development</li>
                        <li><i class="fas fa-check-circle"></i> Bulk SMS & Communication Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    
    <section class="section-padding">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-8 mx-auto mb-5">
                    <h2 class="section-title">Our Core Values</h2>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-item">
                        <div class="icon"><i class="fas fa-lightbulb"></i></div>
                        <h3>Creativity</h3>
                        <p>We design innovative and custom solutions that perfectly match your brand's unique identity.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-item">
                        <div class="icon"><i class="fas fa-rocket"></i></div>
                        <h3>Speed</h3>
                        <p>Our efficient processes ensure you get your high-quality products and services delivered on time, every time.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="value-item">
                        <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
                        <h3>Affordability</h3>
                        <p>We believe powerful technology should be accessible. We provide top-tier solutions that fit your budget.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include 'includes/footer.php'; ?>
