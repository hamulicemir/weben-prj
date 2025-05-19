<?php
require_once '../config/config.php';
require_once '../../vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$orderId = $_GET['order_id'] ?? null;
$userId = $_SESSION['user']['id'] ?? null;
$isAdmin = $_SESSION['user']['role'] === 'admin';

if (!$orderId) {
    die("Invalid order ID");
}

// Zugriff prüfen
if (!$isAdmin) {
    $checkStmt = $conn->prepare("SELECT user_id FROM orders WHERE id = ?");
    $checkStmt->bind_param("i", $orderId);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $orderUser = $checkResult->fetch_assoc();

    if (!$orderUser || $orderUser['user_id'] != $userId) {
        die("Unauthorized");
    }
}

// Bestellung und User laden
$stmt = $conn->prepare("SELECT o.*, u.first_name, u.last_name, u.address, u.postal_code, u.city, u.country, u.email FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

// Artikel laden
$itemStmt = $conn->prepare("SELECT oi.quantity, oi.price, p.name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
$itemStmt->bind_param("i", $orderId);
$itemStmt->execute();
$itemResult = $itemStmt->get_result();
$items = $itemResult->fetch_all(MYSQLI_ASSOC);

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetTitle("Invoice #{$order['id']}");

$html = '<h2 style="font-family: sans-serif;">ICONIQ Invoice</h2>';
$html .= '<p><strong>Invoice No.:</strong> #' . $order['id'] . '<br>';
$html .= '<strong>Date:</strong> ' . date("Y-m-d", strtotime($order['created_at'])) . '</p>';

$html .= '<p><strong>Customer:</strong><br>';
$html .= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) . '<br>';
$html .= htmlspecialchars($order['address']) . '<br>';
$html .= htmlspecialchars($order['postal_code'] . ' ' . $order['city']) . '<br>';
$html .= htmlspecialchars($order['country']) . '</p>';

$html .= '<table border="1" cellspacing="0" cellpadding="6" width="100%">
<tr style="background-color:#f2f2f2;">
    <th>Product</th>
    <th>Quantity</th>
    <th>Unit Price</th>
    <th>Total</th>
</tr>';

$total = 0;
foreach ($items as $item) {
    $lineTotal = $item['quantity'] * $item['price'];
    $total += $lineTotal;
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($item['name']) . '</td>';
    $html .= '<td align="center">' . $item['quantity'] . '</td>';
    $html .= '<td align="right">' . number_format($item['price'], 2, ',', '.') . '</td>';
    $html .= '<td align="right">' . number_format($lineTotal, 2, ',', '.') . '</td>';
    $html .= '</tr>';
}

    $html .= '</table><br>';

    if (!empty($order['voucher_code'])) {
    $html .= '<p><strong>Voucher Code:</strong> ' . htmlspecialchars($order['voucher_code']) . '</p>';
}

    $shipping = 5.00;
    $voucher = (float)($order['voucher_amount'] ?? 0);

    // Bruttosumme inkl. Steuer
    $grossTotal = $total + $shipping - $voucher;
    $grossTotal = max(0, $grossTotal);

    // Netto berechnen
    $netTotal = $grossTotal / 1.2;
    $tax = $grossTotal - $netTotal;

    $html .= '<p>';
    $html .= '<strong>Items Total:</strong> € ' . number_format($total, 2, ',', '.') . '<br>';
    $html .= '<strong>Shipping:</strong> € ' . number_format($shipping, 2, ',', '.') . '<br>';
    $html .= '<strong>Voucher:</strong> -€ ' . number_format($voucher, 2, ',', '.')  . '<br>'. '<br>';
    $html .= '<strong>Subtotal (net):</strong> € ' . number_format($netTotal, 2, ',', '.') . '<br>';
    $html .= '<strong>Tax (20%):</strong> € ' . number_format($tax, 2, ',', '.') . '<br>';
    $html .= '<strong>Total (gross):</strong> € ' . number_format($grossTotal, 2, ',', '.') . '</p>';


    $mpdf->WriteHTML($html);
    $mpdf->Output("invoice_{$order['id']}.pdf", \Mpdf\Output\Destination::INLINE);
