<!DOCTYPE html>
<html>

<head>
    <title>Redirecting...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .loader {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #FF3D00;
            position: relative;
            margin: 20px auto;
        }

        .loader:before,
        .loader:after {
            content: "";
            position: absolute;
            border-radius: 50%;
            inset: 0;
            background: gray;
            transform: rotate(0deg) translate(30px);
            animation: rotate 1s ease infinite;
        }

        .loader:after {
            animation-delay: 0.5s;
        }

        @keyframes rotate {
            100% {
                transform: rotate(360deg) translate(30px);
            }
        }
    </style>
</head>

<body style="height: 90vh;">
    <div class="d-flex justify-content-center align-items-center flex-column h-100">
        <div class="loader"></div>
        <h4 class="fw-bold text-center fst-italic display-6"> Please wait... <span id="seconds"><?= esc($seconds) ?></span></h4>
    </div>
    <script>
        let seconds = <?= esc($seconds) ?>;
        const countdown = setInterval(() => {
            document.getElementById('seconds').innerText = seconds;
            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = "<?= esc($redirectUrl) ?>";
            }
            seconds--;
        }, 1000);
    </script>
</body>

</html>