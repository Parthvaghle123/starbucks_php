<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Starbucks || Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; display: flex; justify-content: center; align-items: center; height: 100vh; }
    .checkout-card { max-width: 600px; width: 100%; background: white; padding: 25px 20px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
    h3 { color: #007bff; }
    #card-box { display: none; border-top: 1px solid #ccc; margin-top: 15px; padding-top: 10px; }
    input[readonly], select:disabled { background-color: white !important; cursor: not-allowed; }
    .checkout-title { font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 2.5rem; font-weight:700; color:#006241;text-align:center; letter-spacing:2px; text-shadow:2px 2px 6px rgba(0,0,0,0.2); }
    .checkout-subtitle { font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size:1.1rem; font-weight:500; color:#00754a;text-align:center;margin-top:5px; }
    .l1 { font-weight:600; color:#4e4b4bff !important; }
    .form-control { border-radius:8px; border:1px solid #aaa; padding:12px; font-size:16px; transition: border-color .3s, box-shadow .3s; }
    .form-control:focus { border-color: green !important; box-shadow: 0px 0px 6px rgba(0,128,0,0.5) !important; outline:none !important; }
    .form-control:hover { border-color: green !important; box-shadow: 0px 0px 6px rgba(0,128,0,0.5) !important; }
  </style>
</head>
<body>
  <div class="checkout-card border-0 p-4 rounded-4 mt-5">
    <h1 class="fs-3 text-success text-center fw-bold checkout-title">Payment</h1>
    <p class="text-success fw-bold text-center checkout-subtitle">Brew & Pay • Easy Checkout</p>
    <hr />
    <!-- assume PHP condition remains -->
    <form method="post" action="<?= base_url('/place-order') ?>" onsubmit="return validateForm();">
      <div class="mb-3 d-flex flex-column flex-sm-row gap-3">
        <div class="d-flex flex-column flex-fill">
          <label class="mb-2 l1">Email ID</label>
          <input type="email" class="form-control" name="email" value="<?= esc($user['email']) ?>" readonly required>
        </div>
        <div class="d-flex flex-column flex-fill">
          <label class="mb-2 l1">Phone Number</label>
          <div class="input-group">
            <select class="form-select" name="country_code" style="max-width: 100px;" disabled>
              <option value="+91" selected>+91 🇮🇳</option>
            </select>
            <input type="hidden" name="country_code" value="+91">
            <input type="tel" class="form-control" name="phone" id="phone" pattern="[0-9]{10}" value="<?= esc(substr($user['phone'], 0)) ?>" readonly required>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label class="mb-2 l1">Shipping Address</label>
        <textarea class="form-control" name="address" rows="2" placeholder="Enter your address" style="resize: none; height: 100px;" required></textarea>
      </div>

      <div class="mb-2">
        <label class="l1 mb-2">Payment Method</label>
        <div class="mb-2 d-flex flex-column flex-sm-row gap-3">
          <div class="flex-column flex-fill">
            <input class="form-check-input" type="radio" name="pay_mode" id="cod" value="COD" onchange="toggleCardBox()" required>
            <label class="form-check-label l1" for="cod">Cash on Delivery</label>
          </div>
          <div class="flex-column flex-fill">
            <input class="form-check-input" type="radio" name="pay_mode" id="online" value="Online" onchange="toggleCardBox()">
            <label class="form-check-label l1 me-5" for="online">Online Payment</label>
          </div>
        </div>
      </div>

      <div id="card-box">
        <h6 class="l1 fw-bold">Card Details :</h6>
        <div class="mb-3">
          <label class="mb-2 l1">Card Number</label>
          <!-- maxlength 19 to allow spaces (4*4 + 3 spaces = 19) -->
          <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19" inputmode="numeric" autocomplete="cc-number">
        </div>
        <div class="row">
          <div class="col">
            <label class="mb-2 l1">Expiry</label>
            <input type="text" class="form-control" id="expiry" name="expiry" placeholder="MM/YY" maxlength="5" inputmode="numeric" autocomplete="cc-exp">
          </div>
          <div class="col">
            <label class="mb-2 l1">CVV</label>
            <input type="text" class="form-control" id="cvv" name="cvv" placeholder="***" maxlength="4" inputmode="numeric" autocomplete="cc-csc">
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-success w-100 mt-4 fw-bold">Order Now</button>
    </form>

  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function toggleCardBox() {
      document.getElementById('card-box').style.display = document.getElementById('online').checked ? 'block' : 'none';
    }

    // Luhn algorithm function
    function luhnCheck(cardNumber) {
      // cardNumber should be a string of digits (no spaces)
      let sum = 0;
      let shouldDouble = false;
      // iterate from rightmost digit
      for (let i = cardNumber.length - 1; i >= 0; i--) {
        let digit = parseInt(cardNumber.charAt(i), 10);
        if (shouldDouble) {
          digit = digit * 2;
          if (digit > 9) digit -= 9;
        }
        sum += digit;
        shouldDouble = !shouldDouble;
      }
      return (sum % 10) === 0;
    }

    function validateForm() {
      if ($('#online').is(':checked')) {
        let rawCard = $('#card_number').val();
        // remove spaces and non-digit chars
        let card = rawCard.replace(/\D/g, '');
        let expiry = $('#expiry').val().trim();
        let cvv = $('#cvv').val().trim();

        // must be exactly 16 digits (adjust if you want to allow 15 for AMEX)
        if (card.length !== 16) {
          alert("Card number must contain exactly 16 digits.");
          return false;
        }

        // Luhn check
        if (!luhnCheck(card)) {
          alert("Invalid card number. Please enter the valid card number.");
          return false;
        }

        // Optional: reject very obvious invalid patterns like all same digit (e.g., 1111111111111111)
        if (/^(\d)\1{15}$/.test(card)) {
          alert("Invalid card number.");
          return false;
        }

        // Expiry date format check (MM/YY)
        if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiry)) {
          alert("Invalid date");
          return false;
        }

        // Expiry future check
        let parts = expiry.split('/');
        let expMonth = parseInt(parts[0], 10);
        let expYear = parseInt("20" + parts[1], 10);

        let today = new Date();
        let thisMonth = today.getMonth() + 1;
        let thisYear = today.getFullYear();

        if (expYear < thisYear || (expYear === thisYear && expMonth < thisMonth)) {
          alert("Card is expired.");
          return false;
        }

        // CVV check (3 or 4 digits)
        if (!/^\d{3,4}$/.test(cvv)) {
          alert("Invalid CVV.");
          return false;
        }
      }
      return true;
    }

    // Auto-formatting for card number (groups of 4)
    $('#card_number').on('input', function() {
      let val = this.value.replace(/\D/g, '').substring(0, 16); // only digits, max 16
      // format into groups of 4
      this.value = val.replace(/(.{4})/g, '$1 ').trim();
    });

    // keep CVV digits-only
    $('#cvv').on('input', function() {
      this.value = this.value.replace(/\D/g, '').substring(0, 4);
    });

    // expiry auto-format (MM/YY)
    $('#expiry').on('input', function() {
      let val = this.value.replace(/\D/g, '').substring(0, 4);
      if (val.length > 2) val = val.substring(0,2) + '/' + val.substring(2);
      this.value = val;
    });
  </script>
</body>
</html>
