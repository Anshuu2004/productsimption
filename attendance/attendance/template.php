<?php 
// This part of your PHP logic remains the same
require __DIR__ . '/../connection/db.php'; 
include __DIR__ . '/../includes/header.php'; 

if (empty($slug)) {
    echo "<div class='container section-padding'><p class='alert alert-danger'>Page not configured correctly.</p></div>";
    include __DIR__ . '/../includes/footer.php';
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM attendance_types WHERE slug = ? LIMIT 1");
$stmt->execute([$slug]);
$type = $stmt->fetch();

// If no data is found, show a simple error.
if (!$type) {
    echo "<div class='container section-padding'><p class='alert alert-warning'>Content for this page is coming soon.</p></div>";
    include __DIR__ . '/../includes/footer.php';
    exit;
}
?>

<main>
    <section class="page-header">
        <div class="container text-center">
            <h1 class="text-white"><?php echo htmlspecialchars($type['title']); ?></h1>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <img src="../assets/images/attendance/<?php echo htmlspecialchars($type['image']); ?>" class="img-fluid rounded shadow-lg" alt="<?php echo htmlspecialchars($type['title']); ?>">
                </div>
                <div class="col-lg-6">
                    <h2 class="section-title"><?php echo htmlspecialchars($type['title']); ?></h2>
                    <div class="lead">
                        <?php echo $type['content']; // This content is already HTML from your database ?>
                    </div>
                    <a href="../quote.php?service=<?php echo urlencode($type['title']); ?>" class="btn btn-primary mt-4">Get a Quote for this Solution</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/footer.php'; ?>