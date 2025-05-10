<?php
session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
  header("Location: ../pages/login.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['payment']) || !isset($_POST['shipping'])) {
    header("Location: checkout_payment.php");
    exit();
  }

  $_SESSION['order'] = [
    'payment' => $_POST['payment'],
    'shipping' => $_POST['shipping']
  ];
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
</head>

<body>
  <?php include '../includes/navbar.php'; ?>

  <main>
    <div class="container mt-5">
      <div class="d-flex justify-content-center" id="checkout-steps">
        <div class="step text-center flex-fill" data-step="1">
          <div class="circle border mx-auto">1</div>
          <div class="label mt-2">YOUR DATA</div>
        </div>
        <div class="step text-center flex-fill" data-step="2">
          <div class="circle border mx-auto">2</div>
          <div class="label mt-2">PAYMENT & DELIVERY</div>
        </div>
        <div class="step text-center flex-fill" data-step="3">
          <div class="circle border mx-auto active-step">3</div>
          <div class="label mt-2">SUMMARY</div>
        </div>
      </div>
    </div>
    <hr class="my-4" />

    <div class="container mb-5" style="max-width: 700px;">
      <h2 class="fw-bold mb-4">ORDER SUMMARY</h2>

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

      <div class="card p-4 shadow-sm rounded-4 mb-4">
        <h5 class="fw-bold mb-3">Payment Method</h5>
        <p class="mb-1"><?= htmlspecialchars(ucfirst($order['payment'])) ?></p>

        <h5 class="fw-bold mt-4 mb-3">Shipping Method</h5>
        <p class="mb-0"><?= htmlspecialchars(strtoupper($order['shipping'])) ?></p>
      </div>

      <div class="d-flex justify-content-between">
        <a href="checkout_payment.php" class="btn btn-outline-dark px-4">Back</a>
        <button id="placeOrderBtn" class="btn btn-success px-4">Place Order</button>
      </div>
    </div>
  </main>

  <?php include '../includes/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('placeOrderBtn').addEventListener('click', async () => {
      const response = await fetch('/weben-prj/includes/order-api.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          action: 'createOrder',
          payment: '<?= $_SESSION['order']['payment'] ?>',
          shipping: '<?= $_SESSION['order']['shipping'] ?>',
          cart: <?= json_encode($_SESSION['cart'] ?? []) ?>
        })
      });

      const result = await response.json();
      if (result.status === 'success') {
        window.location.href = 'order_success.php';
      } else {
        alert('Bestellung konnte nicht abgeschlossen werden: ' + result.message);
      }
    });
  </script>
  <script src="../assets/js/user-edit.js"></script>

</body>

</html>