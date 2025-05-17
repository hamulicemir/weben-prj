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
  <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src=""></script>
  <link rel="stylesheet" href="../assets/css/checkout.css">
</head>

<body>
  <?php include '../components/navbar.php'; ?>

<main>
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

  <div class="container mb-5" style="max-width: 700px;">
    <h2 class="fw-bold mb-5">PAYMENT & DELIVERY</h2>

    <form action="checkout_summary.php" method="POST">
      <div class="mb-4">
        <h5 class="fw-bold mb-3">HOW WOULD YOU LIKE TO PAY?</h5>

        <div class="payment-option border rounded p-3 mb-3 d-flex">
          <div class="form-check me-3 d-flex align-items-center">
            <input class="form-check-input" type="radio" name="payment" id="creditCard" value="credit_card" checked>
            <label class="form-check-label fw-semibold d-block" for="creditCard">Credit Card</label>
          </div>
        </div>

        <div class="payment-option border rounded p-3 mb-3 d-flex">
          <div class="form-check me-3 d-flex align-items-center">
            <input class="form-check-input" type="radio" name="payment" id="paypal" value="paypal">
            <label class="form-check-label fw-semibold d-block" for="paypal">PayPal</label>
          </div>
        </div>

        <div class="payment-option border rounded p-3 mb-3 d-flex">
          <div class="form-check me-3 d-flex align-items-center">
            <input class="form-check-input" type="radio" name="payment" id="voucher" value="voucher">
            <label class="form-check-label fw-semibold d-block" for="voucher">Voucher</label>
          </div>
        </div>

        <div class="payment-option border rounded p-3 mb-3 d-flex">
          <div class="form-check me-3 d-flex align-items-center">
            <input class="form-check-input" type="radio" name="payment" id="bankDebit" value="bank debit">
            <label class="form-check-label fw-semibold d-block" for="bankDebit">Bank Debit</label>
          </div>
        </div>

        <div class="mb-4">
          <h5 class="fw-bold mb-3">SHIPPING METHOD</h5>

          <div class="shipping-option border rounded p-3 mb-3 d-flex">
            <div class="form-check me-3 d-flex align-items-center">
              <input class="form-check-input" type="radio" name="shipping" id="DHL" value="DHL" checked>
              <label class="form-check-label fw-semibold d-block" for="DHL">DHL</label>
            </div>
          </div>

          <div class="shipping-option border rounded p-3 mb-3 d-flex">
            <div class="form-check me-3 d-flex align-items-center">
              <input class="form-check-input" type="radio" name="shipping" id="Post" value="Post">
              <label class="form-check-label fw-semibold d-block" for="Post">Post</label>
            </div>
          </div>

          <div class="shipping-option border rounded p-3 mb-3 d-flex">
            <div class="form-check me-3 d-flex align-items-center">
              <input class="form-check-input" type="radio" name="shipping" id="UPS" value="UPS">
              <label class="form-check-label fw-semibold d-block" for="UPS">UPS</label>
            </div>
          </div>


          <div class="d-flex justify-content-between">
            <a href="checkout_data.php" class="btn btn-outline-dark px-4">BACK</a>
            <button type="submit" class="btn btn-dark px-4">CONTINUE TO ORDER SUMMARY</button>
          </div>
    </form>
  </div>
  </main>


  <?php include '../components/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>