<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../services/ProductService.php';


error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    // Initialisiere Service
    $service = new ProductService($conn);

    // Bildpfad vorbereiten
    $subfolder = "";
    if (isset($_POST['gender'])) {
        if ($_POST['gender'] === 'men') {
            $subfolder = "Men/";
        } elseif ($_POST['gender'] === 'women') {
            $subfolder = "Women/";
        }
    }

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/weben-prj/weben-prj/frontend/assets/img/products/" . $subfolder;
    $imagePath = "/weben-prj/frontend/assets/img/products/no-image-available.jpg";

    // Bild-Upload (falls vorhanden)
    if (!empty($_FILES['image']['name'])) {
        $imageName = basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $imageName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = "/weben-prj/frontend/assets/img/products/" . $subfolder . $imageName;
        }
    }

    try {
        switch ($action) {
            case 'create':
                $success = $service->createProduct($_POST, $imagePath);
                echo json_encode(['status' => $success ? 'ok' : 'error']);
                break;

            case 'update':
                // Falls kein neues Bild: hole bestehendes Bild aus DB
                if ($imagePath === "/weben-prj/frontend/assets/img/products/no-image-available.jpg") {
                    $existing = $service->getById((int)$_POST['id']);
                    $imagePath = $existing['image'] ?? $imagePath;
                }

                $success = $service->updateProduct($_POST, $imagePath);
                echo json_encode(['status' => $success ? 'ok' : 'error']);
                break;

            case 'delete':
                $id = (int)($_POST['id'] ?? 0);
                $success = $service->deleteProduct($id);
                echo json_encode(['status' => $success ? 'ok' : 'error']);
                break;

            default:
                echo json_encode(['status' => 'error', 'message' => 'Unknown action']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
