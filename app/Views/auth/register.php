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
      max-width: 600px;
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
      border-radius: 8px;
      border: 1px solid #aaa;
      padding: 12px;
      font-size: 16px;
      transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .form-control:focus {
      border-color: green !important;
      box-shadow: 0px 0px 6px rgba(0, 128, 0, 0.5) !important;
      outline: none !important;
    }

    .form-control:hover {
      border-color: green !important;
      box-shadow: 0px 0px 6px rgba(0, 128, 0, 0.5) !important;
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
      width: 80px;
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

    .h2 {
      font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }
  </style>

</head>

<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="signup-container">
      <h2 class="text-success h2 fw-bold  text-center">Sign-UP</h2>
      <hr>
      <div id="errorMessages" class="text-danger fw-bold mb-3"></div>

      <form id="registerForm" method="POST" action="<?= base_url('store') ?>">
        <div class="mb-3 d-flex flex-column flex-sm-row gap-3">
          <div class="d-flex flex-column flex-fill">
            <label for="username" class="form-label l1">Username</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter your name" autocomplete="off" required />
            <small class="text-danger"></small>
          </div>
          <div class="d-flex flex-column flex-fill">
            <label for="email" class="form-label l1">Email</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="example@email.com" autocomplete="off" required />
            <small class="text-danger"></small>
          </div>
        </div>

        <div class="mb-3 d-flex flex-column flex-sm-row gap-3">
          <div class="d-flex flex-column flex-fill">
            <label class="form-label l1">Phone</label>
            <div class="input-group">
              <select name="country_code" class="form-select" disabled style="max-width: 80px; height: 50px;">
                <option value="+91" selected>+91</option>
                <option value="+1">+1</option>
                <option value="+44">+44</option>
                <option value="+61">+61</option>
              </select>
              <input type="tel" name="phone" class="form-control" placeholder="9876543210" style="height: 50px;" autocomplete="off" required />
            </div>
            <small class="text-danger"></small>
          </div>
          <div class="d-flex flex-column flex-fill mt-1">
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
            <small class="text-danger"></small>
          </div>
        </div>

        <div class="mb-3">
          <label for="address" class="form-label l1">Address</label>
          <textarea name="address" id="address" class="form-control" placeholder="Enter your address" rows="2" style="resize: none; height: 80px;" required></textarea>
          <small class="text-danger"></small>
        </div>

        <div class="mb-3 d-flex flex-column flex-sm-row gap-3">
          <div class="d-flex flex-column flex-fill">
            <label for="dob" class="form-label l1">Date of Birth</label>
            <input type="date" name="dob" id="dob" class="form-control" required />
            <small class="text-danger"></small>
          </div>
          <div class="d-flex flex-column flex-fill">
            <label for="password" class="form-label l1">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="********" required />
            <small id="strengthMessage" class="text-muted strength"></small>
            <small class="text-danger"></small>
          </div>
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

  <!-- Password strength check -->
  <script>
    const password = document.getElementById("password");
    const message = document.getElementById("strengthMessage");

    password.addEventListener("input", () => {
      const value = password.value;
      if (value.length < 4) {
        message.textContent = "Weak password ❌";
        message.style.color = "red";
      } else if (value.match(/[A-Z]/) && value.match(/[0-9]/) && value.match(/[@$!%*?&]/) && value.length >= 8) {
        message.textContent = "Strong password ✅";
        message.style.color = "green";
      } else {
        message.textContent = "Moderate password ⚠️";
        message.style.color = "orange";
      }
    });
  </script>

  <!-- Username & Phone validation -->
  <script>
    const usernameInput = document.getElementById("username");
    const phoneInput = document.querySelector("input[name='phone']");

    // Username: letters & space only
    usernameInput.addEventListener("input", () => {
      usernameInput.value = usernameInput.value.replace(/[^A-Za-z\s]/g, '');
    });

    // Phone: digits only, max 10
    phoneInput.addEventListener("input", () => {
      phoneInput.value = phoneInput.value.replace(/\D/g, '');
      if (phoneInput.value.length > 10) {
        phoneInput.value = phoneInput.value.slice(0, 10);
      }
    });

    // Form submit validation
    document.getElementById("registerForm").addEventListener("submit", function (e) {
      let valid = true;
      document.querySelectorAll("small.text-danger").forEach(el => el.textContent = "");

      const username = usernameInput.value.trim();
      const email = document.getElementById("email").value.trim();
      const phone = phoneInput.value.trim();
      const gender = document.querySelector("input[name='gender']:checked");
      const dob = document.getElementById("dob").value;
      const address = document.getElementById("address").value.trim();
      const password = document.getElementById("password").value;

      // Username
      if (username.length < 3) {
        usernameInput.nextElementSibling.textContent = "Username must be at least 3 letters.";
        valid = false;
      }

      // Email
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        document.getElementById("email").nextElementSibling.textContent = "Enter a valid email address.";
        valid = false;
      }

      // Phone
      if (!/^\d{10}$/.test(phone)) {
        phoneInput.nextElementSibling.textContent = "Phone must be exactly 10 digits.";
        valid = false;
      }

      // Gender
      if (!gender) {
        document.querySelector(".gender").nextElementSibling.textContent = "Please select gender.";
        valid = false;
      }

      // DOB + age ≥ 14
      if (dob) {
        const today = new Date();
        const dobDate = new Date(dob);
        let age = today.getFullYear() - dobDate.getFullYear();
        const monthDiff = today.getMonth() - dobDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dobDate.getDate())) {
          age--;
        }
        if (age < 14) {
          document.getElementById("dob").nextElementSibling.textContent = "You must be at least 14 years old.";
          valid = false;
        }
      } else {
        document.getElementById("dob").nextElementSibling.textContent = "Date of birth is required.";
        valid = false;
      }

      // Address
      if (address.length < 5) {
        document.getElementById("address").nextElementSibling.textContent = "Address must be at least 5 characters.";
        valid = false;
      }

      // Password
      const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;
      if (!passwordRegex.test(password)) {
        document.getElementById("password").nextElementSibling.textContent =
          "Password must be 8+ chars, include 1 uppercase, 1 number, 1 special char.";
        valid = false;
      }

      if (!valid) e.preventDefault();
    });
  </script>
</body>
</html>
