<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/OrderService.php';
require_once __DIR__ . '/VoucherService.php';
require_once __DIR__ . '/VoucherRepository.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['action'])) {
    echo json_encode(['status' => 'error', 'message' => 'Keine Aktion übergeben']);
    exit;
}

$service = new OrderService($conn);
$voucherService = new VoucherService(new VoucherRepository($conn));
$response = [];

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

    case 'createOrder':
        $voucher = $_SESSION['voucher'] ?? null;

        if ($voucher && isset($voucher['code'], $voucher['amount'])) {
            $data['voucher'] = $voucher;
        }

        $response = $service->createOrder($data);

        if ($response['status'] === 'success' && isset($voucher['code'])) {
            unset($_SESSION['voucher']);
        }
        break;

    default:
        $response = ['status' => 'error', 'message' => 'Unbekannte Aktion'];
        break;
}

echo json_encode($response, JSON_PRETTY_PRINT);
