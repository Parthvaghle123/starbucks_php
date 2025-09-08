<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Starbucks</title>

  <!-- Bootstrap CSS (v5.3) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- Font Awesome (icons) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Inter', sans-serif;
      /* Ensuring Inter font is applied */
    }

    .navbar-brand {
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .h3 {
      margin-top: 7px;
    }

    .nav-link {
      font-weight: bold;
      padding: 0.5rem 1rem !important;
      border-radius: 0.375rem;
      transition: all 0.2s ease-in-out;
      margin: 0 0.25rem;
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

    /* Centering the dropdown menu itself */
    .navbar-nav .dropdown-menu {
      left: 50%;
      /* Start the menu at 50% from the left of its parent */
      transform: translateX(-50%);
      /* Shift it back by half its own width to center it */
      min-width: 150px;
      /* Give it a minimum width for better appearance */
      text-align: center;
      /* Center the text inside the dropdown menu items */
    }

    /* Centering dropdown item text (redundant if applied to dropdown-menu but good for clarity) */
    .dropdown-menu .dropdown-item {
      text-align: center;
      /* Ensures text within each item is centered */
    }

    .h2 {
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
      font-size: 20px;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <div class="container">
      <!-- Brand -->
      <a class="navbar-brand d-flex align-items-center" href="<?= base_url('admin/dashboard') ?>">
        <img src="https://upload.wikimedia.org/wikipedia/en/d/d3/Starbucks_Corporation_Logo_2011.svg" alt="Starbucks" height="45">
        <h3 class="text-success fw-bold ms-1 fs-4 h3">Starbucks</h3>
      </a>

      <!-- Toggler (Responsive button) -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Collapsible Navbar -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <!-- Left links -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-bold">
          <li class="nav-item">
            <a class="nav-link <?= uri_string() == 'admin/dashboard' ? 'active' : '' ?>"
              href="<?= base_url('admin/dashboard') ?>">
              <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= uri_string() == 'admin/users' ? 'active' : '' ?>"
              href="<?= base_url('admin/users') ?>">
              <i class="fas fa-users"></i> Users
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= uri_string() == 'admin/orders' ? 'active' : '' ?>"
              href="<?= base_url('admin/orders') ?>">
              <i class="fas fa-shopping-cart"></i> Orders
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= uri_string() == 'admin/products' ? 'active' : '' ?>"
              href="<?= base_url('admin/products') ?>">
              <i class="fas fa-box"></i> Products
            </a>
          </li>
        </ul>

        <!-- Right (User dropdown) -->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
            <a class="text-decoration-none dropdown-toggle text-dark fw-bold h2" href="#" id="userDropdown"
              role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-user-circle"></i>
              <!-- The 'Admin' text you wanted -->
              Admin
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
              <li>
                <a class="dropdown-item" href="<?= base_url('admin/logout') ?>">
                  <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
              </li>
            </ul>
          </li>
        </ul>

      </div>
    </div>
  </nav>

  <!-- Bootstrap Bundle (with Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const mql = window.matchMedia('(min-width: 992px)'); // lg breakpoint

      // 1) Desktop પર hover થી dropdown open/close
      document.querySelectorAll('.nav-item.dropdown').forEach(function(dd) {
        dd.addEventListener('mouseenter', function() {
          if (!mql.matches) return;
          const toggle = dd.querySelector('[data-bs-toggle="dropdown"]');
          const menu = dd.querySelector('.dropdown-menu');
          dd.classList.add('show');
          menu.classList.add('show');
          toggle.setAttribute('aria-expanded', 'true');
        });
        dd.addEventListener('mouseleave', function() {
          if (!mql.matches) return;
          const toggle = dd.querySelector('[data-bs-toggle="dropdown"]');
          const menu = dd.querySelector('.dropdown-menu');
          dd.classList.remove('show');
          menu.classList.remove('show');
          toggle.setAttribute('aria-expanded', 'false');
        });
      });

      // 2) Mobile પર click થયા પછી Navbar auto-close
      const collapseEl = document.getElementById('navbarNav');

      document.querySelectorAll('#navbarNav .nav-link, #navbarNav .dropdown-item').forEach(function(link) {
        link.addEventListener('click', function() {
          const toggler = document.querySelector('.navbar-toggler');
          if (window.getComputedStyle(toggler).display !== 'none') {
            const bsCollapse = bootstrap.Collapse.getInstance(collapseEl) || new bootstrap.Collapse(collapseEl, {
              toggle: false
            });
            bsCollapse.hide();
          }
        });
      });
    });
  </script>
</body>

</html>