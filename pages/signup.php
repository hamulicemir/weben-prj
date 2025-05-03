<?php
require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $salutation = $_POST['salutation'] ?? '';
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $street = trim($_POST['street'] ?? '');
    $no = trim($_POST['no'] ?? '');
    $addressaddition = trim($_POST['addressaddition'] ?? '');
    $zip = trim($_POST['zip'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $payment_info = trim($_POST['payment_info'] ?? '');
    $password1 = $_POST['password1'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if ($password1 !== $password2) {
        die("Passwords do not match.");
    }

    // Passwort hashen
    $passwordHash = password_hash($password1, PASSWORD_DEFAULT);

    // Adresse zusammenbauen
    $address = $street . ' ' . $no;
    if (!empty($addressaddition)) {
        $address .= ', ' . $addressaddition;
    }

    // Nutzer speichern
    $stmt = $conn->prepare("INSERT INTO users (role, salutation, first_name, last_name, address, postal_code, city, country, email, username, password_hash, payment_info)
                            VALUES ('customer', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $salutation, $firstname, $lastname, $address, $zip, $city, $country, $email, $username, $passwordHash, $payment_info);
    $stmt->execute();

    // Direkt einloggen
    $_SESSION['user'] = [
        'id' => $stmt->insert_id,
        'username' => $username,
        'role' => 'customer'
    ];

    header("Location: ../pages/user-account.php");
    exit;
}
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
    <?php include '../includes/navbar.php'; ?> <!-- navbar -->

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
            <section class="col-12 col-md-6 ms-md-5">
                <h1>CREATE CUSTOMER ACCOUNT</h1>
                <div id="errorMsg" class="alert alert-danger" style="display:none;"></div>
                <form id="signupForm" method="post">
                    <div class="form-row pt-3">
                        <div class="col-12 mb-3 radio-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="Ms" type="radio" name="salutation" value="Ms" required>
                                <label for="Ms" class="form-check-label">Ms</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="Mr" type="radio" name="salutation" value="Mr" required>
                                <label for="Mr" class="form-check-label">Mr</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="Other" type="radio" name="salutation" value="Other" required>
                                <label for="Other" class="form-check-label">Other</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6 mt-3">
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="" required>
                                <label for="firstname">First Name</label>
                            </div>
                            <div class="form-group col-md-6 mt-3">
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
                                <label for="payment_info">IBAN No. for Direct Debit</label>
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
                            <div class="PP col-8">
                                <input type="checkbox" class="form-check-input" id="policy" required>
                                <label class="form-check-label" for="policy">
                                    I accept the <a href="#">privacy policy</a>
                                </label>
                            </div>
                            <div class="PP col-4">
                                Already have an account?<a href="login.php">Login</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="PP col-12">
                                <button type="submit" name="submit" class="btn btn-primary btn-block">Create Account</button>
                            </div>
                        </div>
                    </div>
                </form>

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
            </section>
        </div>
    </main>

    <?php include '../includes/footer.php'; ?> <!-- Footer -->
</body>

</html>