<?php
session_start();

if (isset($_SESSION['user']['id'])) {
    header("Location: ../pages/index.php");
    exit();
}

if (isset($_COOKIE['remember_me'])) {
    header("Location: ../includes/login-handler.php");
    exit();
}

$loginError = $_SESSION['loginError'] ?? null;
unset($_SESSION['loginError']);
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
    <script src="../assets/js/login.js"></script>

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
                            <p>Please log in with your email address and password.</p>
                        </div>
                        <form id="loginForm">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" required>
                                <label for="email">E-mail address</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <label for="password">Password</label>
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

    <script>
        $(document).ready(function() {
            $("#loginForm").submit(function(e) {
                e.preventDefault();
                let email = $("#email");
                let password = $("#password");

                // Reset invalid classes
                email.removeClass("is-invalid");
                password.removeClass("is-invalid");

                // Validate inputs
                let isValid = true;
                if (password.val().length < 5) {
                    password.addClass("is-invalid");
                    isValid = false;
                }
                if (!email.val().includes("@")) {
                    email.addClass("is-invalid");
                    isValid = false;
                }

                if (!isValid) return;

                let formData = $(this).serialize();
                // Send AJAX request
                $.post("../includes/login-handler.php", formData, function(response) {
                    if (response.success) {
                        $("body").append(`
                            <div class="modal" id="welcomeModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Welcome!</h5>                                  
                                        </div>
                                        <div class="modal-body">
                                            <p>Welcome back to ICONIQ!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);

                        let welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
                        welcomeModal.show();

                        setTimeout(function() {
                            window.location.href = "../pages/index.php";
                        }, 1500);
                    } else {
                        if (response.errors && response.errors.email) {
                            email.addClass("is-invalid");
                        }
                        if (response.errors && response.errors.password) {
                            password.addClass("is-invalid");
                        }
                        if (response.errors && response.errors.general) {
                            alert(response.errors.general);
                        }
                    }
                }, "json").fail(function() {
                    alert("Login failed. Server error.");
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>