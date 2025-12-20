<?php
// product_enquiry.php - adds product to session enquiry "cart"
session_start();


require 'connection/db.php';

// Validate request
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['product_id'])) {
    header('Location: index.php');
    exit;
}

$id = intval($_POST['product_id']);

// Fetch product details
$stmt = $pdo->prepare("SELECT id, title, price, image FROM products WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$p = $stmt->fetch();

if (!$p) {
    header('Location: index.php');
    exit;
}

// Initialize enquiry session if empty
if (empty($_SESSION['enquiry'])) {
    $_SESSION['enquiry'] = [];
}

// Add product to enquiry "cart"
$_SESSION['enquiry'][$p['id']] = $p;

// Redirect to contact page with enquiry flag
header('Location: contact.php?enquiry=1');
exit;
