<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Starbucks || Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-container {
      background-color: white;
      padding: 30px;
      border-radius: 40px;
      box-shadow: 0px 0px 40px rgba(0, 0, 0, 0.1);
      max-width: 380px;
      width: 100%;
      animation: fadeIn 1s ease-in-out;
      opacity: 0;
      animation-fill-mode: forwards;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .btn-success:hover {
      background-color: #28a745;
      transform: scale(1.05);
      transition: transform 0.3s ease;
    }

    .form-control {
      transition: box-shadow 0.3s ease;
    }

    .form-control:focus {
      box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
      border-color: #0d6efd;
    }

    .strength {
      font-size: 0.9rem;
      font-weight: 600;
    }

    .l1 {
      font-weight: 600;
      color: #4e4b4bff !important;
    }

    .form-control {
      border-radius: 8px;
      border: 1px solid #aaa;
      padding: 12px;
      font-size: 16px;
      transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    /* ✅ Click/focus પર green effect override (Bootstrap fix) */
    .form-control:focus {
      border-color: green !important;
      box-shadow: 0px 0px 6px rgba(0, 128, 0, 0.5) !important;
      outline: none !important;
    }

    /* ✅ Hover પર green effect */
    .form-control:hover {
      border-color: green !important;
      box-shadow: 0px 0px 6px rgba(0, 128, 0, 0.5) !important;
    }
    .h2 {
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }
  </style>
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="login-container">
      <h2 class="text-success h2 mb-4 fw-bold fs-3 text-center">Login</h2>
      <hr>

      <form method="POST" action="/loginAuth">

        <div class="mb-3">
          <label for="email" class="form-label l1">Email</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="example@email.com" autoComplete="off"
            autoCapitalize="words"
            autoCorrect="off"
            spellCheck={false} required />
        </div>

        <div class="mb-3">
          <label class="form-label l1">Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
          <small id="strengthMessage" class="text-muted strength"></small>
        </div>
        <p class="mt-3">
          <a href="/change-password" class="text-decoration-none text-success fw-bold">Change Password</a>
        </p>


        <?php if (session()->getFlashdata('error')): ?>
          <div class="text text-danger mb-3"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <button type="submit" class="b1 btn btn-success w-100 fw-bold">Login</button>
      </form>

      <p class="mt-3 text-center">
        Don't have an account? <a href="/register" class="text-decoration-none fw-bold text-success">Register</a>
      </p>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Password Strength Script -->
  <script>
    const password = document.getElementById("password");
    const message = document.getElementById("strengthMessage");

    password.addEventListener("input", () => {
      const value = password.value;
      if (value.length < 4) {
        message.textContent = "Weak password ❌";
        message.style.color = "red";
      } else if (value.match(/[A-Z]/) && value.match(/[0-9]/) && value.length >= 8) {
        message.textContent = "Strong password ✅";
        message.style.color = "green";
      } else {
        message.textContent = "Moderate password ⚠️";
        message.style.color = "orange";
      }
    });
  </script>
</body>

</html>