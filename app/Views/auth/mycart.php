<?php $count = $count ?? 0; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Starbucks || Mycart</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Custom Header CSS -->
  <link rel="stylesheet" href="<?= base_url('css/header.css') ?>">

  <style>
    body {
      background-color: white;
      opacity: 0;
      transition: opacity 0.8s ease;
    }

    .card-custom {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
      padding: 20px;
    }

    th,
    td {
      vertical-align: middle !important;
    }

    .btn {
      transition: all 0.3s ease;
    }

    .btn:hover {
      transform: scale(1.05);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .itotal,
    #total {
      font-weight: 600;
    }

    .navbar ul {
      font-weight: bold;
    }

    @media (max-width: 768px) {
      .table-responsive {
        font-size: 0.9rem;
      }
    }

    .table-responsive {
      overflow-x: auto;
    }

    .table-bordered tr:hover {
      background-color: #f8f9fa;
    }

    tbody tr {
      animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    #card-box {
      transition: all 0.5s ease;
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

<body onload="document.body.style.opacity='1'">
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container">
      <a class="navbar-brand d-flex" href="<?= base_url('/') ?>">
        <img src="https://upload.wikimedia.org/wikipedia/en/d/d3/Starbucks_Corporation_Logo_2011.svg" alt="Starbucks" height="45">
        <h3 class="text-success fw-bold ms-1 fs-4 h3">Starbucks</h3>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0  gap-5 nav-links">
          <li class="nav-item"><a class="nav-link" href="<?= base_url('/') ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('/gift') ?>">Gift</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('/menu') ?>">Menu</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('/orders') ?>">Order</a></li>
        </ul>

        <form class="d-flex me-4" onsubmit="event.preventDefault(); searchProducts();">
          <input class="me-2 search bg-light w-100 head" type="search" placeholder="Search" id="search" />
          <button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
        </form>

        <div class="d-flex align-items-center">
          <a href="<?= base_url('mycart') ?>" class="btn2 btn btn-success position-relative">
            🛒 MyCart

          </a>
          <div class="dropdown nav-item">
            <a class="text-decoration-none mt-1 ms-2 dropdown-toggle fw-bold text-dark" href="#" id="navbarDropdown" role="button"
              <i class="fas fa-user-circle"></i> Account
            </a>
            <ul class="dropdown-menu text-center">
              <?php if (session()->get('username')): ?>
                <li class="dropdown-header text-success fw-bold">
                  <i class="fas fa-user me-2"></i>
                  <?= esc(session()->get('username')) ?>
                </li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
              <?php else: ?>
                <li><a class="dropdown-item" href="<?= base_url('login') ?>"><i class="fas fa-sign-in-alt me-2"></i>Login</a></li>
                <li><a class="dropdown-item" href="<?= base_url('register') ?>"><i class="fas fa-user-plus me-2"></i>Sign-Up</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- Cart Table Section -->
  <div class="container py-5 d-flex justify-content-center">
    <div class="row w-100" style="max-width: 1000px;">
      <div class="col-12">
        <div class="table-responsive p-3">
          <table class="table table-bordered text-center mb-0">
            <thead class="table-dark">
              <tr>
                <th>Image</th>
                <th>Item Name</th>
                <th>Item Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total = 0;
              if (isset($_SESSION["cart"])) {
                foreach ($_SESSION['cart'] as $key => $value) {
                  $quantity = isset($value['Quantity']) ? (int)$value['Quantity'] : 1;
                  $price = isset($value['Price']) ? (int)$value['Price'] : 0;
                  $itemTotal = $price * $quantity;
                  $total += $itemTotal;
              ?>
                  <tr>
                    <td><img src="<?= htmlspecialchars($value['Image']); ?>" width="80" style="border-radius: 15px;"></td>
                    <td><?= htmlspecialchars($value['Item_Name']); ?></td>
                    <td>₹<?= $price ?></td>
                    <td>
                      <form method="POST" action="<?= base_url('update_cart') ?>">
                        <input class="form-control text-center" type="number" name="Mod_Quantity" value="<?= $quantity ?>" min="1" max="32" onchange="this.form.submit()">
                        <input type="hidden" name="Item_Name" value="<?= htmlspecialchars($value['Item_Name']); ?>">
                      </form>
                    </td>
                    <td>₹<?= $itemTotal ?></td>
                    <td>
                      <form method="POST" action="<?= base_url('update_cart') ?>">
                        <input type="hidden" name="Item_Name" value="<?= htmlspecialchars($value['Item_Name']); ?>">
                        <button class="b1 btn btn-sm btn-danger fw-bold " type="submit" name="Remove_Item">Remove</button>
                      </form>
                    </td>
                  </tr>
              <?php }
              } ?>
              <!-- Total & Order Now Row -->
              <tr class="fw-bold">
                <td colspan="4" class="text-end">Total:</td>
                <td class="text-success fs-5">₹<?= $total ?></td>
                <td>
                  <form method="POST" action="<?= base_url('checkout') ?>">
                    <button class="b2 btn btn-success fw-bold">Order Now</button>
                  </form>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>