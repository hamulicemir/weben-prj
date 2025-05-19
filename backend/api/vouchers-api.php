<?php
session_start(); // session starten, um gutscheine im warenkorb zu merken
header('Content-Type: application/json'); // antwort kommt als json zurück

// datenbankverbindung und service einbinden
require_once(__DIR__ . '/../config/config.php');
require_once __DIR__ . '/../services/VoucherService.php';

// json-eingabe lesen
$data = json_decode(file_get_contents("php://input"), true);
$action = $data['action'] ?? '';

$voucherService = new VoucherService($conn); // service-instanz erzeugen
$response = ['status' => 'error', 'message' => 'Unbekannte Aktion']; // Default-Response

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
            $response = $voucher
                ? ['status' => 'success', 'data' => $voucher]
                : ['status' => 'error', 'message' => 'Nicht gefunden'];
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

    case 'applyVoucher':
        $code = $data['code'] ?? '';
        $voucher = $voucherService->validateVoucher($code);

        if ($voucher) { // gutschein in session speichern
            $_SESSION['voucher'] = $voucher->toArray();
            $response = [
                'status' => 'success',
                'voucher' => $_SESSION['voucher']
            ];
        } else { 
            $response = [
                'status' => 'error',
                'message' => 'Invalid, expired or used voucher.'
            ];
        }
        break;

    default: // fallback wenn keine gültige aktion übergeben wurde
       $response = [
                'status' => 'error',
                'message' => 'Fehler bei der Verarbeitung der Anfrage.'
            ];
        break;
}
// antwort als json senden
echo json_encode($response);
exit;