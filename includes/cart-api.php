<?php

//Controller

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/CartService.php';

$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? '';

$cartService = new CartService($conn);

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
        break;
    default:
        $response = ['status' => 'error', 'message' => 'Unbekannte Aktion'];
}

echo json_encode($response);