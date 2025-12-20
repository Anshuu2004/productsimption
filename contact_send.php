<?php
// 1. Include necessary files
require 'connection/db.php';
require 'includes/mailer_config.php';

// 2. Check if the form was submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 3. Get the form data and perform basic cleaning
    $name = trim($_POST['name'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // 4. Basic validation
    if (empty($name) || !$email || empty($subject) || empty($message)) {
        die("Please fill out all required fields.");
    }

    // 5. Save the message to the database
    try {
        $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $email, $subject, $message]);
    } catch (PDOException $e) {
        // In a real application, you would log this error
        error_log("Database Error: Could not save the message. " . $e->getMessage());
        // You might want to stop here if the DB save fails
    }

    // 6. Send the email notification
    $mail = getMailer();
    if ($mail) {
        try {
            //Recipients
            $mail->setFrom('no-reply@yourdomain.com', 'Your Website'); // Replace with a 'from' address
            $mail->addAddress('admin@yourdomain.com', 'Admin');     // The address that will receive the notification
            $mail->addReplyTo($email, $name); // Set the reply-to to the user who submitted the form

            //Content
            $mail->isHTML(true);
            $mail->Subject = "New Contact Form Submission: " . htmlspecialchars($subject);
            $mail->Body    = "You have received a new message from your website contact form.<br><br>" .
                             "<b>Name:</b> " . htmlspecialchars($name) . "<br>" .
                             "<b>Email:</b> " . htmlspecialchars($email) . "<br>" .
                             "<b>Subject:</b> " . htmlspecialchars($subject) . "<br>" .
                             "<b>Message:</b><br>" . nl2br(htmlspecialchars($message));
            $mail->AltBody = "You have received a new message.\n\n" .
                             "Name: " . htmlspecialchars($name) . "\n" .
                             "Email: " . htmlspecialchars($email) . "\n" .
                             "Subject: " . htmlspecialchars($subject) . "\n" .
                             "Message: " . htmlspecialchars($message);

            $mail->send();
        } catch (Exception $e) {
            // Log the email error but don't kill the script, as the message is already saved.
            error_log("Mailer Error: Could not send email. {$mail->ErrorInfo}");
        }
    }

    // 7. Redirect to a "thank you" page on success
    header("Location: thank-you.php");
    exit;

} else {
    // If someone accesses this page directly, redirect them to the homepage
    header("Location: index.php");
    exit;
}