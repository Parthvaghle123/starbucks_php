<?php
$cart = session()->get('cart') ?? [];
$count = count($cart);
$base_url = base_url('manage_cart');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>starbucks || Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- ✅ Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- ✅ AOS CSS -->

  <!-- ✅ Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('css/header.css') ?>">
  <link rel="stylesheet" href="<?= base_url('css/images.css') ?>">
  <link rel="stylesheet" href="<?= base_url('css/item.css') ?>">

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
  <!-- ✅ Add to Cart Success Popup -->
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
        <ul class="navbar-nav me-auto mb-2 mb-lg-0  gap-5 nav-links">
          <li class="nav-item"><a class="nav-link underline-animate" href="<?= base_url('/') ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link underline-animate" href="<?= base_url('/gift') ?>">Gift</a></li>
          <li class="nav-item"><a class="nav-link underline-animate" href="<?= base_url('/menu') ?>">Menu</a></li>
          <li class="nav-item"><a class="nav-link underline-animate" href="<?= base_url('/orders') ?>">Order</a></li>
        </ul>

        <form class="d-flex me-4" onsubmit="event.preventDefault(); searchProducts();">
          <input class="me-2 search bg-light w-100 head" type="search" placeholder="Search" aria-label="Search" id="search" autocomplete="off"/>
          <button id="searchButton" class="btn1 btn btn-success" type="submit">
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

  <!-- ✅ Carousel -->
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div id="carouselExampleControls" class="carousel slide mt-5" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="https://cdn.sbux.com.my/media/bc78f7ce-b47d-43e3-b297-14543013d3a8.jpg" class="d-block w-100 img-fluid" style="max-height: 400px; object-fit: cover;">
            </div>
            <div class="carousel-item">
              <img src="https://cdn.sbux.com.my/media/34163518-78f9-4a5e-afba-3d969535f4c8.webp" class="d-block w-100 img-fluid" style="max-height: 400px; object-fit: cover;">
            </div>
            <div class="carousel-item">
              <img src="https://pbs.twimg.com/media/EhpesVAWsAE7Tmj.jpg" class="d-block w-100 img-fluid" style="max-height: 400px; object-fit: cover;">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>
    </div>
  </div>


  <!-- ✅ Section: Handcrafted Curations -->
  <div class="Herosection_1">
    <div class="container">
      <h3 class="mt-5 pt-3 text-success head fst-italic">Handcrafted Curations</h3>
      <div id="root"></div>
    </div>
  </div>

  <div class="Herosection_2">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center mt-2 pt-4 mb-3 flex-wrap">
        <h3 class="text-success head fst-italic mb-0">
          Barista Recommends
        </h3>

        <a
          href="<?= base_url('/menu') ?>"
          class="btn btn-outline-success btn-sm fw-bold">
          <i class="fas fa-utensils me-1"></i> View Menu
        </a>
      </div>
      <!-- Wait Message -->
      <div id="messageBox" style="display: none; text-align: center; margin: 20px 0;">
        <div style="display: inline-flex; align-items: center; gap: 10px;">
          <div class="spinner"></div>
          <p class="fs-5 fst-italic fw-bold text-dark mb-0">Please wait...</p>
        </div>
      </div>

      <!-- Product Display -->
      <div id="root1"></div>
    </div>
  </div>

  <!-- ✅ Section: Coffee Brewing Info -->
  <div class="Herosection_3 mt-4">
    <div class="container">
      <h3 class="mt-3 pt-4 text-success head fst-italic">Learn more about the world of coffee!</h3>
      <div class="card bg-dark text-white mt-4 mb-4">
        <img src="https://preprodtsbstorage.blob.core.windows.net/cms/uploads/ICW_Live_Event_Day5_41f11ca3d2.jpg" class="card-img" height="400px">
        <div class="card-img-overlay" style="background-color: rgba(0, 0, 0, 0.5);">
          <h5 class="card-title fs-4 ms-4 fst-italic">Art & Science Of Coffee Brewing</h5>
          <p class="card-text ms-4 fst-italic"> Master the perfect brew with starbucks! Learn the art and
            science of coffee brewing.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- ✅ Footer -->
  <footer class="bg-dark text-white pt-5 pb-3 fw-medium shadow-lg">
    <div class="container">
      <div class="row justify-content-start">
        <div class="col-md-5 mb-4 text-md-start text-center">
          <h5 class="text-uppercase fw-bold text-warning mb-3 border-bottom border-warning pb-2 fs-5">
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
            <strong class="text-warning text-decoration-none"> Noob Ninjas</strong>
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


  <!-- ✅ JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url('js/images.js') ?>"></script>
  <script src="<?= base_url('js/item.js') ?>"></script>

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