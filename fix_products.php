<?php
/**
 * Script to:
 * 1. Add missing ID card products that were hardcoded
 * 2. Rename lanyard and badge products with better names
 */
require 'connection/db.php';

try {
    $pdo->beginTransaction();
    
    // 1. RENAME EXISTING PRODUCTS WITH BETTER NAMES
    $renames = [
        // Lanyards - better names
        ['id' => 3, 'new_title' => 'Premium Polyester Lanyard', 'new_desc' => 'High-quality soft polyester lanyard with metal swivel hook. Perfect for ID cards and badges. Available in 20mm width.'],
        
        // Badges - better names  
        ['id' => 5, 'new_title' => 'Professional Plastic Badge', 'new_desc' => 'Durable plastic badge with secure pin attachment. Standard size 75x50mm. Ideal for events and staff identification.'],
        ['id' => 6, 'new_title' => 'Premium Metal Badge', 'new_desc' => 'Elegant metal finish badge with premium enamel coating. Perfect for executive identification and special events.'],
    ];
    
    $updateStmt = $pdo->prepare("UPDATE products SET title = ?, description = ? WHERE id = ?");
    $renamed = 0;
    foreach ($renames as $rename) {
        $updateStmt->execute([$rename['new_title'], $rename['new_desc'], $rename['id']]);
        $renamed++;
    }
    
    // 2. ADD MISSING ID CARD PRODUCTS (especially ID 4 - Pouch Card that was hardcoded)
    $newProducts = [
        // Product ID 4 - Pouch Card (was hardcoded in header, must exist)
        ['id' => 4, 'category_id' => NULL, 'title' => 'Pouch Card', 'description' => 'Flexible pouch-style ID card holder with clear window. Perfect for temporary IDs or frequently changing information.', 'price' => 80.00, 'image' => 'id_rfid_pvc.png'],
        
        // Additional ID Cards
        ['id' => NULL, 'category_id' => NULL, 'title' => 'Standard PVC Card', 'description' => 'Classic PVC ID card with standard printing. Durable and cost-effective solution for schools, colleges, and offices.', 'price' => 100.00, 'image' => 'id_rfid_pvc.png'],
    ];
    
    $insertStmt = $pdo->prepare("INSERT INTO products (id, category_id, title, description, price, image, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
    $insertStmtNoId = $pdo->prepare("INSERT INTO products (category_id, title, description, price, image, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
    $added = 0;
    
    foreach ($newProducts as $product) {
        // Check if product with this ID already exists
        if (isset($product['id']) && $product['id'] !== NULL) {
            $check = $pdo->prepare("SELECT id FROM products WHERE id = ?");
            $check->execute([$product['id']]);
            if (!$check->fetch()) {
                // Insert with specific ID
                $insertStmt->execute([
                    $product['id'],
                    $product['category_id'],
                    $product['title'],
                    $product['description'],
                    $product['price'],
                    $product['image']
                ]);
                $added++;
            }
        } else {
            // Check if product already exists by title
            $check = $pdo->prepare("SELECT id FROM products WHERE title = ?");
            $check->execute([$product['title']]);
            if (!$check->fetch()) {
                // Insert without ID (auto-increment)
                $insertStmtNoId->execute([
                    $product['category_id'],
                    $product['title'],
                    $product['description'],
                    $product['price'],
                    $product['image']
                ]);
                $added++;
            }
        }
    }
    
    $pdo->commit();
    
    echo "<h2>✅ Products Updated Successfully!</h2>";
    echo "<p><strong>Renamed:</strong> $renamed products</p>";
    echo "<p><strong>Added:</strong> $added new products</p>";
    echo "<hr>";
    echo "<h3>Renamed Products:</h3>";
    echo "<ul>";
    foreach ($renames as $r) {
        echo "<li>ID {$r['id']}: {$r['new_title']}</li>";
    }
    echo "</ul>";
    echo "<h3>New Products Added:</h3>";
    echo "<ul>";
    foreach ($newProducts as $p) {
        echo "<li>{$p['title']} - ₹{$p['price']}</li>";
    }
    echo "</ul>";
    echo "<br><a href='index.php' class='btn btn-primary'>Go to Homepage</a>";
    echo "<br><br><a href='products.php' class='btn btn-secondary'>View All Products</a>";
    
} catch (PDOException $e) {
    $pdo->rollBack();
    die("Error: " . $e->getMessage());
}
?>

