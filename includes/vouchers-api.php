<?php

// Controller

session_start();
header('Content-Type: application/json');

require_once(__DIR__ . '/config.php');
require_once __DIR__ . '/VoucherService.php';

$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? '';

$voucherService = new VoucherService($conn);

switch ($action) {
    case 'add':
        $code = strtoupper(trim($data['code'] ?? ''));
        $amount = floatval($data['amount'] ?? 0);
        $expiration = $data['expiration_date'] ?? '';

        if ($code && $amount > 0 && $expiration) {
            $success = $voucherService->createVoucher($code, $amount, $expiration);
            $response = ['status' => $success ? 'success' : 'error'];
        } else {
            $response = ['status' => 'error', 'message' => 'Ungültige Eingabedaten'];
        }
        break;

    case 'getAll':
        $vouchers = $voucherService->getAllVouchers();
        $response = ['status' => 'success', 'data' => $vouchers];
        break;

    case 'getByCode':
        $code = strtoupper(trim($data['code'] ?? ''));
        if ($code) {
            $voucher = $voucherService->getVoucherByCode($code);
            $response = $voucher ? ['status' => 'success', 'data' => $voucher] : ['status' => 'error', 'message' => 'Nicht gefunden'];
        } else {
            $response = ['status' => 'error', 'message' => 'Kein Code angegeben'];
        }
        break;

    case 'edit':
        $code = strtoupper(trim($data['code'] ?? ''));
        $original = strtoupper(trim($data['original_code'] ?? ''));
        $amount = floatval($data['amount'] ?? 0);
        $expiration = $data['expiration_date'] ?? '';
    
        if ($code && $original && $amount > 0 && $expiration) {
            $success = $voucherService->updateVoucher($original, $code, $amount, $expiration);
            $response = ['status' => $success ? 'success' : 'error'];
        } else {
            $response = ['status' => 'error', 'message' => 'Ungültige Eingabedaten'];
        }
        break;
    
    case 'delete':
        $code = strtoupper(trim($data['code'] ?? ''));
        if ($code) {
            $success = $voucherService->deleteVoucher($code);
            $response = ['status' => $success ? 'success' : 'error'];
        } else {
            $response = ['status' => 'error', 'message' => 'Kein Code angegeben'];
        }
        break;
    
    case 'generate':
        $code = $voucherService->generateRandomCode();
        $response = ['status' => 'success', 'code' => $code];
        break;

    default:
        $response = ['status' => 'error', 'message' => 'Unbekannte Aktion'];
}

echo json_encode($response);