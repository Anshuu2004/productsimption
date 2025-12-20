<?php
require __DIR__ . '/connection/db.php';

$erpCategoryId = 4;

try {
    $stmt = $pdo->prepare("SELECT id, title, description FROM products WHERE category_id = ? ORDER BY id ASC");
    $stmt->execute([$erpCategoryId]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($products) {
        echo json_encode($products);
    } else {
        echo 'No ERP products found.';
    }
} catch (PDOException $e) {
    echo "Error fetching products: " . $e->getMessage() . "\n";
}
?>