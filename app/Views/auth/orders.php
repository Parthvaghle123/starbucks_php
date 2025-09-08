<?php
$cart = session()->get('cart') ?? [];
$count = count($cart);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Starbucks || Order</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/header.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
      border-radius: 10px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: scale(1.01);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .btn-outline-danger {
      transition: all 0.3s ease-in-out;
    }

    .btn-outline-danger:hover {
      background-color: #dc3545;
      color: #fff;
    }

    .modal-content {
      animation: slideDown 0.4s ease-in-out;
    }

    @keyframes slideDown {
      from {
        transform: translateY(-20px);
        opacity: 0;
      }

      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .badge {
      font-size: 0.9rem;
      padding: 0.5em 0.75em;
    }

    .table thead th {
      background-color: #343a40;
      color: white;
    }

    .table td,
    .table th {
      vertical-align: middle !important;
    }

    .navbar-brand {
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .h3 {
      margin-top: 7px;
    }

    .nav-link {
      font-weight: bold;
      border-radius: 0.375rem;
      transition: all 0.2s ease-in-out;
    }

    .nav-link:hover {
      background-color: #218838;
      color: #fff !important;
    }

    .nav-link.active {
      background-color: #218838;
      color: #fff !important;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top" data-aos="fade-down">
    <div class="container">
      <a class="navbar-brand d-flex" href="<?= base_url('/') ?>">
        <img src="https://upload.wikimedia.org/wikipedia/en/d/d3/Starbucks_Corporation_Logo_2011.svg" alt="Starbucks" height="45">
        <h3 class="text-success fw-bold ms-1 fs-4 h3">Starbucks</h3>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-5 nav-links">
          <li class="nav-item"><a class="nav-link underline-animate" href="<?= base_url('/') ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link underline-animate" href="<?= base_url('/gift') ?>">Gift</a></li>
          <li class="nav-item"><a class="nav-link underline-animate" href="<?= base_url('/menu') ?>">Menu</a></li>
          <li class="nav-item"><a class="nav-link underline-animate" href="<?= base_url('/orders') ?>">Order</a></li>
        </ul>

        <form class="d-flex me-4" onsubmit="event.preventDefault(); searchProducts();">
          <input class="me-2 search bg-light w-100 head" type="search" placeholder="Search" aria-label="Search" id="search" />
          <button id="searchButton" class="btn btn-success" type="submit">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </form>

        <div class="d-flex align-items-center">
          <a href="<?= base_url('mycart') ?>" class="btn2 btn btn-success position-relative">
            🛒 MyCart
          </a>
          <div class="dropdown nav-item">
            <a class="text-decoration-none mt-1 ms-2 dropdown-toggle fw-bold text-dark" href="#" id="navbarDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle"></i> Account
            </a>
            <ul class="dropdown-menu custom-dropdown" aria-labelledby="navbarDropdown">
              <?php if (session()->get('username')): ?>
                <li class="dropdown-header text-success fw-bold">
                  <i class="fas fa-user me-2"></i>
                  <?= esc(session()->get('username')) ?>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item underline-animate" href="<?= base_url('logout') ?>">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
              <?php else: ?>
                <li><a class="dropdown-item underline-animate" href="<?= base_url('login') ?>">
                    <i class="fas fa-sign-in-alt me-2"></i>Login</a></li>
                <li><a class="dropdown-item underline-animate" href="<?= base_url('register') ?>">
                    <i class="fas fa-user-plus me-2"></i>Sign-Up</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- Orders Container -->
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-9 col-md-12 col-12">
        <!-- My Orders Title and Filter Dropdown -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
          <h2 class="fw-bold text-success pb-2 mb-0" data-aos="fade-down">🛒 My Orders</h2>

          <div>
            <select class="form-select w-auto" id="orderFilter">
              <option value="All">All Orders</option>
              <option value="Approved">Approved</option>
              <option value="Cancelled">Cancelled</option>
            </select>
          </div>
        </div>


        <?php if (!empty($orders)): ?>
          <?php foreach ($orders as $order): ?>
            <div class="card shadow-sm mb-5 border-start border-4 border-<?= $order['Status'] === 'Cancelled' ? 'danger' : 'success' ?>" data-aos="fade-up" data-status="<?= $order['Status'] ?>">
              <div class="card-header bg-light d-flex flex-column flex-md-row justify-content-between gap-2">
                <div><i class="fas fa-hashtag me-1"></i> <strong>Order ID:</strong> <?= $order['id'] ?></div>
                <div><i class="far fa-calendar-alt me-1"></i> <strong>Date:</strong> <?= $order['Date'] ?></div>
                <div>
                  <strong>Status:</strong>
                  <span class="badge bg-<?= $order['Status'] === 'Cancelled' ? 'danger' : ($order['Status'] === 'Approved' ? 'success' : 'warning') ?>">
                    <?= $order['Status'] ?>
                  </span>
                  <?php if ($order['Status'] === 'Approved'): ?>
                    <button class="btn btn-sm btn-outline-danger fw-bold" data-bs-toggle="modal" data-bs-target="#cancelModal" onclick="setCancelOrderId(<?= $order['id'] ?>)">
                      <i class="fas fa-ban me-1"></i>Cancel
                    </button>
                  <?php endif; ?>

                  <a href="<?= base_url('download-bill/' . $order['id']) ?>" class="btn btn-sm btn-outline-primary fw-bold">
                    Download Bill
                  </a>

                </div>
              </div>

              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-6"><strong><i class="fas fa-envelope me-1"></i>Email:</strong> <?= $order['Email'] ?></div>
                  <div class="col-md-6"><strong><i class="fas fa-phone me-1"></i>Phone:</strong> <?= $order['Phone'] ?></div>
                  <div class="col-md-6"><strong><i class="fas fa-map-marker-alt me-1"></i>Address:</strong> <?= $order['Address'] ?></div>
                  <div class="col-md-6"><strong><i class="fas fa-credit-card me-1"></i>Payment Mode:</strong> <?= $order['Pay_Mode'] ?></div>

                  <?php if (!empty($order['Reason']) && $order['Status'] === 'Cancelled'): ?>
                    <div class="col-12 text-danger fw-semibold mt-2">
                      <strong><i class="fas fa-comment-dots me-1"></i>Cancel Reason:</strong> <?= esc($order['Reason']) ?>
                    </div>
                  <?php endif; ?>
                </div>

                <h5 class="mt-4 border-bottom pb-2 text-secondary" data-aos="fade-right">🛒 Order Items</h5>
                <?php if (!empty($orderItems[$order['id']])): ?>
                  <div class="table-responsive mt-3">
                    <table class="table table-bordered text-center align-middle">
                      <thead class="table-dark text-white">
                        <tr>
                          <th>Item</th>
                          <th>Price (₹)</th>
                          <th>Qty</th>
                          <th>Status</th>
                          <th>Total (₹)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $grandTotal = 0;
                        foreach ($orderItems[$order['id']] as $item):
                          $total = $item['Price'] * $item['Quantity'];
                          $grandTotal += $total;
                        ?>
                          <tr>
                            <td><?= $item['Item_Name'] ?></td>
                            <td class="text-dark fw-bold">₹<?= number_format($item['Price'], 2) ?></td>
                            <td><?= $item['Quantity'] ?></td>
                            <td>
                              <span class="badge bg-<?= $item['Status'] === 'Cancelled' ? 'danger' : 'success' ?>">
                                <?= $item['Status'] ?>
                              </span>
                            </td>
                            <td class="text-success fw-bold">₹<?= number_format($total, 2) ?></td>
                          </tr>
                        <?php endforeach; ?>
                        <tr class="table-secondary fw-bold">
                          <td colspan="4" class="text-end">Grand Total</td>
                          <td class="text-success fs-5">₹<?= number_format($grandTotal, 2) ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                <?php else: ?>
                  <div class="alert alert-warning mt-3">❗ No items found for this order.</div>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="alert alert-info text-center"><i class="fas fa-box-open me-1"></i> No orders found!</div>
        <?php endif; ?>
      </div> <!-- end col-lg-8 -->
    </div> <!-- end row -->
  </div> <!-- end container -->

  <!-- Cancel Modal -->
  <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="/cancelOrder" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cancelModalLabel">Cancel Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="order_id" id="cancelOrderId" />
          <div class="form-check">
            <input class="form-check-input" type="radio" name="cancel_reason" value="Wrong contact number entered">
            <label class="form-check-label">Wrong contact number entered</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="cancel_reason" value="Wrong address selected" required>
            <label class="form-check-label">Wrong address selected</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="cancel_reason" value="Ordered by mistake">
            <label class="form-check-label">Ordered by mistake</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="cancel_reason" value="Expected delivery time is too long">
            <label class="form-check-label">Expected delivery time is too long</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="cancel_reason" value="Other" id="otherReasonRadio">
            <label class="form-check-label">Other</label>
          </div>
          <div class="mt-2" id="customReasonBox" style="display: none;">
            <textarea name="custom_reason" class="form-control" placeholder="Write your reason here..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger fw-bold">Submit Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function setCancelOrderId(orderId) {
      document.getElementById('cancelOrderId').value = orderId;
    }

    document.querySelectorAll('input[name="cancel_reason"]').forEach(radio => {
      radio.addEventListener('change', function() {
        document.getElementById('customReasonBox').style.display = (this.value === 'Other') ? 'block' : 'none';
      });
    });
  </script>
  <script>
    document.getElementById('orderFilter').addEventListener('change', function() {
      const selected = this.value;
      const cards = document.querySelectorAll('.card[data-status]');
      cards.forEach(card => {
        const status = card.getAttribute('data-status');
        if (selected === 'All' || status === selected) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      duration: 800,
      once: true
    });
  </script>
</body>

</html>