<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

$json = file_get_contents("php://input");
$data = json_decode($json, true);

if (!$data) {
    echo json_encode([
        'status' => 'debug',
        'message' => 'JSON konnte nicht dekodiert werden.',
        'raw_input' => $json
    ], JSON_PRETTY_PRINT);
    exit;
}

if (!isset($data['action'])) {
    echo json_encode([
        'status' => 'debug',
        'message' => 'action fehlt im JSON!',
        'decoded' => $data
    ], JSON_PRETTY_PRINT);
    exit;
}

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../services/UserService.php';

$action = $data['action'] ?? null;
$service = new UserService($conn);

switch ($action) {
    case 'create':
        $response = $service->createUser($data['user']);
        break;
    case 'list':
        $response = $service->listUsers();
        break;
    case 'update':
        $response = $service->updateUser($data['id'], $data['user']);
        break;
    case 'delete':
        $response = $service->deleteUser($data['id']);
        break;
    case 'thisUser':
        $response = $service->getCurrentUser();
        break;
    default:
        http_response_code(400);
        $response = ['status' => 'error', 'message' => 'Unbekannte oder fehlende Aktion'];
        break;
}

echo json_encode($response, JSON_PRETTY_PRINT);
exit;
