<?php 
require 'connection/db.php'; 
include 'includes/header.php'; 

// Fetch all attendance types from the database
$stmt = $pdo->query("SELECT * FROM attendance_types ORDER BY id ASC");
$attendance_types = $stmt->fetchAll();
?>

<main>
    <section class="page-header">
        <div class="container text-center">
            <h1 class="text-white">Attendance Management Systems</h1>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-title">A Solution for Every Need</h2>
                    <p class="lead">From contactless RFID and advanced face recognition to mobile geo-fencing, we offer a complete range of attendance systems designed for modern schools, colleges, and businesses.</p>
                </div>
            </div>

            <div class="row g-4">
                <?php foreach ($attendance_types as $type): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="solution-card h-100">
                        <div class="icon">
                            <i class="fas fa-check-circle"></i> 
                        </div>
                        <h3><?php echo htmlspecialchars($type['title']); ?></h3>
                        <p><?php echo htmlspecialchars($type['short_desc']); ?></p>
                        <a href="attendance/<?php echo htmlspecialchars($type['slug']); ?>.php" class="stretched-link"></a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>