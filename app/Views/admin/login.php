<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 380px;
            margin: 20px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            text-align: center;
            /* margin-bottom: 30px; */
        }

        .login-header h2 {
            color: #198754;
            font-weight: bold;
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

        .btn-login {
            background-color: #198754;
            border-color: #198754;
            width: 100%;
            padding: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            background-color: #146c43;
            border-color: #146c43;
        }

        .login-icon {
            font-size: 60px;
            color: #198754;
            margin-bottom: 20px;
        }

        .h2 {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        .l1 {
            font-weight: 600;
            color: #4e4b4bff !important;
        }

        .i {
            width: "160px";
            height: "160px";
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <i class="fas fa-shield-alt text-white fs-3 bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width:60px; height:60px; "></i>
                <h2 class="h2">Admin Login</h2>
                <p class="text-muted small fw-bold">
                    Access your admin dashboard
                </p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('admin/authenticate') ?>" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label l1">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" autoComplete="off"
                            autoCapitalize="words"
                            autoCorrect="off"
                            spellCheck={false} required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label l1">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" autoComplete="off"
                            autoCapitalize="words"
                            autoCorrect="off"
                            spellCheck={false} required>
                    </div>
                </div>
                <button type="submit" class="btn btn-login btn-success">Login</button>
            </form>
            <div class="text-center mt-3">
                <small class="text-muted fw-bold">
                    Secure admin access only
                </small>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>