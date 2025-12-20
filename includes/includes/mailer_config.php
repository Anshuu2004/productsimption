<?php
// Use namespaces at the top
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// 1. Use Composer's autoloader (recommended) or a direct path
// If you installed PHPMailer with Composer, use this line:
//require __DIR__ . '/../vendor/autoload.php';


// If you downloaded it manually, make sure these paths are correct:
require __DIR__ . '/phpmailer/PHPMailer.php';
require __DIR__ . '/phpmailer/SMTP.php';
require __DIR__ . '/phpmailer/Exception.php';

function sendVerificationEmail(string $toEmail, string $verifyCode): bool
{
    $mail = new PHPMailer(true); // Enable exceptions

    try {
        // --- Server settings for Gmail ---
        // 2. Uncomment this line to see detailed error messages
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        
        // 3. Replace with your actual credentials
        $mail->Username   = 'coc75644@gmail.com';  // Your full Gmail address
        $mail->Password   = 'duxz nqwc lpyl yjqs'; // Your 16-character App Password

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // More secure option
        $mail->Port       = 465;                        // Port for SMTPS

        // --- Recipients ---
        $mail->setFrom('coc75644@gmail.com', 'Simption Tech'); // Changed to match Username
        $mail->addAddress($toEmail);

        // --- Content ---
        $mail->isHTML(true);
        $mail->Subject = 'Verify Your Email Address - Simption Tech';
        
        // 4. Make sure this URL is correct for your local setup
        $verification_link = "http://localhost/products_at_simption/verify.php?code=" . $verifyCode;
        
        $mail->Body    = "
            <h2>Welcome to Simption Tech!</h2>
            <p>Please click the button below to verify your email and activate your account:</p>
            <p style='margin: 20px 0;'>
                <a href='{$verification_link}' 
                   style='background-color: #0d6efd; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>
                   Verify My Email
                </a>
            </p>
            <p>If you did not create an account, you can safely ignore this email.</p>
        ";
        $mail->AltBody = 'Copy and paste this link into your browser to verify your account: ' . $verification_link;

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Log the error instead of showing it to the user
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

/**
 * Get a configured PHPMailer instance for sending emails
 * Returns a PHPMailer object with SMTP settings configured, or null on error
 * 
 * @return PHPMailer|null
 */
function getMailer(): ?PHPMailer
{
    try {
        $mail = new PHPMailer(true); // Enable exceptions
        
        // Server settings for Gmail (same as sendVerificationEmail)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'coc75644@gmail.com';  // Gmail address
        $mail->Password   = 'duxz nqwc lpyl yjqs'; // App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        
        // Set default from address
        $mail->setFrom('coc75644@gmail.com', 'Simption Tech');
        
        // Enable HTML by default
        $mail->isHTML(true);
        
        return $mail;
    } catch (Exception $e) {
        error_log("Mailer Error: Failed to initialize PHPMailer. " . $e->getMessage());
        return null;
    }
}