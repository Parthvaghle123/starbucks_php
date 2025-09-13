<!DOCTYPE html>
<html>

<head>
  <title>Starbucks || Change Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

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

    @keyframes slideFadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .custom-alert {
      animation: slideFadeIn 0.5s ease forwards;
      font-weight: 600;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      gap: 10px;
    }

    .custom-alert i {
      font-size: 1.5rem;
      color: green;
    }

    .btn-success:hover {
      background-color: #28a745;
      transform: scale(1.05);
      transition: transform 0.3s ease;
    }

    .form-control:focus {
      box-shadow: 0 0 5px rgba(13, 110, 253, 0.5);
      border-color: #0d6efd;
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
    <div class="login-container m-auto">
      <h3 class="text-center text-success h2 mb-3 fw-bold ">Change Password</h3>
      <div id="alert" class="d-none"></div>
      <hr>

      <!-- Step 1: Email Verification -->
      <form id="step1" onsubmit="verifyEmail(event)">
        <div class="mb-3">
          <label class="l1">Email</label>
          <input type="email" id="email" name="email" class="form-control mt-2" placeholder="example@email.com" autoComplete="off"
            autoCapitalize="words"
            autoCorrect="off"
            spellCheck={false} required>
        </div>
        <button class="btn btn-success w-100 fw-bold">Verify Email</button>
      </form>

      <!-- Step 2: Change Password -->
      <form id="step2" onsubmit="changePassword(event)" style="display: none;">
        <input type="hidden" id="hidden_email" name="email">
        <div class="mb-3">
          <label class="l1">New Password</label>
          <input type="password" id="newPassword" class="form-control mt-2" placeholder="********" required>
        </div>
        <div class="mb-3">
          <label class="l1">Confirm Password</label>
          <input type="password" id="confirmPassword" class="form-control mt-2" placeholder="********" required>
        </div>
        <button class="btn btn-success w-100 fw-bold">Change Password</button>
      </form>
    </div>
  </div>

  <script>
    async function verifyEmail(e) {
      e.preventDefault();
      const email = document.getElementById('email').value;
      const btn = e.target.querySelector('button');

      btn.disabled = true;
      const originalText = btn.innerText;
      btn.innerText = 'Verifying...';

      const res = await fetch('/verify-email', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `email=${encodeURIComponent(email)}`
      });

      const data = await res.json();
      const alertBox = document.getElementById('alert');

      if (data.exists) {
        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'block';
        document.getElementById('hidden_email').value = email;
        alertBox.className = 'alert alert-success custom-alert';
        alertBox.innerHTML = '<i class="fas fa-check-circle"></i> Email verified ✅';
      } else {
        alertBox.className = 'alert alert-danger custom-alert';
        alertBox.innerHTML = '<i class="fas fa-times-circle"></i> Email not found ❌';
      }

      alertBox.classList.remove('d-none');

      setTimeout(() => {
        btn.disabled = false;
        btn.innerText = originalText;
      }, 5000);
    }

    async function changePassword(e) {
      e.preventDefault();
      const newPassword = document.getElementById('newPassword').value;
      const confirmPassword = document.getElementById('confirmPassword').value;
      const email = document.getElementById('hidden_email').value;
      const alertBox = document.getElementById('alert');

      if (newPassword !== confirmPassword) {
        alertBox.className = 'alert alert-danger custom-alert';
        alertBox.innerHTML = '<i class="fas fa-times-circle"></i> Passwords do not match ❌';
        alertBox.classList.remove('d-none');
        return;
      }

      const res = await fetch('/change-password', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `email=${encodeURIComponent(email)}&newPassword=${encodeURIComponent(newPassword)}`
      });

      const data = await res.json();

      if (data.message.includes("successfully")) {
        let countdown = 2;
        alertBox.className = 'alert alert-success custom-alert';
        alertBox.innerHTML = `
        <i class="fas fa-check-circle"></i> ${data.message}
        <button class="btn btn-success btn-sm mt-2" disabled>
          Please Wait <span id="timer">${countdown}</span>
        </button>
      `;
        alertBox.classList.remove('d-none');

        const interval = setInterval(() => {
          countdown--;
          document.getElementById('timer').textContent = countdown;
          if (countdown <= 0) {
            clearInterval(interval);
            window.location.href = "/login";
          }
        }, 1000);
      } else {
        alertBox.className = 'alert alert-danger custom-alert';
        alertBox.innerHTML = `<i class="fas fa-times-circle"></i> ${data.message}`;
        alertBox.classList.remove('d-none');
      }
    }
  </script>
</body>

</html>