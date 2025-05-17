<?php

// Product Controller

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/ProductService.php';

$action = $_GET['action'] ?? ''; // erwartet ?action=...
$productService = new ProductService($conn);

switch ($action) {
    case 'getAll':
        $search = $_GET['search'] ?? null;
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $products = $productService->getAll($search, $categoryId);
        echo json_encode($products);
        break;

    case 'getById':
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $product = $productService->getById($id);
        echo json_encode($product);
        break;

    default:
        echo json_encode(['error' => 'Invalid action. Use ?action=getAll or ?action=getById']);
        break;
}
