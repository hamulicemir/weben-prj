<?php
session_start();
header('Content-Type: application/json');

// Initialisiere Warenkorb
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? '';

require_once __DIR__ . '/config.php';

switch ($action) {
    case 'add':
        $id = $data['productId'];
        $qty = $data['quantity'] ?? 1;
        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + $qty;
        echo json_encode(['status' => 'ok', 'cart' => $_SESSION['cart']]);
        break;

    case 'remove':
        unset($_SESSION['cart'][$data['productId']]);
        echo json_encode(['status' => 'ok', 'cart' => $_SESSION['cart']]);
        break;

    case 'update':
        $_SESSION['cart'][$data['productId']] = $data['quantity'];
        echo json_encode(['status' => 'ok', 'cart' => $_SESSION['cart']]);
        break;

    case 'get':
        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            echo json_encode(['status' => 'ok', 'products' => []]);
            break;
        }

        $ids = array_keys($cart);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids)); // Alle IDs sind integer

        // SQL vorbereiten
        $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id IN ($placeholders)");
        if ($stmt === false) {
            echo json_encode(['status' => 'error', 'message' => 'Datenbankfehler beim Prepare.']);
            break;
        }

        // Dynamisch Parameter binden
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $row['quantity'] = $cart[$row['id']] ?? 1;
            $products[] = $row;
        }

        echo json_encode(['status' => 'ok', 'products' => $products]);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Unbekannte Aktion']);
        break;
}