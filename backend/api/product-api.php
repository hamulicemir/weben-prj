<?php

// Product Controller

session_start();  // session starten (z.b. für benutzerdaten)
header('Content-Type: application/json'); // antwort ist json

require_once __DIR__ . '/../config/config.php'; // datenbankverbindung
require_once __DIR__ . '/../services/ProductService.php'; // service für produkte

$action = $_GET['action'] ?? ''; // action aus der url holen (z.b. ?action=getAll)
$productService = new ProductService($conn); // service initialisieren

// je nach action unterschiedlich reagieren
switch ($action) {
    // alle produkte holen (optional mit filter)
    case 'getAll':
        $search = $_GET['search'] ?? null; // suchbegriff
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null; // kategorie-id
        $gender = $_GET['gender'] ?? null; // geschlecht
        $products = $productService->getAll($search, $categoryId, $gender); // produkte holen
        echo json_encode($products); // als json zurückgeben
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
