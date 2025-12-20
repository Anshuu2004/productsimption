<?php
// includes/filter-sidebar.php

// --- Fetch Categories for Filter ---
$category_stmt = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC");
$all_categories = $category_stmt->fetchAll();

// Get currently selected categories from URL
$selected_categories = isset($_GET['categories']) && is_array($_GET['categories']) ? $_GET['categories'] : [];
$current_min_price = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 0;
$current_max_price = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 10000;
?>

<div class="filter-sidebar">
    <div class="filter-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Filters</h5>
        <button class="btn btn-sm btn-light clear-all-filters">Clear All</button>
    </div>

    <form id="filter-form">
        <!-- Categories Filter -->
        <div class="filter-group">
            <h6 class="filter-group-title" data-bs-toggle="collapse" data-bs-target="#collapse-categories" aria-expanded="true">
                <span>Categories</span>
                <i class="fas fa-chevron-down"></i>
            </h6>
            <div id="collapse-categories" class="collapse show">
                <div class="filter-options">
                    <?php foreach ($all_categories as $category): ?>
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="categories[]" 
                               value="<?php echo $category['id']; ?>" 
                               id="cat_<?php echo $category['id']; ?>"
                               <?php if (in_array($category['id'], $selected_categories)) echo 'checked'; ?>>
                        <label class="form-check-label" for="cat_<?php echo $category['id']; ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Price Range Filter -->
        <div class="filter-group">
            <h6 class="filter-group-title" data-bs-toggle="collapse" data-bs-target="#collapse-price" aria-expanded="true">
                <span>Price Range</span>
                <i class="fas fa-chevron-down"></i>
            </h6>
            <div id="collapse-price" class="collapse show">
                <div class="price-range-slider">
                    <div id="price-slider"></div>
                    <div class="price-inputs d-flex justify-content-between mt-3">
                        <span class="price-label">₹ <span id="price-min-value"><?php echo $current_min_price; ?></span></span>
                        <span class="price-label">₹ <span id="price-max-value"><?php echo $current_max_price; ?></span></span>
                    </div>
                    <input type="hidden" id="min_price" name="min_price" value="<?php echo $current_min_price; ?>">
                    <input type="hidden" id="max_price" name="max_price" value="<?php echo $current_max_price; ?>">
                </div>
            </div>
        </div>

        <!-- Add more filters here in the future (e.g., Brands, Colors) -->

    </form>
</div>
