<?php

//controller für den warenkorb (cart)

// startet die session und setzt den rückgabetyp auf json
session_start();
header('Content-Type: application/json');

// lädt datenbankverbindung und cart-service (geschäftslogik)
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../services/CartService.php';

// liest die eingehenden json-daten aus dem request-body
$data = json_decode(file_get_contents("php://input"), true);

// liest die aktion aus dem request (z. b. "add", "remove", ...)
$action = $data['action'] ?? '';

// erstellt ein neues cartservice-objekt mit datenbankverbindung
$cartService = new CartService($conn);

// entscheidet je nach aktion, welche methode aufgerufen wird
switch ($action) {
    case 'add':
        $response = $cartService->addProduct($data['productId'], $data['quantity'] ?? 1);
        break;
    case 'remove':
        $response = $cartService->removeProduct($data['productId']);
        break;
    case 'clear':
        $response = $cartService->clearCart();
        break;
    case 'update':
        $response = $cartService->updateProduct($data['productId'], $data['quantity']);
        break;
    case 'save':
        $response = $cartService->saveCart();
        break;
    case 'get':
        $response = $cartService->getCart();
        $response['voucher'] = $_SESSION['voucher'] ?? null;
        break;
    default:
        $response = ['status' => 'error', 'message' => 'Unbekannte Aktion'];
}

// antwort als json zurückgeben
echo json_encode($response);
