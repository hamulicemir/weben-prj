<?php
require_once("../../backend/config/config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - Sign-Up</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../assets/js/signup.js" defer></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;

        }
    </style>
</head>

<body>
    <?php include '../components/navbar.php'; ?> <!-- navbar -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <main class="container py-5">
    <div class="row d-flex align-items-start">

        <!-- Benefits -->
        <section class="col-12 col-md-4 offset-md-1 mb-4 d-flex flex-column justify-content-start">
            <h2>Your Benefits with an ICONIQ Account</h2>
            <ul class="list-checked">
                <li>Shop faster</li>
                <li>Save your favorite items</li>
                <li>Track your order status</li>
                <li>Manage invoices & personal data</li>
            </ul>
        </section>

        <!-- Signup Form as Card -->
        <section class="col-12 col-md-6 ms-md-5">
            <div class="card shadow-sm mt-1">
                <div class="card-body pt-1">
                    <h1 class="card-title mb-4">Create Customer Account</h1>
                    
                    <form id="signupForm" method="post">
                        <div class="mb-3">
                            <?php foreach (["Ms", "Mr", "Other"] as $s): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="salutation" id="salutation_<?= $s ?>" value="<?= $s ?>" required>
                                    <label class="form-check-label" for="salutation_<?= $s ?>"><?= $s ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="street" class="form-label">Street</label>
                                <input type="text" class="form-control" id="street" name="street" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="no" class="form-label">No.</label>
                                <input type="text" class="form-control" id="no" name="no" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="addressaddition" class="form-label">Address Addition (optional)</label>
                            <input type="text" class="form-control" id="addressaddition" name="addressaddition">
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="zip" class="form-label">ZIP Code</label>
                                <input type="text" class="form-control" id="zip" name="zip" required>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="payment_info" class="form-label">IBAN No. for Direct Debit</label>
                            <input type="text" class="form-control" id="payment_info" name="payment_info" required>
                        </div>


                        <div class="mb-3 position-relative">
                            <label class="form-label">Password</label>
                            <input type="password" name="password1" class="form-control pe-5" id="password1">
                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2"
                                    onmousedown="togglePassword('password1', true)"
                                    onmouseup="togglePassword('password1', false)"
                                    onmouseleave="togglePassword('password1', false)">
                                Show
                            </button>
                        </div>

                        <div class="mb-3 position-relative">
                            <label class="form-label">Repeat new password</label>
                            <input type="password" name="password2" class="form-control pe-5" id="password2">
                            <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2"
                                    onmousedown="togglePassword('password2', true)"
                                    onmouseup="togglePassword('password2', false)"
                                    onmouseleave="togglePassword('password2', false)">
                                Show
                            </button>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-8">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="policy" required>
                                    <label class="form-check-label" for="policy">
                                        I accept the <a href="#">privacy policy</a>
                                    </label>
                                </div>
                            </div>
                        <button type="submit" class="btn btn-dark w-100 mt-3">Create Account</button>

                        <div class="d-flex mt-3 col-md-4 text-end text-muted">
                                <a class="text-muted" href="login.php">Already have an account?</a>
                            </div>
                    </form>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="signupSuccessModal" tabindex="-1" aria-labelledby="signupSuccessLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-center">
                        <div class="modal-header border-0">
                            <h5 class="modal-title w-100" id="signupSuccessLabel">Welcome to ICONIQ!</h5>
                        </div>
                        <div class="modal-body border-top">
                            Account created – you're logged in!
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <?php include '../components/footer.php'; ?> <!-- Footer -->
</body>

</html>