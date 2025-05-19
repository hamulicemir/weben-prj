<?php
session_start();
$_SESSION['order'] = [
    'payment' => $_POST['payment'] ?? '-',
    'shipping' => $_POST['shipping'] ?? '-'
];
header("Location: ../../frontend/pages/checkout_summary.php");
exit();
