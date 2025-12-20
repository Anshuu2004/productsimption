<?php 
// This page uses the same header and footer.
include 'includes/header.php'; 
?>

<main>
    <section class="page-header">
        <div class="container text-center">
            <h1 class="text-white">Request a Quote</h1>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="contact-form-wrapper">
                        <div class="text-center mb-5">
                            <h2 class="section-title">Tell Us About Your Project</h2>
                            <p class="lead">Fill out the form below, and our team will get back to you with a custom quote as soon as possible.</p>
                        </div>

                        <form action="quote_send.php" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name*</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address*</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number*</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="company" class="form-label">School/Company Name</label>
                                    <input type="text" class="form-control" id="company" name="company">
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label">Which services are you interested in?</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="interest[]" value="ID Cards" id="checkIdCards">
                                        <label class="form-check-label" for="checkIdCards">ID-Card Designing</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="interest[]" value="Lanyards & Badges" id="checkLanyards">
                                        <label class="form-check-label" for="checkLanyards">Lanyards & Badges</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="interest[]" value="Attendance Systems" id="checkAttendance">
                                        <label class="form-check-label" for="checkAttendance">Attendance Systems</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="interest[]" value="ERP Solutions" id="checkErp">
                                        <label class="form-check-label" for="checkErp">ERP Solutions</label>
                                    </div>
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="message" class="form-label">Project Details</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Please describe your requirements, including quantity if applicable."></textarea>
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>