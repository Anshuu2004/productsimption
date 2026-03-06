document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filter-form');
    const productGrid = document.getElementById('product-grid');
    const paginationContainer = document.getElementById('pagination-container');
    const productCountElement = document.getElementById('product-count');
    const sortByElement = document.getElementById('sort-by');
    const clearAllButton = document.querySelector('.clear-all-filters');

    // --- Price Slider Initialization (noUiSlider) ---
    const priceSlider = document.getElementById('price-slider');
    let priceUpdateTimeout;
    let slider;

    if (priceSlider) {
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');
        const minPriceValue = document.getElementById('price-min-value');
        const maxPriceValue = document.getElementById('price-max-value');

        slider = noUiSlider.create(priceSlider, {
            start: [minPriceInput.value, maxPriceInput.value],
            connect: true,
            range: {
                'min': 0,
                'max': 10000
            },
            step: 100,
            format: {
                to: value => Math.round(value),
                from: value => Number(value)
            }
        });

        slider.on('update', function (values) {
            minPriceValue.textContent = values[0];
            maxPriceValue.textContent = values[1];
            minPriceInput.value = values[0];
            maxPriceInput.value = values[1];
        });
        
        slider.on('end', function () {
            clearTimeout(priceUpdateTimeout);
            priceUpdateTimeout = setTimeout(() => {
                fetchProducts();
            }, 300);
        });
    }

    // --- Core Function to Fetch and Render Products ---
    async function fetchProducts(page = 1) {
        showLoadingSkeleton();

        const formData = new FormData(filterForm);
        formData.append('page', page);
        if (sortByElement.value) {
            formData.append('sort', sortByElement.value);
        }
        
        const params = new URLSearchParams(formData);
        const url = `${BASE_URL}api/products.php?${params.toString()}`;
        
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();

            // Update URL without reloading
            const stateUrl = `products-new.php?${params.toString()}`;
            history.pushState({ path: stateUrl }, '', stateUrl);
            
            renderProducts(data.products);
            renderPagination(data.pagination);
            updateProductCount(data.pagination.total_products);

        } catch (error) {
            console.error('Fetch error:', error);
            productGrid.innerHTML = '<p class="text-danger">Failed to load products. Please try again.</p>';
        }
    }

    // --- Render Functions ---
    function renderProducts(products) {
        productGrid.innerHTML = '';
        if (products.length === 0) {
            productGrid.innerHTML = '<div class="col-12"><p class="text-center">No products found matching your criteria.</p></div>';
            return;
        }
        products.forEach(product => {
            const productCard = `
                <div class="col-lg-4 col-md-6">
                    <div class="product-card">
                        <a href="product-new.php?id=${product.id}">
                            <img src="${escapeHTML(product.full_image_path)}" 
                                 class="product-card-img" 
                                 alt="${escapeHTML(product.title)}">
                        </a>
                        <div class="product-card-body">
                            <h5 class="product-title">
                                <a href="product-new.php?id=${product.id}">
                                    ${escapeHTML(product.title.substring(0, 30))}${product.title.length > 30 ? '...' : ''}
                                </a>
                            </h5>
                            <p class="product-price">₹${parseFloat(product.price).toFixed(2)}</p>
                            <a href="product-new.php?id=${product.id}" class="btn btn-primary w-100">Order Now</a>
                        </div>
                    </div>
                </div>
            `;
            productGrid.innerHTML += productCard;
        });
    }

    function renderPagination(pagination) {
        paginationContainer.innerHTML = '';
        if (pagination.total_pages <= 1) return;

        let paginationHTML = '<ul class="pagination justify-content-center">';
        
        // Previous button
        paginationHTML += `<li class="page-item ${pagination.current_page <= 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${pagination.current_page - 1}">Previous</a>
        </li>`;

        // Page numbers
        for (let i = 1; i <= pagination.total_pages; i++) {
            paginationHTML += `<li class="page-item ${pagination.current_page == i ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>`;
        }

        // Next button
        paginationHTML += `<li class="page-item ${pagination.current_page >= pagination.total_pages ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${pagination.current_page + 1}">Next</a>
        </li>`;

        paginationHTML += '</ul>';
        paginationContainer.innerHTML = paginationHTML;
    }

    function updateProductCount(total) {
        productCountElement.textContent = `${total} Products Found`;
    }
    
    function showLoadingSkeleton() {
        productGrid.innerHTML = `
            ${Array(9).fill('').map(() => `
                <div class="col-lg-4 col-md-6 skeleton-card">
                    <div class="card" aria-hidden="true">
                        <div class="card-img-top skeleton-image"></div>
                        <div class="card-body">
                            <h5 class="card-title placeholder-glow"><span class="placeholder col-8"></span></h5>
                            <p class="card-text placeholder-glow"><span class="placeholder col-5"></span></p>
                            <a href="#" tabindex="-1" class="btn btn-primary disabled placeholder col-12"></a>
                        </div>
                    </div>
                </div>
            `).join('')}
        `;
    }

    // --- Event Listeners ---
    filterForm.addEventListener('change', function(e) {
        if (e.target.type === 'checkbox' || e.target.type === 'radio') {
            fetchProducts();
        }
    });

    sortByElement.addEventListener('change', function() {
        fetchProducts();
    });

    paginationContainer.addEventListener('click', function(e) {
        e.preventDefault();
        if (e.target.tagName === 'A' && e.target.dataset.page) {
            const page = parseInt(e.target.dataset.page, 10);
            if (!isNaN(page)) {
                fetchProducts(page);
            }
        }
    });

    if (clearAllButton) {
        clearAllButton.addEventListener('click', function() {
            filterForm.reset();
            if (slider) {
                slider.set([0, 10000]);
            }
            fetchProducts();
        });
    }
    
    // --- Utility ---
    function escapeHTML(str) {
        const p = document.createElement('p');
        p.appendChild(document.createTextNode(str));
        return p.innerHTML;
    }

    // --- Initial Load ---
    fetchProducts();
});