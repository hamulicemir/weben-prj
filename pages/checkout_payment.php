<?php 
session_start(); 

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header("Location: ../pages/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICONIQ - Checkout</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src=""></script>
    <link rel="stylesheet" href="../assets/css/checkout.css">
</head>
<body>
<?php include '../includes/navbar.php'; ?> 


<div class="container mt-5">
  <div class="d-flex justify-content-center" id="checkout-steps">
    <div class="step text-center flex-fill" data-step="1">
      <div class="circle border mx-auto">1</div>
      <div class="label mt-2">YOUR DATA</div>
    </div>
    <div class="step text-center flex-fill" data-step="2">
      <div class="circle border mx-auto active-step">2</div>
      <div class="label mt-2">PAYMENT & DELIVERY</div>
    </div>
    <div class="step text-center flex-fill" data-step="3">
      <div class="circle border mx-auto">3</div>
      <div class="label mt-2">SUMMARY</div>
    </div>
  </div>
</div>
<hr class="my-4">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<?php include '../includes/footer.php'; ?> <!-- Footer -->
</body>
</html>