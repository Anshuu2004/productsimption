<?php
/**
 * Create all lanyard products with proper IDs so they are clickable
 * Products: Polyester Lanyards, Nylon Lanyards, Lanyard Prints, Customized Lanyards
 */
require 'connection/db.php';

try {
    $pdo->beginTransaction();
    
    // Lanyard products with exact names from header
    // Each needs a unique ID so header links can point to different products
    $lanyards = [
        ['id' => 3, 'category_id' => NULL, 'title' => 'Polyester Lanyards', 'description' => 'Premium polyester lanyard with metal swivel hook. Soft, durable, and comfortable to wear. Available in multiple colors and widths. Perfect for ID cards, badges, and access cards.', 'price' => 40.00, 'image' => 'lanyard_poly.png'],
        ['id' => 7, 'category_id' => NULL, 'title' => 'Nylon Lanyards', 'description' => 'Strong nylon lanyard with breakaway safety feature. Ideal for security and safety requirements. Durable construction with metal hardware. Available in various widths and colors.', 'price' => 45.00, 'image' => 'lanyard_poly.png'],
        ['id' => 8, 'category_id' => NULL, 'title' => 'Lanyard Prints', 'description' => 'Custom printed lanyard with your logo, text, or design. Perfect for branding and corporate events. High-quality printing that lasts. Multiple printing options available.', 'price' => 60.00, 'image' => 'lanyard_print.png'],
        ['id' => 9, 'category_id' => NULL, 'title' => 'Customized Lanyards', 'description' => 'Fully customized lanyard with personalized design, colors, and branding options. Complete customization including material, width, hardware, and printing. Perfect for special events and corporate branding.', 'price' => 65.00, 'image' => 'lanyard_print.png'],
    ];
    
    $insertWithId = $pdo->prepare("INSERT INTO products (id, category_id, title, description, price, image, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW()) ON DUPLICATE KEY UPDATE title = VALUES(title), description = VALUES(description), price = VALUES(price), image = VALUES(image)");
    $insertAutoId = $pdo->prepare("INSERT INTO products (category_id, title, description, price, image, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
    
    $added = 0;
    $updated = 0;
    $productIds = [];
    
    foreach ($lanyards as $product) {
        if (isset($product['id']) && $product['id'] !== NULL) {
            // Check if exists
            $check = $pdo->prepare("SELECT id FROM products WHERE id = ?");
            $check->execute([$product['id']]);
            $existing = $check->fetch();
            
            if ($existing) {
                // Update existing
                $update = $pdo->prepare("UPDATE products SET title = ?, description = ?, price = ?, image = ? WHERE id = ?");
                $update->execute([
                    $product['title'],
                    $product['description'],
                    $product['price'],
                    $product['image'],
                    $product['id']
                ]);
                $productIds[] = $product['id'];
                $updated++;
            } else {
                // Insert with specific ID
                $insertWithId->execute([
                    $product['id'],
                    $product['category_id'],
                    $product['title'],
                    $product['description'],
                    $product['price'],
                    $product['image']
                ]);
                $productIds[] = $product['id'];
                $added++;
            }
        } else {
            // Check if exists by title
            $check = $pdo->prepare("SELECT id FROM products WHERE title = ?");
            $check->execute([$product['title']]);
            $existing = $check->fetch();
            
            if ($existing) {
                $productIds[] = $existing['id'];
                // Update if needed
                $update = $pdo->prepare("UPDATE products SET description = ?, price = ?, image = ? WHERE id = ?");
                $update->execute([
                    $product['description'],
                    $product['price'],
                    $product['image'],
                    $existing['id']
                ]);
                $updated++;
            } else {
                // Insert new
                $insertAutoId->execute([
                    $product['category_id'],
                    $product['title'],
                    $product['description'],
                    $product['price'],
                    $product['image']
                ]);
                $newId = $pdo->lastInsertId();
                $productIds[] = $newId;
                $added++;
            }
        }
    }
    
    $pdo->commit();
    
    echo "<h2>✅ Lanyard Products Created Successfully!</h2>";
    echo "<p><strong>Added:</strong> $added products</p>";
    echo "<p><strong>Updated:</strong> $updated products</p>";
    echo "<hr>";
    echo "<h3>Lanyard Products Created (All Clickable):</h3>";
    echo "<ul>";
    foreach ($lanyards as $index => $p) {
        $id = $productIds[$index];
        echo "<li><strong>ID $id:</strong> {$p['title']} - ₹{$p['price']}</li>";
        echo "<li style='list-style:none; margin-left:20px;'><a href='product.php?lanyard=$id' target='_blank'>→ Test Link: product.php?lanyard=$id</a></li>";
    }
    echo "</ul>";
    echo "<hr>";
    echo "<h3>⚠️ IMPORTANT: Update Header Links</h3>";
    echo "<p>The header currently has all lanyard links pointing to ID 3. After running this script, you need to update the header to use the correct IDs:</p>";
    echo "<ul>";
    echo "<li>Polyester Lanyards → product.php?lanyard=3 (already correct)</li>";
    echo "<li>Nylon Lanyards → product.php?lanyard=7</li>";
    echo "<li>Lanyard Prints → product.php?lanyard=8</li>";
    echo "<li>Customized Lanyards → product.php?lanyard=9</li>";
    echo "</ul>";
    echo "<hr>";
    echo "<h3>Next Steps:</h3>";
    echo "<p>1. Verify all lanyard products are clickable in the header menu</p>";
    echo "<p>2. Each product should have a detail page at: product.php?lanyard=[ID]</p>";
    echo "<p>3. Test clicking on each lanyard product from the menu</p>";
    echo "<br><a href='index.php' style='padding:10px 20px;background:#0d6efd;color:white;text-decoration:none;border-radius:5px;'>Go to Homepage</a>";
    echo " <a href='lanyard.php' style='padding:10px 20px;background:#28a745;color:white;text-decoration:none;border-radius:5px;'>View Lanyards Page</a>";
    
} catch (PDOException $e) {
    $pdo->rollBack();
    die("Error: " . $e->getMessage());
}
?>

