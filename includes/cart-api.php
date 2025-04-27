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

    case 'clear':
        unset($_SESSION['cart']);
        unset($_SESSION['cart_info']);
        echo json_encode(['status' => 'ok']);
        break;

    case 'update':
        $_SESSION['cart'][$data['productId']] = $data['quantity'];
        echo json_encode(['status' => 'ok', 'cart' => $_SESSION['cart']]);
        break;

    case 'save':
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            unset($_SESSION['cart_info']); // <<< cart_info löschen, wenn nichts im Warenkorb
            echo json_encode(['status' => 'empty']);
            break;
        }
    
        $cart = $_SESSION['cart'];
        $ids = array_keys($cart);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids)); // IDs sind Integer
    
        $stmt = $conn->prepare("SELECT id, name, price, image FROM products WHERE id IN ($placeholders)");
        if ($stmt === false) {
            echo json_encode(['status' => 'error', 'message' => 'Datenbankfehler beim Prepare.']);
            break;
        }
    
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $cart_info = [];
        $cart_info['products'] = [];
        $subtotal = 0;
    
        while ($row = $result->fetch_assoc()) {
            $productId = (int)$row['id'];
            $quantity = (int)($cart[$productId] ?? 0);
    
            // Falls Produkt zwar in DB aber nicht im Warenkorb ist, überspringen
            if ($quantity <= 0) continue;
    
            $price = (float)$row['price'];
            $total_price = $price * $quantity;
    
            $cart_info['products'][] = [
                'id' => $productId,
                'name' => $row['name'],
                'price' => $price,
                'quantity' => $quantity,
                'total_price' => $total_price,
                'image' => $row['image'] ?? '../assets/img/products/no-image-available.jpg'
            ];
    
            $subtotal += $total_price;
        }
    
        // Wenn KEINE Produkte mehr existieren -> cart_info löschen
        if (empty($cart_info['products'])) {
            unset($_SESSION['cart_info']);
            echo json_encode(['status' => 'empty']);
            break;
        }
    
        $shipping_fee = 5.00;
    
        $cart_info['summary'] = [
            'subtotal' => $subtotal,
            'shipping' => $shipping_fee,
            'total' => $subtotal + $shipping_fee
        ];
    
        $_SESSION['cart_info'] = $cart_info;
    
        echo json_encode(['status' => 'ok']);
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