<?php
require 'connection/db.php';
include 'includes/header.php';

$moduleId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$moduleId) {
    header("Location: erp.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM erp_modules WHERE id = ?");
$stmt->execute([$moduleId]);
$module = $stmt->fetch();

// If module is not found in DB, create a placeholder module array
if (!$module) {
    $module = [
        'id' => $moduleId,
        'slug' => 'unknown',
        'title' => 'Unknown ERP Module',
        'description' => 'Details for this ERP module are not yet available.'
    ];
}

// Enhanced descriptions based on module ID, prioritizing consistency with header links
$enhancedDescription = '';
$displayTitle = $module['title']; // Default to DB title
$tagline = '';
$featuresList = [];
$image = 'erp_placeholder.png'; // Default image

switch ($moduleId) {
    case 1:
        $displayTitle = "School Management Software";
        $tagline = "Streamline every aspect of academic and administrative management.";
        $enhancedDescription = "<p>The School Management System is a comprehensive platform designed to streamline all administrative and academic operations of educational institutions. It covers student admissions, attendance tracking, grade management, timetable scheduling, fee collection, and communication with parents. This module centralizes data, reduces manual workload, and enhances overall efficiency, allowing educators to focus more on teaching and learning.</p>";
        $featuresList = [
            "Student Management", "Academic Management", "Fee Management", "Staff Management",
            "Library Management", "Hostel Management", "Transport Management", "RFID & Biometric Attendance",
            "Live Bus Tracking", "Mobile Apps", "Online Learning", "Bulk SMS & Communication"
        ];
        $image = 'erp_school_management.png';
        break;
    case 2:
        $displayTitle = "Attendance Management Systems";
        $tagline = "Advanced tools for tracking and managing student and staff attendance.";
        $enhancedDescription = "<p>Our Attendance Management System provides advanced tools for tracking and managing student and staff attendance across various departments. It supports multiple attendance methods including biometric (fingerprint, face recognition), RFID, QR codes, and manual entry. The system offers real-time attendance monitoring, automated reporting, and seamless integration with payroll and student information systems. It helps reduce absenteeism, ensures accurate record-keeping, and provides valuable insights into attendance patterns.</p>";
        $featuresList = [
            "Multiple Attendance Methods (Biometric, RFID, QR)", "Real-time Monitoring", "Automated Reporting",
            "Seamless Integration", "Leave Management", "Holiday Settings"
        ];
        $image = 'erp_attendance_system.png';
        break;
    case 3:
        $displayTitle = "Website Development Services";
        $tagline = "Professional website development tailored for educational institutions and businesses.";
        $enhancedDescription = "<p>We offer professional website development services tailored for educational institutions and businesses. From responsive designs to robust backend systems, we build engaging and functional websites that enhance your online presence and streamline operations. Our services include custom design, e-commerce integration, content management systems, and ongoing maintenance.</p>";
        $featuresList = [
            "Modern UI/UX", "SEO Optimization", "Secure Coding Practices", "Scalable Architecture",
            "Custom Design", "E-commerce Integration", "CMS Development", "Ongoing Maintenance"
        ];
        $image = 'erp_website_development.png';
        break;
    case 4:
        $displayTitle = "Android App Development";
        $tagline = "Custom mobile applications to extend your reach and improve user engagement.";
        $enhancedDescription = "<p>Our Android App Development services provide custom mobile applications designed to extend your reach and improve user engagement. We build native Android apps for various purposes, including student/parent portals, attendance tracking, communication platforms, and educational tools. Our apps are user-friendly, high-performing, and integrate seamlessly with your existing systems.</p>";
        $featuresList = [
            "Custom Native Android Apps", "Student/Parent Portals", "Teacher Apps", "Admin Apps",
            "Bus Driver Apps", "Push Notifications", "Offline Capabilities", "Secure Data Handling"
        ];
        $image = 'erp_android_apps.png';
        break;
    case 5:
        $displayTitle = "Communication Services";
        $tagline = "Integrated solutions for schools and businesses to connect with students, parents, and staff.";
        $enhancedDescription = "<p>Effective communication is key to success. Our communication services provide integrated solutions for schools and businesses to connect with students, parents, and staff. This includes SMS alerts, email notifications, in-app messaging, and announcement boards. Ensure timely dissemination of important information, emergency alerts, and daily updates.</p>";
        $featuresList = [
            "SMS Alerts", "Email Notifications", "In-app Messaging", "Announcement Boards",
            "Bulk Messaging", "Scheduled Communications", "Delivery Reports", "Customizable Templates"
        ];
        $image = 'erp_communication_services.png';
        break;
    case 6:
        $displayTitle = "Bus Tracking System";
        $tagline = "Ensure the safety and punctuality of student transportation with real-time GPS tracking.";
        $enhancedDescription = "<p>Ensure the safety and punctuality of student transportation with our advanced Bus Tracking System. This module provides real-time GPS tracking of school buses, route optimization, and instant notifications for parents regarding bus location and estimated arrival times. It enhances security, improves operational efficiency, and offers peace of mind.</p>";
        $featuresList = [
            "Real-time GPS Tracking", "Route Optimization", "Parent Notifications", "Live Tracking Maps",
            "Driver Management", "Historical Data Analysis", "Geofencing"
        ];
        $image = 'erp_bus_tracking.png';
        break;
    case 7:
        $displayTitle = "Online Learning Solutions";
        $tagline = "Empower your institution with modern online learning capabilities and virtual classrooms.";
        $enhancedDescription = "<p>Empower your institution with modern online learning capabilities. Our solutions provide robust Learning Management Systems (LMS) for delivering courses, managing assignments, conducting online assessments, and facilitating virtual classrooms. Support blended learning models and ensure continuous education with interactive and engaging digital content.</p>";
        $featuresList = [
            "Learning Management System (LMS)", "Online Assessments", "Virtual Classrooms",
            "Course Creation Tools", "Student Progress Tracking", "Secure Content Delivery"
        ];
        $image = 'erp_online_learning.png';
        break;
    default:
        $tagline = "Comprehensive solutions for modern institutions.";
        $enhancedDescription = "<p>" . htmlspecialchars($module['description']) . "</p>";
        break;
}

// If module was not found in DB, use the displayTitle for the page title
if ($module['slug'] === 'unknown') {
    $pageTitle = $displayTitle;
} else {
    $pageTitle = htmlspecialchars($module['title']);
}
?>

<main>
    <!-- Hero Section for ERP Module -->
    <section class="page-header erp-hero">
        <div class="container text-center">
            <h1 class="text-white"><?php echo $displayTitle; ?></h1>
            <p class="lead text-white-50"><?php echo $tagline; ?></p>
        </div>
    </section>

    <!-- Module Detail Section -->
    <section class="section-padding">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="mb-4"><?php echo $displayTitle; ?> Overview</h2>
                    <?php echo $enhancedDescription; ?>
                    <div class="mt-4">
                        <a href="https://simption.com/" class="btn btn-primary btn-lg" target="_blank">Learn More & Buy</a>
                        <a href="quote.php?module_id=<?php echo $module['id']; ?>" class="btn btn-secondary btn-lg ms-3">Get a Quote</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="assets/images/general/<?php echo htmlspecialchars($image); ?>" class="img-fluid rounded-3 shadow-lg" alt="<?php echo $displayTitle; ?>">
                </div>
            </div>

            <?php if (!empty($featuresList)): ?>
            <div class="row mt-5 pt-5">
                <div class="col-12 text-center mb-4">
                    <h2 class="section-title">Key Features</h2>
                </div>
                <div class="row g-4">
                    <?php foreach ($featuresList as $feature): ?>
                    <div class="col-md-4">
                        <div class="feature-item">
                            <i class="fas fa-check-circle feature-icon"></i>
                            <h5><?php echo htmlspecialchars($feature); ?></h5>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="text-center mt-5 pt-5">
                <p class="lead">Ready to transform your institution? Contact us today!</p>
                <a href="contact.php" class="btn btn-primary btn-lg">Contact Us</a>
            </div>

        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>