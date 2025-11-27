<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/user.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/products.css') ?>">
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container page-content">
        <div class="row">
            <div class="products-container">
                <div class="page-header mt-2 fw-bold">
                    <h1>Product Management</h1>
                    <p>Manage all products, add new ones, and control their display on gift and menu pages</p>
                </div>
                <hr />


                <div class="search-filter-container d-flex align-items-center gap-3 mb-3">
                    <div class="search-input position-relative flex-grow-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="search-icon">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" id="search-term" class="form-control fw-bold" placeholder="Search by Order ID, Customer Name, Email, or Phone" />
                    </div>
                    <div class="filter-dropdown d-flex align-items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        <select id="status-filter" class="form-select">
                            <option value="All Status">All Status</option>
                            <option value="Drinks">Drinks</option>
                            <option value="Food">Food</option>
                            <option value="Gift Cards">Gift Cards</option>
                        </select>
                    </div>
                    <button class="btn btn-success fw-bold" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </button>
                </div>
                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- Loading Spinner -->
                <div id="loadingSpinner" class="loading-spinner">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="table-container">

                    <!-- Products Table -->
                    <div class="table-responsive" style="background-color: transparent;">
                        <table class="table" id="productsTable" style="background-color: transparent;">
                            <thead>
                                <tr style="background-color: #808080;">
                                    <th class="fw-bold">PRODUCT</th>
                                    <th class="text-center">CATEGORY</th>
                                    <th class="text-center">PRICE</th>
                                    <th class="text-center">STATUS</th>
                                    <th class="text-center">PAGE</th>
                                    <th class="text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody id="productsTableBody" style="background-color: transparent;">
                                <!-- Products will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addProductForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="productName" class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="productName" name="name" autoComplete="off"
                                    autoCapitalize="words"
                                    autoCorrect="off"
                                    spellCheck={false} required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="productPrice" class="form-label">Price *</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" id="productPrice" name="price" step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="productCategory" class="form-label">Category</label>
                                <select class="form-select" id="productCategory" name="category">
                                    <option value="">Select Category</option>
                                    <option value="Drinks">Drinks</option>
                                    <option value="Food">Food</option>
                                    <option value="Gift Cards">Gift</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="productPage" class="form-label">Page *</label>
                                <select class="form-select" id="productPage" name="page" required>
                                    <option value="">Select Page</option>
                                    <option value="menu">Menu Page</option>
                                    <option value="gift">Gift Page</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="productImage" class="form-label">Image URL</label>
                                <input type="url" class="form-control w-100" id="productImage" name="image" placeholder="https://example.com/image.jpg" autoComplete="off"
                                    autoCapitalize="words"
                                    autoCorrect="off"
                                    spellCheck={false}>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="productDescription" name="description" rows="3" style="resize: none; height: 100px;" placeholder="Enter product description..."></textarea>
                        </div>
                        <div class="mb-3" id="imagePreviewContainer" style="display: none;">
                            <label class="form-label">Image Preview</label>
                            <div class="text-center">
                                <img id="imagePreview" class="product-image-preview" src="" alt="Product Preview">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success fw-bold">
                            Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Product
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editProductForm">
                    <input type="hidden" id="editProductId" name="productId">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editProductName" class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="editProductName" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editProductPrice" class="form-label">Price *</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="number" class="form-control" id="editProductPrice" name="price" step="0.01" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editProductCategory" class="form-label">Category</label>
                                <select class="form-select" id="editProductCategory" name="category">
                                    <option value="">Select Category</option>
                                    <option value="Drinks">Drinks</option>
                                    <option value="Food">Food</option>
                                    <option value="Gift Cards">Gift </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editProductPage" class="form-label">Page *</label>
                                <select class="form-select" id="editProductPage" name="page" required>
                                    <option value="">Select Page</option>
                                    <option value="menu">Menu Page</option>
                                    <option value="gift">Gift Page</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="editProductImage" class="form-label">Image URL</label>
                                <input type="url" class="form-control" id="editProductImage" name="image" placeholder="https://example.com/image.jpg">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editProductDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editProductDescription" name="description" rows="3" placeholder="Enter product description..." style="resize: none; height: 100px;"></textarea>
                        </div>
                        <div class="mb-3" id="editImagePreviewContainer" style="display: none;">
                            <label class="form-label">Image Preview</label>
                            <div class="text-center">
                                <img id="editImagePreview" class="product-image-preview" src="" alt="Product Preview">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success fw-bold">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteProductModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body fw-bold  ">
                    <p>Are you sure you want to delete this product?</p>
                    <p class="text-muted">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger fw-bold" id="confirmDeleteBtn">
                        <i class="fas fa-trash me-2"></i>Delete Product
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let products = [];
        let currentProductId = null;

        // Load products on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
            setupEventListeners();
        });

        function setupEventListeners() {
            // Add product form submission
            document.getElementById('addProductForm').addEventListener('submit', handleAddProduct);

            // Edit product form submission
            document.getElementById('editProductForm').addEventListener('submit', handleEditProduct);

            // Delete confirmation
            document.getElementById('confirmDeleteBtn').addEventListener('click', handleDeleteProduct);

            // Image preview for add form
            document.getElementById('productImage').addEventListener('input', function() {
                showImagePreview(this.value, 'imagePreview', 'imagePreviewContainer');
            });

            // Image preview for edit form
            document.getElementById('editProductImage').addEventListener('input', function() {
                showImagePreview(this.value, 'editImagePreview', 'editImagePreviewContainer');
            });
        }

        function loadProducts() {
            showLoading(true);
            fetch('/admin/api/products')
                .then(response => response.json())
                .then(data => {
                    products = data;
                    displayProducts();
                    showLoading(false);
                })
                .catch(error => {
                    console.error('Error loading products:', error);
                    showAlert('Error loading products. Please try again.', 'danger');
                    showLoading(false);
                });
        }

        function displayProducts() {
            const tbody = document.getElementById('productsTableBody');
            tbody.innerHTML = '';

            if (products.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <div class="d-flex flex-column align-items-center">
                                <i class="fas fa-box-open fa-4x mb-3 text-secondary opacity-50"></i>
                                <p class="h5 mb-1">No products found</p>
                                <p class="text-muted">Add your first product to get started!</p>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="${product.image || 'https://via.placeholder.com/60x60?text=No+Image'}" 
                                 alt="${product.name}" 
                                 class="product-img"
                                 onerror="this.src='https://via.placeholder.com/60x60?text=No+Image'">
                            <div>
                                <div class="fw-bold">${product.name}</div>
                                <div class="text-muted small fw-bold">${product.description || 'No description'}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        ${product.category ? `<span class="badge text-primary-emphasis

 px-3 py-2">${product.category}</span>` : '<span class="text-muted">No category</span>'}
                    </td>
                    <td class="text-center">
                        <span class="price-display  fw-bold  px-3 py-2">₹${parseFloat(product.price).toFixed(2)}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success  px-3 py-2">Active</span>
                    </td>
                    <td class="text-center">
                        ${product.page ? `<span class="badge bg-secondary">${product.page}</span>` : 'N/A'}
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-sm btn-outline-primary " onclick="editProduct(${product.id})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteProduct(${product.id})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        function handleAddProduct(e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());

            fetch('/admin/addProduct', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showAlert('Product added successfully!', 'success');
                        document.getElementById('addProductForm').reset();
                        document.getElementById('imagePreviewContainer').style.display = 'none';
                        bootstrap.Modal.getInstance(document.getElementById('addProductModal')).hide();
                        loadProducts();
                    } else {
                        showAlert(result.message || 'Failed to add product', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error adding product:', error);
                    showAlert('Error adding product. Please try again.', 'danger');
                });
        }

        function editProduct(productId) {
            const product = products.find(p => p.id == productId);
            if (!product) return;

            // Populate edit form
            document.getElementById('editProductId').value = product.id;
            document.getElementById('editProductName').value = product.name;
            document.getElementById('editProductDescription').value = product.description || '';
            document.getElementById('editProductPrice').value = product.price;
            document.getElementById('editProductCategory').value = product.category || '';
            document.getElementById('editProductPage').value = product.page || 'menu';
            document.getElementById('editProductImage').value = product.image || '';

            // Show image preview if exists
            if (product.image) {
                showImagePreview(product.image, 'editImagePreview', 'editImagePreviewContainer');
            } else {
                document.getElementById('editImagePreviewContainer').style.display = 'none';
            }

            // Show modal
            const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
            editModal.show();
        }

        function handleEditProduct(e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const productId = document.getElementById('editProductId').value;
            const data = Object.fromEntries(formData.entries());

            fetch(`/admin/updateProduct/${productId}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showAlert('Product updated successfully!', 'success');
                        bootstrap.Modal.getInstance(document.getElementById('editProductModal')).hide();
                        loadProducts();
                    } else {
                        showAlert(result.message || 'Failed to update product', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error updating product:', error);
                    showAlert('Error updating product. Please try again.', 'danger');
                });
        }

        function deleteProduct(productId) {
            currentProductId = productId;
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
            deleteModal.show();
        }

        function handleDeleteProduct() {
            if (!currentProductId) return;

            fetch(`/admin/deleteProduct/${currentProductId}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showAlert('Product deleted successfully!', 'success');
                        bootstrap.Modal.getInstance(document.getElementById('deleteProductModal')).hide();
                        loadProducts();
                    } else {
                        showAlert(result.message || 'Failed to delete product', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error deleting product:', error);
                    showAlert('Error deleting product. Please try again.', 'danger');
                });

            currentProductId = null;
        }

        function showImagePreview(imageUrl, previewId, containerId) {
            const preview = document.getElementById(previewId);
            const container = document.getElementById(containerId);

            if (imageUrl && imageUrl.trim() !== '') {
                preview.src = imageUrl;
                preview.onerror = function() {
                    this.src = 'https://via.placeholder.com/200x200?text=Invalid+Image+URL';
                };
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        function showAlert(message, type) {
            const alertContainer = document.getElementById('alertContainer');
            const alertId = 'alert-' + Date.now();

            alertContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" id="${alertId}" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            // Auto-hide after 5 seconds
            setTimeout(() => {
                const alert = document.getElementById(alertId);
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }

        function showLoading(show) {
            const spinner = document.getElementById('loadingSpinner');
            const table = document.getElementById('productsTable');

            if (show) {
                spinner.style.display = 'block';
                table.style.opacity = '0.5';
            } else {
                spinner.style.display = 'none';
                table.style.opacity = '1';
            }
        }
        // 🔎 Combined Search + Status Filter
        document.getElementById("search-term").addEventListener("input", applyFilters);
        document.getElementById("status-filter").addEventListener("change", applyFilters);

        function applyFilters() {
            const term = document.getElementById("search-term").value.toLowerCase();
            const status = document.getElementById("status-filter").value;
            const rows = document.querySelectorAll("#productsTableBody tr");

            rows.forEach(row => {
                // ફક્ત product name column જ લો
                const nameCell = row.querySelector("td:first-child .fw-bold");
                const productName = nameCell ? nameCell.innerText.toLowerCase() : "";

                const matchesSearch = productName.includes(term);

                let matchesStatus = true;
                if (status !== "All Status") {
                    matchesStatus = row.innerText.toLowerCase().includes(status.toLowerCase());
                }

                if (matchesSearch && matchesStatus) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</body>

</html>