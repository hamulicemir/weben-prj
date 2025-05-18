<?php 
require_once("../../backend/config/config.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - My Account</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<?php include '../components/navbar.php'; ?> <!-- navbar -->

<main class="container py-5">
    <h2 class="mb-4">My Account</h2>

    <!-- User info -->
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5 class="card-title fs-3">Profile Information</h5>
            <div class="table-responsive">
            <table class="table table-borderless fs-5">
                <tr><th>First name:</th><td><span id="firstName"></span></td></tr>
                <tr><th>Last name:</th><td><span id="lastName"></span></td></tr>
                <tr><th>Email:</th><td><span id="email"></span></td></tr>
                <tr><th>Username:</th><td><span id="username"></span></td></tr>
                <tr><th>Payment method:</th><td><span id="iban"></span></td></tr>
                <tr><th>Address:</th><td><span id="address"></span></td></tr>

            </table>
            <a href="edit-profile.php" class="btn btn-dark">Edit Profile</a>
            </div>
        </div>
    </div>
</main>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../assets/js/user-account.js" defer></script>

<?php include '../components/footer.php'; ?> <!-- Footer -->
</body>
</html>