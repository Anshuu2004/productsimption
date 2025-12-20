<?php
include 'connection/db.php';
include 'includes/header.php';

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
$min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 10000;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'relevance';

// Get categories for filter
$category_stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $category_stmt->fetchAll();

echo '<main class="container py-5">';

if (!empty($query)) {
    // Build search query
    $sql = "SELECT * FROM products WHERE (LOWER(title) LIKE ? OR LOWER(description) LIKE ?)";
    $params = ['%' . strtolower($query) . '%', '%' . strtolower($query) . '%'];
    
    // Add category filter
    if ($category_id > 0) {
        $sql .= " AND category_id = ?";
        $params[] = $category_id;
    }
    
    // Add price filter
    $sql .= " AND price BETWEEN ? AND ?";
    $params[] = $min_price;
    $params[] = $max_price;
    
    // Add sorting
    switch ($sort) {
        case 'price_asc':
            $sql .= " ORDER BY price ASC";
            break;
        case 'price_desc':
            $sql .= " ORDER BY price DESC";
            break;
        case 'name':
            $sql .= " ORDER BY title ASC";
            break;
        default:
            // Default sorting by relevance (could be improved with full-text search)
            $sql .= " ORDER BY created_at DESC";
    }
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $results = $stmt->fetchAll();
    
    echo '<div class="row">';
    echo '<div class="col-lg-3">';
    echo '<div class="card border-0 shadow-sm mb-4 rounded-3">';
    echo '<div class="card-header bg-gradient-primary text-white rounded-top-3">';
    echo '<h5 class="mb-0 d-flex align-items-center"><i class="fas fa-sliders-h me-2"></i>Filters</h5>';
    echo '</div>';
    echo '<div class="card-body">';
    echo '<form method="GET" id="search-filter-form">';
    echo '<input type="hidden" name="query" value="' . htmlspecialchars($query) . '">';
    
    // Category Filter
    echo '<div class="mb-4">';
    echo '<h6 class="fw-bold text-uppercase small mb-3 text-muted">Category</h6>';
    echo '<div class="filter-group">';
    echo '<div class="form-check mb-2">';
    echo '<input class="form-check-input" type="radio" name="category" value="0" id="cat_all" ' . ($category_id == 0 ? 'checked' : '') . '>';
    echo '<label class="form-check-label" for="cat_all">All Categories</label>';
    echo '</div>';
    foreach ($categories as $category) {
        $checked = ($category['id'] == $category_id) ? 'checked' : '';
        echo '<div class="form-check mb-2">';
        echo '<input class="form-check-input" type="radio" name="category" value="' . $category['id'] . '" id="cat_' . $category['id'] . '" ' . $checked . '>';
        echo '<label class="form-check-label" for="cat_' . $category['id'] . '">' . htmlspecialchars($category['name']) . '</label>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
    
    // Price Range Filter
    echo '<div class="mb-4">';
    echo '<h6 class="fw-bold text-uppercase small mb-3 text-muted">Price Range</h6>';
    echo '<div class="filter-group">';
    echo '<div class="mb-3">';
    echo '<label class="form-label small">Min Price (₹)</label>';
    echo '<input type="number" name="min_price" class="form-control form-control-sm rounded-2" placeholder="0" value="' . $min_price . '" min="0">';
    echo '</div>';
    echo '<div class="mb-3">';
    echo '<label class="form-label small">Max Price (₹)</label>';
    echo '<input type="number" name="max_price" class="form-control form-control-sm rounded-2" placeholder="10000" value="' . $max_price . '" min="0">';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
    // Sorting Options
    echo '<div class="mb-4">';
    echo '<h6 class="fw-bold text-uppercase small mb-3 text-muted">Sort By</h6>';
    echo '<div class="filter-group">';
    echo '<div class="mb-2">';
    echo '<div class="form-check">';
    echo '<input class="form-check-input" type="radio" name="sort" value="relevance" id="sort_rel" ' . ($sort == 'relevance' ? 'checked' : '') . '>';
    echo '<label class="form-check-label" for="sort_rel">Relevance</label>';
    echo '</div>';
    echo '</div>';
    echo '<div class="mb-2">';
    echo '<div class="form-check">';
    echo '<input class="form-check-input" type="radio" name="sort" value="price_asc" id="sort_price_asc" ' . ($sort == 'price_asc' ? 'checked' : '') . '>';
    echo '<label class="form-check-label" for="sort_price_asc">Price: Low to High</label>';
    echo '</div>';
    echo '</div>';
    echo '<div class="mb-2">';
    echo '<div class="form-check">';
    echo '<input class="form-check-input" type="radio" name="sort" value="price_desc" id="sort_price_desc" ' . ($sort == 'price_desc' ? 'checked' : '') . '>';
    echo '<label class="form-check-label" for="sort_price_desc">Price: High to Low</label>';
    echo '</div>';
    echo '</div>';
    echo '<div class="mb-2">';
    echo '<div class="form-check">';
    echo '<input class="form-check-input" type="radio" name="sort" value="name" id="sort_name" ' . ($sort == 'name' ? 'checked' : '') . '>';
    echo '<label class="form-check-label" for="sort_name">Name (A-Z)</label>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
    echo '<div class="d-grid gap-2">';
    echo '<button type="submit" class="btn btn-primary rounded-pill"><i class="fas fa-filter me-2"></i>Apply Filters</button>';
    echo '<a href="search.php?query=' . urlencode($query) . '" class="btn btn-outline-secondary rounded-pill">Clear Filters</a>';
    echo '</div>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
    echo '<div class="col-lg-9">';
    echo '<div class="d-flex justify-content-between align-items-center mb-4">';
    echo '<h1 class="fw-bold">Search Results</h1>';
    echo '<div class="text-muted"><span class="fw-bold">' . count($results) . '</span> products found</div>';
    echo '</div>';
    
    if (count($results) > 0) {
        echo '<div class="row g-4">';
        foreach ($results as $product) {
            echo '<div class="col-md-4 col-lg-4">';
            echo '    <div class="card product-card h-100 border-0 shadow-sm rounded-3 overflow-hidden">';
            
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
                if (file_exists(__DIR__ . '/' . $potential_path)) {
                    $image_path = $potential_path;
                }
            }
            
            echo '        <a href="product.php?id=' . $product['id'] . '">';
            echo '            <img src="' . htmlspecialchars($image_path) . '" class="card-img-top" alt="' . htmlspecialchars($product['title']) . '" style="height: 200px; object-fit: cover;">';
            echo '        </a>';
            echo '        <div class="card-body d-flex flex-column">';
            echo '            <h5 class="card-title"><a href="product.php?id=' . $product['id'] . '" class="text-decoration-none text-dark fw-bold">' . htmlspecialchars($product['title']) . '</a></h5>';
            echo '            <p class="card-text text-muted small flex-grow-1">' . htmlspecialchars(substr($product['description'], 0, 100)) . '...</p>';
            echo '            <p class="card-text fw-bold fs-5 text-primary mb-0">₹' . htmlspecialchars(number_format($product['price'], 2)) . '</p>';
            echo '        </div>';
            echo '        <div class="card-footer bg-white border-top-0">';
            echo '            <a href="product.php?id=' . $product['id'] . '" class="btn btn-primary w-100 rounded-pill">View Details</a>';
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<div class="alert alert-warning rounded-3" role="alert">';
        echo '    <h4 class="alert-heading"><i class="fas fa-exclamation-circle me-2"></i>No Products Found</h4>';
        echo '    <p>No products match your search criteria. Try adjusting your filters or search term.</p>';
        echo '    <hr>';
        echo '    <a href="products.php" class="btn btn-primary rounded-pill">Browse All Products</a>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
} else {
    echo '<div class="alert alert-info rounded-3" role="alert">';
    echo '    <h4 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Search Products</h4>';
    echo '    <p>Please enter a search term in the search bar above to find products.</p>';
    echo '    <hr>';
    echo '    <a href="products.php" class="btn btn-primary rounded-pill">Browse All Products</a>';
    echo '</div>';
}

echo '</main>';

include 'includes/footer.php';
?>