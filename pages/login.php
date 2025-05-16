<?php
require_once("../includes/config.php");
if (isset($_SESSION['user']['id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - Login</title>
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="../components/jquery-3.7.1.min.js"></script>
   

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .form-check-input:checked {
            background-color: black;
            border-color: black;
        }
    </style>
</head>

<body>
    <?php include '../includes/navbar.php'; ?> <!-- navbar -->
    <main>
    <section class="py-3 py-md-5 py-xl-8 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <!-- Login-Formular -->
                <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                <div class="card border-0 rounded-4 shadow px-4 py-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">LOGIN</h2>
                        <p>Please log in with your email address or username and password.</p>
                    </div>
                    <form id="loginForm">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="login" name="login" placeholder="Username or Email" required>
                            <label for="login">Username or Email</label>
                        </div>
                        <div class="form-floating mb-3 position-relative">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            <label for="password">Password</label>
                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2"
                                    onmousedown="togglePassword('password', true)"
                                    onmouseup="togglePassword('password', false)"
                                    onmouseleave="togglePassword('password', false)">
                                Show
                            </button>
                        </div>
                            <div class="PP mb-3">
                                <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me">
                                <label class="form-check-label text-secondary" for="remember_me">Keep me logged in</label>
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-outline-dark fw-bold" type="submit">SIGN IN</button>
                            </div>
                        </form>
                        <div class="d-flex justify-content-between mt-3">
                            <a href="#" class="text-muted">Forgot password?</a>
                        </div>
                    </div>
                </div>

                <!-- Info-Bereich -->
                <div class="col-12 col-lg-6">
                    <div class="text-center text-lg-start px-3 px-md-5">
                        <h2 class="fw-bold">CREATE AN ACCOUNT</h2>
                        <p class="mb-4 mt-3">
                        Easily manage your account, track your orders and access your full purchase history.
                        </p>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">✔ Add and manage your address and payment info</li>
                            <li class="mb-2">✔ View and manage your personal orders	</li>
                            <li class="mb-2">✔ Print your invoices anytime</li>
                            <li class="mb-2">✔ Use and redeem your voucher codes</li>
                            <li class="mb-2">✔ Edit your account information securely</li>
                        </ul>
                        <a href="../pages/signup.php" class="btn btn-outline-dark fw-bold px-4 py-2">REGISTER NOW</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>
    <?php include '../includes/footer.php'; ?> <!-- Footer -->
    <script src="../assets/js/login.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    function togglePassword(id, show) {
        const input = document.getElementById(id);
        input.type = show ? 'text' : 'password';
    }
    </script>

</body>

</html>