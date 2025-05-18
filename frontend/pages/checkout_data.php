<?php
session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
  header("Location: ../pages/login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ICONIQ - Checkout</title>
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/checkout.css">
</head>

<body>
  <?php include '../components/navbar.php'; ?>

  <div class="container mt-5">
    <div class="d-flex justify-content-center" id="checkout-steps">
      <div class="step text-center flex-fill" data-step="1">
        <div class="circle border mx-auto active-step">1</div>
        <div class="label mt-2">YOUR DATA</div>
      </div>
      <div class="step text-center flex-fill" data-step="2">
        <div class="circle border mx-auto">2</div>
        <div class="label mt-2">PAYMENT & DELIVERY</div>
      </div>
      <div class="step text-center flex-fill" data-step="3">
        <div class="circle border mx-auto">3</div>
        <div class="label mt-2">SUMMARY</div>
      </div>
    </div>
  </div>
  <hr class="my-4">

  <div class="container mb-5" style="max-width: 700px;">
    <h2 class="fw-bold mb-5">YOUR DATA</h2>

    <div class="card shadow rounded-4 p-4">

      <div id="userDataView" class="d-none fs-4">
        <p><strong>Salutation:</strong> <span id="view-salutation"></span></p>
        <p><strong>Name:</strong> <span id="view-firstName"></span></p>
        <p><strong>Lastname:</strong> <span id="view-lastName"></span></p>
        <p><strong>E-Mail:</strong> <span id="view-email"></span></p>
        <p><strong>Username:</strong> <span id="view-username"></span></p>
        <p><strong>Street:</strong> <span id="view-street"></span></p>
        <p><strong>Postal Code:</strong> <span id="view-zip"></span></p>
        <p><strong>City:</strong> <span id="view-city"></span></p>


        <div class="d-flex justify-content-between mt-3">
          <a href="user-account.php" class="btn btn-outline-dark fs-4">Edit</a>
          <a href="checkout_payment.php" class="btn btn-dark fs-4">Next</a>
        </div>
      </div>
    </div>
  </div>

  <?php include '../components/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/user-edit.js"></script>
</body>

</html>