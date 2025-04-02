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
    <?php include '../includes/navbar.php'; ?> <!-- navbar -->
    <section>
        <!-- Bitte gleichen Style wie Log-In Page-->
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <main class="container py-5">
        <div class="row">
            <section class="col-12 col-md-4 offset-md-1 mb-4">
                <h2>Your Benefits with an ICONIQ Account</h2>
                <ul class="list-checked">
                    <li>Shop faster</li>
                    <li>Save your favorite items</li>
                    <li>Track your order status</li>
                    <li>Manage invoices & personal data</li>
                </ul>
            </section>
            <section class="col-12 col-md-6">
                <h1>CREATE CUSTOMER ACCOUNT</h1>
                <form id="signupForm" action="../includes/signup-process.php" method="post">
                    <div class="form-row pt-3">
                        <div class="col-12 mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="title" value="ms" required>
                                <label class="form-check-label">Ms</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="title" value="mr" required>
                                <label class="form-check-label">Mr</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="title" value="other" required>
                                <label class="form-check-label">Other</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="" required>
                                <label for="firstname">First Name</label>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="" required>
                                <label for="lastname">Last Name</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control" id="street" name="street" placeholder="" required>
                                <label for="street">Street</label>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control" id="no" name="no" placeholder="" required>
                                <label for="no">No.</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="addressaddition" name="addressaddition" placeholder="">
                                <label for="addressaddition">Address Addition (optional)</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="" required>
                                <label for="zip">ZIP Code</label>
                            </div>
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control" id="city" name="city" placeholder="" required>
                                <label for="city">City</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="country" name="country" placeholder="" required>
                                <label for="country">Country</label>
                            </div>
                        </div>

                        <div class="row">
                            <label for="birthday" class="form-label">Birthday (optional)</label>

                            <div class="form-group col-md-4">
                                <select class="form-control" id="birthday_day" name="birthday_day">
                                    <option value="">DD</option>
                                    <?php for ($i = 1; $i <= 31; $i++): ?>
                                        <option value="<?= $i ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <select class="form-control" id="birthday_month" name="birthday_month">
                                    <option value="">MM</option>
                                    <?php for ($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?= $i ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <select class="form-control" id="birthday_year" name="birthday_year">
                                    <option value="">YYYY</option>
                                    <?php for ($i = date('Y'); $i >= 1950; $i--): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="">
                                <label for="phone">Phone Number (optional)</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="username" name="username" placeholder="" required>
                                <label for="username">Username</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="email" class="form-control" id="email" name="email" placeholder="" required>
                                <label for="email">Email Address</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="payment_info" name="payment_info" placeholder="" required>
                                <label for="payment_info">IBAN</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="password" class="form-control" id="password1" name="password1" placeholder="" required>
                                <label for="password1">Password</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <input type="password" class="form-control" id="password2" name="password2" placeholder="" required>
                                <label for="password2">Repeat Password</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <input type="checkbox" class="form-check-input" id="policy" required>
                                <label class="form-check-label" for="policy">
                                    I accept the <a href="#">privacy policy</a>
                                </label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-12">
                                <button type="submit" name="submit" class="btn btn-primary btn-block">Create Account</button>
                            </div>
                        </div>
                    </div>

                </form>
            </section>
        </div>
    </main>


    <?php include '../includes/footer.php'; ?> <!-- Footer -->
</body>

</html>