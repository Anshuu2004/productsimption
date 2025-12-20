<?php
session_start();
require '../connection/db.php';

// Security check using the unique admin session
if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

// Get the message ID from the URL, ensure it's an integer
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: messages.php');
    exit;
}

// Handle the delete request if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: messages.php?status=deleted');
    exit;
}

// Fetch the specific message from the database
$stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
$stmt->execute([$id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

// If no message with that ID exists, redirect back to the list
if (!$message) {
    header('Location: messages.php');
    exit;
}

include '../includes/header.php';
?>
<link rel="stylesheet" href="assets/css/admin.css">

<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">View Message</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="messages.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Messages
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <strong>From:</strong> <?php echo htmlspecialchars($message['name']); ?><br>
                        <strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($message['email']); ?>"><?php echo htmlspecialchars($message['email']); ?></a>
                    </div>
                    <div>
                        <strong>Received:</strong> <?php echo date("d M, Y \a\\t h:i A", strtotime($message['created_at'])); ?>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Subject: <?php echo htmlspecialchars($message['subject']); ?></h5>
                    <hr>
                    <p class="card-text" style="white-space: pre-wrap;"><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                </div>
                <div class="card-footer text-end">
                                <form method="post">
                                    <button type="submit" name="delete" class="btn btn-danger" 
                                            data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" 
                                            data-confirm-message="Are you sure you want to delete this message? This action cannot be undone.">
                                        <i class="fas fa-trash-alt me-2"></i>Delete Message
                                    </button>
                                </form>                </div>
            </div>
        </main>
    </div>
</div>

<?php include '../includes/footer.php'; ?>