<?php
session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
  header("Location: ../pages/login.php");
  exit();
}
$order = $_SESSION['order'] ?? ['payment' => '-', 'shipping' => '-'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ICONIQ - Checkout</title>
  <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/checkout.css" />
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <?php include '../components/navbar.php'; ?>
  <main>
    <div class="container mt-5">
      <div class="d-flex justify-content-center" id="checkout-steps">
        <div class="step text-center flex-fill" data-step="1"><div class="circle border mx-auto">1</div><div class="label mt-2">YOUR DATA</div></div>
        <div class="step text-center flex-fill" data-step="2"><div class="circle border mx-auto">2</div><div class="label mt-2">PAYMENT & DELIVERY</div></div>
        <div class="step text-center flex-fill" data-step="3"><div class="circle border mx-auto active-step">3</div><div class="label mt-2">SUMMARY</div></div>
      </div>
    </div>
    <hr class="my-4" />

    <div class="container mb-5">
      <h2 class="fw-bold mb-4">ORDER SUMMARY</h2>
      <div class="row g-4">
        <div class="col-md-8">
          <div id="summary-products"></div>
        </div>
        <div class="col-md-4">
          <div class="card shadow rounded-4 p-4 mb-4">
            <h4 class="mb-4">YOUR DATA</h4>
            <div id="userDataView" class="d-none">
              <p><strong>Salutation:</strong> <span id="view-salutation"></span></p>
              <p><strong>Name:</strong> <span id="view-firstName"></span></p>
              <p><strong>Lastname:</strong> <span id="view-lastName"></span></p>
              <p><strong>E-Mail:</strong> <span id="view-email"></span></p>
              <p><strong>Username:</strong> <span id="view-username"></span></p>
              <p><strong>Street:</strong> <span id="view-street"></span></p>
              <p><strong>Postal Code:</strong> <span id="view-zip"></span></p>
              <p><strong>City:</strong> <span id="view-city"></span></p>
            </div>
          </div>

          <div class="card p-4 shadow-sm rounded-4 mb-4" id="summary-info">
            <h5 class="fw-bold mb-3">Payment Method</h5>
            <p id="payment-method" class="mb-1"></p>
            <h5 class="fw-bold mt-4 mb-3">Shipping Method</h5>
            <p id="shipping-method" class="mb-0"></p>
          </div>

          <div class="d-flex justify-content-between">
            <a href="checkout_payment.php" class="btn btn-outline-dark px-4">Back</a>
            <button id="placeOrderBtn" class="btn btn-success px-4">Place Order</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include '../components/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/checkout-summary.js"></script>
  <script src="../assets/js/user-edit.js"></script>
  <script src="../assets/js/summary-cart.js"></script>
</body>
</html>
