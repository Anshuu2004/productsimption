// admin/assets/js/admin.js

document.addEventListener('DOMContentLoaded', function() {
    // --- Client-side Table Search ---
    document.querySelectorAll('.search-table-input').forEach(input => {
        input.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const table = document.getElementById(this.dataset.targetTable);
            if (!table) return;

            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                let rowText = '';
                row.querySelectorAll('td').forEach(cell => {
                    rowText += cell.textContent.toLowerCase() + ' ';
                });
                if (rowText.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });

    // --- Client-side Table Sorting ---
    document.querySelectorAll('.sortable-table th[data-sort]').forEach(header => {
        header.style.cursor = 'pointer';
        header.innerHTML += ' <i class="fas fa-sort text-muted"></i>'; // Add sort icon

        header.addEventListener('click', function() {
            const table = this.closest('table');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const columnIndex = Array.from(this.parentNode.children).indexOf(this);
            const sortType = this.dataset.sort; // 'string', 'number', 'date'
            let sortDirection = this.dataset.sortDirection || 'asc';

            // Toggle sort direction
            sortDirection = (sortDirection === 'asc') ? 'desc' : 'asc';
            this.dataset.sortDirection = sortDirection;

            // Reset icons
            table.querySelectorAll('.sortable-table th[data-sort] i').forEach(icon => {
                icon.classList.remove('fa-sort-up', 'fa-sort-down');
                icon.classList.add('fa-sort');
            });

            // Update current header icon
            const currentIcon = this.querySelector('i');
            currentIcon.classList.remove('fa-sort');
            currentIcon.classList.add(sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down');

            rows.sort((a, b) => {
                let aText = a.children[columnIndex].textContent.trim();
                let bText = b.children[columnIndex].textContent.trim();

                if (sortType === 'number') {
                    aText = parseFloat(aText.replace(/[^0-9.-]+/g, "")); // Remove non-numeric, keep . and -
                    bText = parseFloat(bText.replace(/[^0-9.-]+/g, ""));
                    if (isNaN(aText)) aText = sortDirection === 'asc' ? -Infinity : Infinity;
                    if (isNaN(bText)) bText = sortDirection === 'asc' ? -Infinity : Infinity;
                } else if (sortType === 'date') {
                    aText = new Date(aText);
                    bText = new Date(bText);
                }

                let comparison = 0;
                if (aText > bText) {
                    comparison = 1;
                } else if (aText < bText) {
                    comparison = -1;
                }

                return sortDirection === 'asc' ? comparison : -comparison;
            });

            rows.forEach(row => tbody.appendChild(row));
        });
    });

    // --- Generic Form Validation Feedback ---
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(event) {
            let isValid = true;
            form.querySelectorAll('[required]').forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    isValid = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                event.preventDefault(); // Prevent form submission
                // Optionally scroll to the first invalid field
                form.querySelector('.is-invalid')?.focus();
            }
        });

        // Remove validation feedback on input
        form.querySelectorAll('[required]').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    });

    // --- Image Preview for File Inputs ---
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const previewContainer = this.closest('.mb-3').querySelector('.image-preview-container');
            if (previewContainer) {
                previewContainer.innerHTML = ''; // Clear previous preview

                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.maxWidth = '150px';
                        img.style.height = 'auto';
                        img.style.marginTop = '10px';
                        img.style.border = '1px solid #ddd';
                        img.style.borderRadius = '4px';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            }
        });
    });

    // --- Delete Confirmation Modal ---
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
    let formToSubmit = null;

    document.querySelectorAll('.btn-danger[name="delete"]').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent immediate form submission
            formToSubmit = this.closest('form');
            const message = this.dataset.confirmMessage || 'Are you sure you want to delete this item? This action cannot be undone.';
            document.getElementById('deleteModalBody').textContent = message;
            deleteModal.show();
        });
    });

    document.getElementById('confirmDeleteButton').addEventListener('click', function() {
        if (formToSubmit) {
            formToSubmit.submit(); // Submit the stored form
        }
    });
});
