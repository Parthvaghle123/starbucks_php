<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Starbucks || Register</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
      overflow-x: hidden;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    .signup-container {
      background-color: #fff;
      padding: 2rem;
      border-radius: 40px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 380px;
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

    .form-title {
      text-align: center;
      font-weight: bold;
      margin-bottom: 1rem;
      animation: slideIn 0.8s ease-in-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .btn-primary {
      transition: all 0.3s ease-in-out;
    }

    .btn-primary:hover {
      background-color: #0d6efd;
      transform: scale(1.05);
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
      font-weight: bold;
      transition: color 0.3s ease;
    }

    .gender-option input[type="radio"] {
      display: none;
    }

    .gender-option .box {
      width: 100px;
      height: 45px;
      background-color: #f0f0f0;
      border-radius: 8px;
      text-align: center;
      padding: 10px;
      cursor: pointer;
      border: 2px solid transparent;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      transition: 0.3s;
    }

    .gender-option .circle {
      width: 20px;
      height: 20px;
      border: 2px solid #555;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .gender-option input[type="radio"]:checked+.box {
      border-color: green;
    }

    .label-text {
      font-size: 14px;
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
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="signup-container">
      <h2 class="text-success h2 fw-bold fs-4 text-center">Sign-UP</h2>
      <hr>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
      <?php endif; ?>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>

      <form method="POST" action="<?= base_url('store') ?>">
        <div class="mb-3">
          <label for="username" class="form-label l1">Username</label>
          <input type="text" name="username" id="username" class="form-control" placeholder="Enter your name" autoComplete="off"
            autoCapitalize="words"
            autoCorrect="off"
            spellCheck={false} required />
        </div>

        <div class="mb-3">
          <label for="email" class="form-label l1">Email</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="example@email.com" autoComplete="off"
            autoCapitalize="words"
            autoCorrect="off"
            spellCheck={false} required />
        </div>

        <div class="mb-3">
          <label class="form-label l1">Phone</label>
          <div class="input-group">
            <select name="country_code" class="form-select" disabled style="max-width: 80px; height: 50px;">
              <option value="+91" selected>+91 </option>
              <option value="+1">+1 </option>
              <option value="+44">+44 </option>
              <option value="+61">+61 </option>
            </select>
            <input type="tel" name="phone" class="form-control" placeholder="9876543210" style="height: 50px;" autoComplete="off"
              autoCapitalize="words"
              autoCorrect="off"
              spellCheck={false} required />
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label l1">Gender</label>
          <div class="gender d-flex gap-3 justify-content-between">
            <label class="gender-option">
              <input type="radio" name="gender" value="male" required />
              <div class="box">
                <div class="label-text">Male</div>
              </div>
            </label>
            <label class="gender-option">
              <input type="radio" name="gender" value="female" />
              <div class="box">
                <div class="label-text">Female</div>
              </div>
            </label>
            <label class="gender-option">
              <input type="radio" name="gender" value="other" />
              <div class="box">
                <div class="label-text">Other</div>
              </div>
            </label>
          </div>
        </div>


        <div class="mb-3">
          <label for="dob" class="form-label l1">Date of Birth</label>
          <input type="date" name="dob" id="dob" class="form-control" required />
        </div>

        <div class="mb-3">
          <label for="address" class="form-label l1">Address</label>
          <textarea name="address" id="address" class="form-control" placeholder="Enter your address" rows="2" style="resize: none; height: 80px;" required></textarea>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label l1">Password</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="********" required />
          <small id="strengthMessage" class="text-muted strength"></small>
        </div>

        <button type="submit" class="btn btn-success w-100 fw-bold">Register</button>
      </form>

      <p class="text-center mt-3">
        Already registered? <a class="text-decoration-none fw-bold text-success" href="<?= base_url('login') ?>">Login here</a>
      </p>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Password Strength Script Only -->
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