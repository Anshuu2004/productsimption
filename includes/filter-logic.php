<?php
// includes/filter-logic.php

// --- Filter & Sort Logic ---
$category_ids = isset($_GET['categories']) && is_array($_GET['categories']) ? $_GET['categories'] : [];
$min_price = isset($_GET['min_price']) && is_numeric($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) && is_numeric($_GET['max_price']) ? (int)$_GET['max_price'] : 10000;
$sort_option = isset($_GET['sort']) ? $_GET['sort'] : 'latest';

// --- Pagination Logic ---
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 9;
$offset = ($page - 1) * $limit;

// --- Fetch Categories for Filter ---
$category_stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $category_stmt->fetchAll();

// --- Build WHERE clause for filtering ---
$where_clauses = " WHERE price BETWEEN :min_price AND :max_price";
$params = [':min_price' => $min_price, ':max_price' => $max_price];
$count_params = $params; // Separate params for count query

if (!empty($category_ids)) {
    $safe_category_ids = array_map('intval', $category_ids);
    $in_placeholders = implode(',', array_fill(0, count($safe_category_ids), '?'));
    $where_clauses .= " AND category_id IN ($in_placeholders)";
}

// --- Count Total Products for Pagination ---
$count_sql = "SELECT COUNT(*) FROM products" . $where_clauses;
$count_stmt = $pdo->prepare($count_sql);

// Bind parameters for count
$count_stmt->bindParam(':min_price', $count_params[':min_price'], PDO::PARAM_INT);
$count_stmt->bindParam(':max_price', $count_params[':max_price'], PDO::PARAM_INT);
if (!empty($category_ids)) {
    $i = 1;
    foreach ($safe_category_ids as $cat_id) {
        $count_stmt->bindValue($i++, $cat_id, PDO::PARAM_INT);
    }
}
$count_stmt->execute();
$total_products = $count_stmt->fetchColumn();
$total_pages = ceil($total_products / $limit);

// --- Build ORDER BY clause for sorting ---
$sort_columns = [
    'price_asc' => 'price ASC',
    'price_desc' => 'price DESC',
    'latest' => 'created_at DESC'
];
$order_by = isset($sort_columns[$sort_option]) ? $sort_columns[$sort_option] : 'created_at DESC';

// --- Build Full Product Query ---
$sql = "SELECT * FROM products" . $where_clauses . " ORDER BY " . $order_by . " LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);

// Bind parameters for main query
$stmt->bindParam(':min_price', $params[':min_price'], PDO::PARAM_INT);
$stmt->bindParam(':max_price', $params[':max_price'], PDO::PARAM_INT);
$param_offset = empty($category_ids) ? 1 : count($safe_category_ids) + 1;

if (!empty($category_ids)) {
    $i = 1;
    foreach ($safe_category_ids as $cat_id) {
        $stmt->bindValue($i++, $cat_id, PDO::PARAM_INT);
    }
}
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

$stmt->execute();

// If this is an AJAX request, return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Fetch all products for JSON response
    $products = [];
    while ($product = $stmt->fetch()) {
        // Determine image path
        $image_path = 'assets/images/products/' . ($product['image'] ?? 'placeholder.png');
        if (!empty($product['category_id'])) {
            switch($product['category_id']) {
                case 1: $category_folder = 'attendance'; break;
                case 2: $category_folder = 'lanyards'; break;
                case 3: $category_folder = 'badges'; break;
                case 4: $category_folder = 'erp'; break;
                case 5: $category_folder = 'id-cards'; break;
                default: $category_folder = 'general';
            }
            $potential_path = "assets/images/products/{$category_folder}/" . ($product['image'] ?? 'placeholder.png');
            if (file_exists(__DIR__ . '/..' . '/' . $potential_path)) {
                $image_path = $potential_path;
            }
        }
        
        $product['full_image_path'] = $image_path;
        $products[] = $product;
    }
    
    // Prepare pagination data
    $pagination = [
        'current_page' => $page,
        'total_pages' => $total_pages,
        'total_products' => $total_products
    ];
    
    header('Content-Type: application/json');
    echo json_encode(['products' => $products, 'pagination' => $pagination]);
    exit;
}
?>