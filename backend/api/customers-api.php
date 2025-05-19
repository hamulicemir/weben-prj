<?php
// startet die session
session_start();
// gibt an, dass die antwort json ist
header('Content-Type: application/json');

// lädt datenbank-konfiguration und service-klasse
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../services/CustomerService.php';

// liest die json-daten vom frontend ein und dekodiert sie
$data = json_decode(file_get_contents("php://input"), true);

// liest die gewünschte aktion aus
$action = $data['action'] ?? '';

// erstellt eine neue service-instanz
$service = new CustomerService($conn);

// versucht, basierend auf der aktion etwas auszuführen
try {
    switch ($action) {

        // gibt alle kunden zurück
        case 'getAll':
            $customers = $service->getAllCustomers();
            echo json_encode(['status' => 'success', 'data' => $customers]);
            break;

        // deaktiviert einen kunden (z. b. bei kündigung) 
        case 'deactivate':
            $id = intval($data['id'] ?? 0);
            if ($id > 0) {
                $success = $service->deactivateCustomer($id);
                echo json_encode(['status' => $success ? 'success' : 'error']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid customer ID.']);
            }
            break;

        // reaktiviert einen kunden    
        case 'reactivate':
            $id = intval($data['id'] ?? 0);
            if ($id > 0) {
                $success = $service->reactivateCustomer($id);
                echo json_encode(['status' => $success ? 'success' : 'error']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid customer ID.']);
            }
            break;

        // gibt alle bestellungen eines kunden zurück
        case 'getOrders':
            $id = intval($data['id'] ?? 0);
            if ($id > 0) {
                $orders = $service->getOrdersByCustomer($id);
                echo json_encode(['status' => 'success', 'orders' => $orders]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid customer ID.']);
            }
            break;
        // entfernt ein produkt aus einer bestimmten bestellung
        case 'removeProduct':
            $orderId = intval($data['order_id'] ?? 0);
            $productId = intval($data['product_id'] ?? 0);

            if ($orderId > 0 && $productId > 0) {
                $success = $service->removeProductFromOrder($orderId, $productId);
                echo json_encode(['status' => $success ? 'success' : 'error']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid order or product ID.']);
            }
            break;

            // wenn keine bekannte aktion angegeben ist
            default:
            echo json_encode(['status' => 'error', 'message' => 'Unknown action.']);
    }
    // falls irgendwo ein fehler passiert (z. b. datenbankproblem)
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
