<?php
session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
  header("Location: ../pages/login.php");
  exit();
}

unset($_SESSION['cart']);
unset($_SESSION['order']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ICONIQ - Order Complete</title>
  <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/checkout.css" />
</head>
<body class="d-flex flex-column min-vh-100">
<?php include '../components/navbar.php'; ?>

<main class="flex-grow-1 d-flex justify-content-center align-items-center">
  <div class="text-center">
    <h1 class="fw-bold mb-4">Thank you for your order!</h1>
    <p class="lead">We have received your order and will process it shortly.</p>
    <a href="index.php" class="btn btn-dark px-4">Return to Home</a>
  </div>
</main>

<?php include '../components/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
