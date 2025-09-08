<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/user.css') ?>">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .page-header {
            margin-bottom: 20px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #343a40;
        }

        .page-header p {
            color: #6c757d;
        }

        hr {
            border-top: 1px solid #dee2e6;
            margin-bottom: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 150px;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .stat-header .stat-title {
            font-size: 1rem;
            color: #6c757d;
            font-weight: 500;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #212529;
        }

        .bg-blue {
            background-color: #3b82f6;
        }

        .bg-green {
            background-color: #10b981;
        }

        .bg-red {
            background-color: #ef4444;
        }

        .bg-purple {
            background-color: #8b5cf6;
        }

        .search-filter-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
            align-items: center;
        }

        .search-input {
            flex-grow: 1;
            min-width: 250px;
        }

        .search-input .form-control {
            padding-left: 40px;
            border-radius: 8px;
        }

        .search-input .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .filter-dropdown .form-select {
            border-radius: 8px;
            min-width: 150px;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
        }

        .modern-table thead th {
            background-color: #f1f5f9;
            color: #333;
            border-bottom: 2px solid #e2e8f0;
            padding: 15px 10px;
            white-space: nowrap;
            text-align: center;
        }

        .modern-table tbody tr {
            transition: background-color 0.2s ease-in-out;
            border-bottom: 1px solid #e2e8f0;
        }

        .modern-table tbody tr:last-child {
            border-bottom: none;
        }

        .modern-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .modern-table tbody td {
            padding: 12px 10px;
            text-align: center;
            vertical-align: middle;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .order-id {
            font-weight: 700 !important;
        }

        .customer-info {
            text-align: center;
            font-weight: 700 !important;
        }

        .customer-info .customer-name {
            font-weight: 700 !important;
            color: #343a40;
        }

        .customer-info .customer-details {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .view-items-btn {
            background-color: #e0f2f7;
            color: #007bff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: 700 !important;
            transition: background-color 0.2s;
        }

        .view-items-btn:hover {
            background-color: #ccecf4;
        }

        .total-amount {
            font-weight: 700;
            color: #10b981;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 700 !important;
            text-transform: capitalize;
            color: #fff;
        }

        .status-pending {
            background-color: #ffc107;
            color: #333;
        }

        .status-approved {
            background-color: #28a745;
        }

        .status-completed {
            background-color: #0d6efd;
        }

        .status-cancelled {
            background-color: #dc3545;
        }

        .cancel-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
            font-weight: 700 !important;
            transition: background-color 0.2s;
        }

        .cancel-btn:hover:not(:disabled) {
            background-color: #c82333;
        }

        .cancel-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .empty-state,
        .loading-state {
            text-align: center;
            padding: 50px 20px;
            color: #6c757d;
        }

        .empty-state h5 {
            font-weight: 600;
            margin-top: 15px;
            color: #343a40;
        }

        .modal-header,
        .modal-footer {
            background-color: #f8f9fa;
            border-color: #e9ecef;
        }

        .items-table-modal thead th {
            background-color: #f1f5f9;
            vertical-align: middle !important;
            align-items: center !important;
            font-weight: 600 !important;
        }

        .items-table-modal td,
        .items-table-modal th {
            vertical-align: middle !important;
            align-items: center !important;
            font-weight: 600 !important;
        }

        .summary-box {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 18px;
        }

        .summary-label {
            font-weight: 700;
            color: #374151;
        }

        .grand-total-row td {
            font-weight: 500 !important;
            font-size: 15px;
            border-top: 2px solid #dee2e6;
        }

        .modal-title {
            font-weight: 700 !important;
        }

        .items-table-modal thead th,
        .items-table-modal tbody td {
            text-align: center;
            font-weight: 600 !important;
        }

        .items-table-modal td,
        .items-table-modal th {
            vertical-align: middle;
            font-weight: 600 !important;

        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container py-4">
        <div class="page-header">
            <h1>Order Management</h1>
            <p>Manage and track all orders efficiently</p>
        </div>
        <hr />

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title fw-bold">Total Orders</span>
                    <div class="stat-icon bg-blue"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg></div>
                </div>
                <div class="stat-value" id="total-orders">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title fw-bold">Total Revenue</span>
                    <div class="stat-icon bg-green"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg></div>
                </div>
                <div class="stat-value" id="total-revenue">₹0.00</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title fw-bold">Cancelled Orders</span>
                    <div class="stat-icon bg-red"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg></div>
                </div>
                <div class="stat-value" id="cancelled-orders">0</div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title fw-bold">Completed Orders</span>
                    <div class="stat-icon bg-purple"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg></div>
                </div>
                <div class="stat-value" id="completed-orders">0</div>
            </div>
        </div>

        <div class="search-filter-container">
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
                    <option value="Approved">Approved</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <div id="loading-state" class="loading-state" style="display:none;">
            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
            <p class="mt-2">Loading orders...</p>
        </div>
        <div id="error-message" class="alert alert-danger" role="alert" style="display:none;"></div>
        <div id="empty-state" class="empty-state" style="display:none;"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-muted">
                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <path d="M16 10a4 4 0 0 1-8 0"></path>
            </svg>
            <h5>No orders found</h5>
            <p class="mb-0">Try adjusting your search or filter criteria</p>
        </div>

        <div class="table-responsive">
            <table id="orders-table" class="table mb-0 modern-table" style="display:none;">
                <thead>
                    <tr>
                        <th><span style="font-weight: 700;">Order ID</span></th>
                        <th><span style="font-weight: 700;">Customer</span></th>
                        <th><span style="font-weight: 700;">Items</span></th>
                        <th><span style="font-weight: 700;">Total</span></th>
                        <th><span style="font-weight: 700;">Status</span></th>
                        <th><span style="font-weight: 700;">Order Date</span></th>
                        <th><span style="font-weight: 700;">Payment</span></th>
                        <th><span style="font-weight: 700;">Action</span></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="itemsModal" tabindex="-1" aria-labelledby="itemsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="itemsModalLabel"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <line x1="10" y1="9" x2="8" y2="9"></line>
                        </svg>Order Details - <span id="modal-order-id"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="summary-box mb-3">
                        <div class="row gy-4">
                            <div class="col-md-6 col-12">
                                <div class="mb-1"><span class="summary-label">Customer:</span> <span id="modal-customer-name" style="font-weight: 600;"></span></div>
                                <div class="mb-1"><span class="summary-label">Email:</span> <span id="modal-customer-email" style="font-weight: 600;"></span></div>
                                <div class="mb-1"><span class="summary-label">Phone:</span> <span id="modal-customer-phone" style="font-weight: 600;"></span></div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="mb-1"><span class="summary-label">Date:</span> <span id="modal-order-date" style="font-weight: 600;"></span></div>
                                <div class="mb-1"><span class="summary-label">Payment:</span> <span id="modal-payment-method" style="font-weight: 600;"></span></div>
                                <div class="mb-1"><span class="summary-label">Status:</span> <span id="modal-order-status" style="font-weight: 600;"></span></div>
                            </div>
                        </div>
                    </div>
                    <div id="modal-items-container"></div>
                    <div id="modal-no-items" class="text-center py-4" style="display:none;">
                        <p class="text-muted mb-0">No items found in this order.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ordersTableBody = document.querySelector('#orders-table tbody');
            const loadingState = document.getElementById('loading-state');
            const emptyState = document.getElementById('empty-state');
            const errorMessage = document.getElementById('error-message');
            const ordersTable = document.getElementById('orders-table');
            const searchTermInput = document.getElementById('search-term');
            const statusFilterSelect = document.getElementById('status-filter');

            let allOrders = [];
            let itemsModalInstance = null;

            // --- UTILITY FUNCTIONS ---
            const formatDate = (dateStr) => {
                if (!dateStr) return 'N/A';
                const date = new Date(dateStr);
                return isNaN(date.getTime()) ? 'N/A' : date.toLocaleDateString("en-IN", {
                    day: "2-digit",
                    month: "short",
                    year: "numeric"
                });
            };

            const getStatusBadgeClass = (status) => {
                const s = (status || '').toLowerCase();
                if (s === 'approved') return 'status-badge status-approved';
                if (s === 'completed') return 'status-badge status-completed';
                if (s === 'cancelled') return 'status-badge status-cancelled';
                if (s === 'pending') return 'status-badge status-pending';
                return 'status-badge bg-secondary';
            };

            const renderStats = (orders) => {
                document.getElementById('total-orders').innerText = orders.length;
                document.getElementById('total-revenue').innerText =
                    `₹${orders.reduce((sum, order) => sum + (order.total || 0), 0).toFixed(2)}`;
                document.getElementById('cancelled-orders').innerText =
                    orders.filter(order => (order.status || '').toLowerCase() === 'cancelled').length;
                document.getElementById('completed-orders').innerText =
                    orders.filter(order => ['approved', 'completed'].includes((order.status || '').toLowerCase())).length;
            };

            const renderOrdersTable = (orders) => {
                ordersTableBody.innerHTML = '';
                if (!orders.length) {
                    emptyState.style.display = 'block';
                    ordersTable.style.display = 'none';
                    return;
                }
                emptyState.style.display = 'none';
                ordersTable.style.display = 'table';

                orders.forEach(order => {
                    const row = document.createElement('tr');
                    const lowerCaseStatus = (order.status || '').toLowerCase();
                    // Enable cancel for anything except already cancelled or completed
                    const isCancellable = !['cancelled', 'completed'].includes(lowerCaseStatus);

                    row.innerHTML = `
                        <td><span class="order-id">${order._id}</span></td>
                        <td>
                            <div class="customer-info">
                                <div class="customer-name">${order.username || 'N/A'}</div>
                                <div class="customer-details">${order.email || ''}<br>${order.phone || ''}</div>
                            </div>
                        </td>
                        <td><button class="btn btn-outline-primary view-items-btn" data-order-id="${order._id}">View (${order.items?.length || 0})</button></td>
                        <td><span class="total-amount">₹${(parseFloat(order.total) || 0).toFixed(2)}</span></td>
                        <td><span class="${getStatusBadgeClass(order.status)}">${order.status || 'N/A'}</span></td>
                        <td style="font-weight: 650;">${formatDate(order.createdAt)}</td>
                        <td style="font-weight: 650;">${order.paymentMethod || 'COD'}</td>
                        <td><button class="btn btn-outline-danger cancel-btn" data-order-id="${order._id}" ${!isCancellable ? 'disabled' : ''}>Cancel</button></td>
                    `;
                    ordersTableBody.appendChild(row);
                });

                attachRowEvents();
            };

            // --- EVENT HANDLING ---
            const attachRowEvents = () => {
                document.querySelectorAll('.view-items-btn').forEach(btn => {
                    btn.onclick = () => {
                        const order = allOrders.find(o => o._id === btn.dataset.orderId);
                        if (order) openOrderModal(order);
                    };
                });
                document.querySelectorAll('.cancel-btn:not(:disabled)').forEach(btn => {
                    btn.onclick = () => {
                        if (confirm("Are you sure you want to cancel this order?")) {
                            updateOrderStatus(btn.dataset.orderId, "Cancelled");
                        }
                    };
                });
            };

            const applyFilters = () => {
                const searchTerm = searchTermInput.value.toLowerCase().trim();
                const statusFilter = statusFilterSelect.value.toLowerCase();

                const filteredOrders = allOrders.filter(order => {
                    const matchesSearch = !searchTerm ||
                        String(order._id).toLowerCase().includes(searchTerm) ||
                        (order.username || '').toLowerCase().includes(searchTerm) ||
                        (order.email || '').toLowerCase().includes(searchTerm) ||
                        (order.phone || '').toLowerCase().includes(searchTerm);
                    const matchesStatus = statusFilter === 'all status' || (order.status || '').toLowerCase() === statusFilter;
                    return matchesSearch && matchesStatus;
                });

                renderStats(allOrders);
                renderOrdersTable(filteredOrders);
            };

            // --- MODAL & API LOGIC ---
            const openOrderModal = (order) => {
                document.getElementById('modal-order-id').innerText = order._id;
                document.getElementById('modal-customer-name').innerText = order.username || 'N/A';
                document.getElementById('modal-customer-email').innerText = order.email || 'N/A';
                document.getElementById('modal-customer-phone').innerText = order.phone || 'N/A';
                document.getElementById('modal-order-date').innerText = formatDate(order.createdAt);
                document.getElementById('modal-payment-method').innerText = order.paymentMethod || 'COD';

                const statusSpan = document.getElementById('modal-order-status');
                statusSpan.className = getStatusBadgeClass(order.status);
                statusSpan.innerText = order.status || 'N/A';

                const itemsContainer = document.getElementById('modal-items-container');
                const noItemsDiv = document.getElementById('modal-no-items');

                if (order.items && order.items.length > 0) {
                    // FIXED: Wrapped table in a responsive div
                    let tableHTML = `<div class="table-responsive"><table class="table table-striped items-table-modal" ><thead><tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr></thead><tbody>`;
                    order.items.forEach(item => {
                        const price = parseFloat(item.price) || 0;
                        const quantity = parseInt(item.quantity) || 0;
                        tableHTML += `
                            <tr>
                                <td>${item.name || 'Item'}</td>
                                <td>${quantity}</td>
                                <td>₹${price.toFixed(2)}</td>
                                <td>₹${(price * quantity).toFixed(2)}</td>
                            </tr>
                        `;
                    });
                    const grandTotal = parseFloat(order.total) || 0;
                    tableHTML += `</tbody><tfoot><tr class="grand-total-row"><td colspan="3" class="text-end"><strong>Grand Total:</strong></td><td><strong>₹${grandTotal.toFixed(2)}</strong></td></tr></tfoot></table></div>`;
                    itemsContainer.innerHTML = tableHTML;
                    itemsContainer.style.display = 'block';
                    noItemsDiv.style.display = 'none';
                } else {
                    itemsContainer.style.display = 'none';
                    noItemsDiv.style.display = 'block';
                }

                if (!itemsModalInstance) {
                    itemsModalInstance = new bootstrap.Modal(document.getElementById('itemsModal'));
                }
                itemsModalInstance.show();
            };

            const updateOrderStatus = (orderId, status) => {
                // Use canonical endpoint defined in routes
                fetch(`/admin/api/orders/${orderId}/status`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error(`Server responded with status ${res.status}`);
                        return res.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Order successfully cancelled!');
                            loadOrders();
                        } else {
                            throw new Error(data.message || 'Failed to update order.');
                        }
                    })
                    .catch(err => {
                        console.error("Update failed:", err);
                        alert(`Error: Could not cancel the order. ${err.message}`);
                    });
            };

            const loadOrders = () => {
                loadingState.style.display = 'block';
                errorMessage.style.display = 'none';
                emptyState.style.display = 'none';
                ordersTable.style.display = 'none';

                fetch('/admin/api/orders')
                    .then(res => {
                        if (!res.ok) throw new Error(`Network response was not ok (${res.status})`);
                        return res.json();
                    })
                    .then(data => {
                        loadingState.style.display = 'none';
                        allOrders = data.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
                        applyFilters();
                    })
                    .catch(err => {
                        loadingState.style.display = 'none';
                        errorMessage.innerText = `Failed to load orders: ${err.message}. Please try again later.`;
                        errorMessage.style.display = 'block';
                    });
            };

            // --- INITIALIZATION ---
            searchTermInput.addEventListener('input', applyFilters);
            statusFilterSelect.addEventListener('change', applyFilters);
            loadOrders();
        });
    </script>
</body>

</html>