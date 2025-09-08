<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .stat-card {
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
         }

        .status-badge {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 13px;
        }

        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            line-height: 1;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 17px;
            margin-top: 10px !important;
            /* small gap only */
            font-weight: bold;
        }

        /* Hover effect */
        .hover-card {
            transition: all 0.3s ease-in-out;
            min-height: 140px;
            /* Box size increase */
        }

        .hover-card:hover {
            transform: scale(1.05);
            /* Zoom effect */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            /* Hover shadow */
            background-color: #f8f9fa;
            /* little highlight */
        }

        .h5 {
            font-size: 17px !important;
            font-weight: 500;
            line-height: 1.2;
        }

        .card-header {
            background: #f0f4f7ff !important;
            /* little highlight */
        }

        /* Scrollable table */
        .table-responsive {
            overflow-x: auto;
            /* Horizontal scroll for small screens */
        }

        /* Sticky header on vertical scroll */
        .table thead.sticky-top th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f8f9fa;
            /* Matches header */
        }

        /* Row hover effect */
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Status badges */
        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
        }

        /* Colors */
        .status-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        tbody {
            font-weight: 600 !important;
        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>


    <!-- Main Content -->
    <div class="container">
        <div class="page-content">
            <h1 class="page-title mt-4">Dashboard</h1>
            <p class="page-subtitle fw-bold">Welcome to your admin dashboard</p>
        </div>
        <hr />
        <!-- Stats -->
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card bg-light text-white p-4 rounded d-flex justify-content-between align-items-center shadow-sm hover-card">

                    <div>
                        <h5 class="text-dark fw-bold">Total Users</h5>
                        <div class="stat-value fw-bold text-dark fs-3"><?= $totalUsers ?></div>
                    </div>
                    <i class="bi bi-people-fill fs-1 text-primary"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card bg-light text-white p-4 rounded d-flex justify-content-between align-items-center shadow-sm hover-card">
                    <div>
                        <h5 class="text-dark fw-bold">Total Orders</h5>
                        <div class="stat-value fw-bold text-dark fs-3"><?= $totalOrders ?></div>
                    </div>
                    <i class="bi bi-bag-check-fill fs-1 me-3 text-success"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card bg-light text-white p-4 rounded d-flex justify-content-between align-items-center shadow-sm hover-card">
                    <div>
                        <h5 class="text-dark fw-bold">Total Revenue</h5>
                        <div class="stat-value fw-bold text-dark fs-3">₹<?= number_format($totalRevenue) ?></div>
                    </div>
                    <i class="bi bi-currency-rupee fs-1 me-3 text-warning"></i>
                </div>
            </div>
        </div>
        <div class="card mt-4 mb-3 shadow-sm">
            <div class="card-header">
                <h5 class="fw-bold h5">Recent Orders</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($recentOrders)): ?>
                    <p class="m-3 text-muted">No recent orders found.</p>
                <?php else: ?>
                    <!-- Scrollable table wrapper -->
                    <div class="table-responsive" style="max-height:400px; overflow-y:auto;">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentOrders as $order): ?>
                                    <?php
                                    $status = strtolower($order['Status']);
                                    $badgeClass = match ($status) {
                                        'completed', 'approved' => 'status-completed',
                                        'cancelled' => 'status-cancelled',
                                        default => 'status-pending'
                                    };
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($order['id']) ?></td>
                                        <td><?= htmlspecialchars($order['username']) ?></td>
                                        <td>₹<?= number_format($order['total'] ?? 0, 2) ?></td>
                                        <td>
                                            <span class="status-badge <?= $badgeClass ?>">
                                                <?= htmlspecialchars($order['Status']) ?>
                                            </span>
                                        </td>
                                        <td><?= date('d-m-Y', strtotime($order['Date'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>


</body>

</html>