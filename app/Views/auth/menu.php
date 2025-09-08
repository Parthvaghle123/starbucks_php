<?php
$cart = session()->get('cart') ?? [];
$count = count($cart);
$base_url = base_url('manage_cart');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Starbucks || Menu</title>

  <!-- ✅ Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- ✅ Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('css/header.css') ?>">
  <link rel="stylesheet" href="<?= base_url('css/item2.css') ?>">

  <style>
    .spinner {
      width: 20px;
      height: 20px;
      border: 3px solid gray;
      border-top: 3px solid white;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    footer {
      flex-shrink: 0;
    }

    .carousel-item img {
      object-fit: cover;
      height: 350px;
      border-radius: 20px;
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
  <div id="popup" class="popup">
    <div class="popup-content text-center"></div>
  </div>
  <!-- ✅ Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
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
          <button id="searchButton" class="btn1 btn btn-success" type="submit">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </form>

        <div class="d-flex align-items-center">
          <a href="<?= base_url('mycart') ?>" class="btn4 btn btn-success position-relative">
            🛒 MyCart
          </a>

          <!-- Account Dropdown -->
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
                <li><a class="dropdown-item underline-animate" href="<?= base_url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
              <?php else: ?>
                <li><a class="dropdown-item underline-animate" href="<?= base_url('login') ?>"><i class="fas fa-sign-in-alt me-2"></i>Login</a></li>
                <li><a class="dropdown-item underline-animate" href="<?= base_url('register') ?>"><i class="fas fa-user-plus me-2"></i>Sign-Up</a></li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- ✅ Animated Hero Section -->
  <div class="Herosection_1">
    <div class="container">
      <div id="messageBox" style="display: none; text-align: center; margin: 20px 0;">
        <div style="display: inline-flex; align-items: center; gap: 10px;">
          <div class="spinner"></div>
          <p style="margin: 0; font-weight: bold; color: black;" class="fs-5 fst-italic">Please wait...</p>
        </div>
      </div>
      <div id="root1"></div>
    </div>
  </div>

  <!-- ✅ Footer -->
  <!-- ✅ Footer -->
  <footer class="bg-dark text-white pt-5 pb-3 fw-medium shadow-lg">
    <div class="container">
      <div class="row justify-content-start">
        <div class="col-md-5 mb-4 text-md-start text-center">
          <h5 class="text-uppercase fw-bold text-warning mb-3 border-bottom border-warning pb-2">
            Contact
          </h5>
          <p class="mb-2">
            <i class="fas fa-map-marker-alt me-2 text-warning"></i>
            Surat, Gujarat
          </p>
          <p class="mb-2">
            <i class="far fa-envelope me-2 text-warning"></i>
            vaghlaparth2005@gmail.com
          </p>
          <p>
            <i class="fas fa-phone me-2 text-warning"></i>
            +91 8735035021
          </p>
        </div>
      </div>

      <hr class="border-secondary" />

      <div class="row align-items-center justify-content-between">
        <div class="col-md-6 text-md-start text-center mb-md-0">
          <p class="mb-0">
            Owned by:
            <strong class="text-warning text-decoration-none"> Noob Ninjas </strong>
          </p>
        </div>

        <div class="col-md-6 text-md-end text-center">
          <ul class="list-inline mb-0">
            <li class="list-inline-item mx-1">
              <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle" aria-label="facebook">
                <i class="fab fa-facebook-f text-white"></i>
              </a>
            </li>
            <li class="list-inline-item mx-1">
              <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle" aria-label="twitter">
                <i class="fab fa-x-twitter text-white"></i>
              </a>
            </li>
            <li class="list-inline-item mx-1">
              <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle" aria-label="linkedin">
                <i class="fab fa-linkedin-in text-white"></i>
              </a>
            </li>
            <li class="list-inline-item mx-1">
              <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle" aria-label="instagram">
                <i class="fab fa-instagram text-white"></i>
              </a>
            </li>
            <li class="list-inline-item mx-1">
              <a href="#" class="social-icon d-inline-flex align-items-center justify-content-center rounded-circle" aria-label="youtube">
                <i class="fab fa-youtube text-white"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <!-- ✅ JS Includes -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('js/item2.js') ?>"></script>

  <!-- ✅ AOS JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true
    });
  </script>
  <script>
    const baseUrl = "<?= base_url() ?>"; // PHP માંથી base URL મેળવો
  </script>
</body>

</html>