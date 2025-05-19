<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
  echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $paymentLabels = [
    'credit_card' => 'Credit Card',
    'paypal' => 'PayPal',
    'voucher' => 'Voucher',
    'bank debit' => 'Bank Debit'
  ];

  $shippingLabels = [
    'DHL' => 'DHL',
    'Post' => 'Post',
    'UPS' => 'UPS'
  ];

  $payment = $_SESSION['order']['payment'] ?? '-';
  $shipping = $_SESSION['order']['shipping'] ?? '-';

  echo json_encode([
    'status' => 'success',
    'payment' => $payment,
    'shipping' => $shipping,
    'paymentLabel' => $paymentLabels[$payment] ?? ucfirst($payment),
    'shippingLabel' => $shippingLabels[$shipping] ?? ucfirst($shipping)
  ]);
}
?>