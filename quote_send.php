<?php
// 1. Include the database connection
require 'connection/db.php';

// 2. Check if the form was submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 3. Get the form data
    $name = trim($_POST['name'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $phone = trim($_POST['phone'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    // Handle the array of interests
    $interests_array = $_POST['interest'] ?? [];
    $interests_string = implode(', ', $interests_array); // Convert array to a comma-separated string

    // 4. Basic validation
    if (empty($name) || !$email || empty($phone)) {
        die("Please fill out all required fields.");
    }

    // 5. Prepare the SQL INSERT statement
    $sql = "INSERT INTO quote_requests (name, email, phone, company, interests, message) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    // 6. Execute the statement
    try {
        $stmt->execute([$name, $email, $phone, $company, $interests_string, $message]);
        
        // 7. Redirect to the "thank you" page on success
        header("Location: thank-you.php");
        exit;
    } catch (PDOException $e) {
        die("Error: Could not save the quote request. " . $e->getMessage());
    }

} else {
    // Redirect non-POST requests to the homepage
    header("Location: index.php");
    exit;
}