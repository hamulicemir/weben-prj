<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../services/CustomerService.php';

$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? '';

$service = new CustomerService($conn);

try {
    switch ($action) {
        case 'getAll':
            $customers = $service->getAllCustomers();
            echo json_encode(['status' => 'success', 'data' => $customers]);
            break;

        case 'deactivate':
            $id = intval($data['id'] ?? 0);
            if ($id > 0) {
                $success = $service->deactivateCustomer($id);
                echo json_encode(['status' => $success ? 'success' : 'error']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid customer ID.']);
            }
            break;

        case 'reactivate':
            $id = intval($data['id'] ?? 0);
            if ($id > 0) {
                $success = $service->reactivateCustomer($id);
                echo json_encode(['status' => $success ? 'success' : 'error']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid customer ID.']);
            }
            break;


        case 'getOrders':
            $id = intval($data['id'] ?? 0);
            if ($id > 0) {
                $orders = $service->getOrdersByCustomer($id);
                echo json_encode(['status' => 'success', 'orders' => $orders]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid customer ID.']);
            }
            break;

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

        default:
            echo json_encode(['status' => 'error', 'message' => 'Unknown action.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
}
