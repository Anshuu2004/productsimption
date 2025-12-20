<?php
require '../connection/db.php';

if (!isset($_SESSION['admin_user'])) {
    header('Location: login.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: quotes.php');
    exit;
}

// Fetch the specific quote request
$stmt = $pdo->prepare("SELECT * FROM quote_requests WHERE id = ?");
$stmt->execute([$id]);
$quote = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$quote) {
    header('Location: quotes.php');
    exit;
}

include '../includes/header.php';
?>

<main>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">View Quote Request</h1>
            <a href="quotes.php" class="btn btn-secondary">
                 <i class="fas fa-arrow-left me-2"></i>Back to Requests
            </a>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <strong>From:</strong> <?php echo htmlspecialchars($quote['name']); ?><br>
                    <strong>Company:</strong> <?php echo htmlspecialchars($quote['company']); ?>
                </div>
                <div>
                    <strong>Received:</strong> <?php echo date("d M, Y \a\\t h:i A", strtotime($quote['created_at'])); ?>
                </div>
            </div>
            <div class="card-body">
                <h5>Contact Information</h5>
                <p>
                    <strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($quote['email']); ?>"><?php echo htmlspecialchars($quote['email']); ?></a><br>
                    <strong>Phone:</strong> <a href="tel:<?php echo htmlspecialchars($quote['phone']); ?>"><?php echo htmlspecialchars($quote['phone']); ?></a>
                </p>
                <hr>
                <h5>Interested In</h5>
                <p><?php echo htmlspecialchars($quote['interests']); ?></p>
                <hr>
                <h5>Project Details</h5>
                <p style="white-space: pre-wrap;"><?php echo nl2br(htmlspecialchars($quote['message'])); ?></p>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>