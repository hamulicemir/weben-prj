<?php
// fehler im browser anzeigen (nur für entwicklung)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// startet die session (für nutzer und warenkorb)
session_start();
header('Content-Type: application/json'); // antwort ist json

// wichtige dateien einbinden
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../services/OrderService.php';
require_once __DIR__ . '/../services/VoucherService.php';
require_once __DIR__ . '/../repositories/VoucherRepository.php';

// json-eingabedaten lesen (z.b. "action", "createOrder", ...)
$data = json_decode(file_get_contents("php://input"), true);

// prüfen ob eine aktion übergeben wurde
if (!isset($data['action'])) {
    echo json_encode(['status' => 'error', 'message' => 'Keine Aktion übergeben']);
    exit;
}

// services instanzieren (backend-logik)
$service = new OrderService($conn);
$voucherService = new VoucherService(new VoucherRepository($conn));
$response = [];

// je nach aktion verschiedene funktionen aufrufen
switch ($data['action']) {
    case 'viewOrderByID':
        $response = $service->getOrderById($data['id'] ?? null);
        break;

    case 'viewAllOrders':
        $sort = ($data['sort'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';
        $response = $service->getOrdersByUserId(null, $sort);
        break;

    case 'viewOrdersByUserID':
        $response = $service->getOrdersByUserId($data['user_id'] ?? null);
        break;

    case 'deleteOrder':
        $response = $service->deleteOrder($data['id'] ?? null);
        break;

        // neue bestellung erstellen
    case 'createOrder':
        $voucher = $_SESSION['voucher'] ?? null;

        // wenn gutschein in session gespeichert, anhängen
        if ($voucher && isset($voucher['code'], $voucher['amount'])) {
            $data['voucher'] = $voucher;
        }

        // bestellung erstellen
        $response = $service->createOrder($data);

        // wenn erfolgreich, gutschein entfernen (damit dieser gutschein nicht mehr versehentlich bei der nächsten bestellung erneut verwendet wird)
        if ($response['status'] === 'success' && isset($voucher['code'])) {
            unset($_SESSION['voucher']);
        }
        break;

        // bestellpositionen (produkte) einer bestellung anzeigen
    case 'getOrderItems':
        $orderId = intval($data['order_id'] ?? 0);
        if ($orderId > 0) {
            require_once __DIR__ . '/../repositories/OrderItemRepository.php';
            $itemRepo = new OrderItemRepository($conn);
            $items = $itemRepo->findByOrderId($orderId);
            echo json_encode(['status' => 'success', 'items' => $items]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid order ID']);
        }
        exit; // antwort wurde schon ausgegeben, kein echo mehr danach


        // wenn keine gültige aktion übergeben wurde
    default:
        $response = ['status' => 'error', 'message' => 'Unbekannte Aktion'];
        break;
}

// antwort zurückgeben (z. b. {"status": "success", ...})
echo json_encode($response, JSON_PRETTY_PRINT);
