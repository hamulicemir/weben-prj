<?php

// stellt datenbankverbindung und services bereit
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../services/ProductService.php';

// zeige alle fehler (nur für entwicklung)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// zeige alle fehler (nur für entwicklung)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    // produkt-service vorbereiten (damit wir funktionen aufrufen können)
    $service = new ProductService($conn);

    // vorbereiten des bild-pfads (damit das bild im richtigen ordner landet)
    $subfolder = "";
    if (isset($_POST['gender'])) {
        if ($_POST['gender'] === 'men') {
            $subfolder = "Men/";
        } elseif ($_POST['gender'] === 'women') {
            $subfolder = "Women/";
        }
    }

    // der absolute pfad, wo das bild gespeichert wird (xampp)
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/weben-prj/weben-prj/frontend/assets/img/products/" . $subfolder;
    // standardbild falls kein upload passiert
    $imagePath = "/weben-prj/frontend/assets/img/products/no-image-available.jpg";

    // falls bild hochgeladen wurde, speichern wir es
    if (!empty($_FILES['image']['name'])) {
        $imageName = basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $imageName;

        // falls ordner noch nicht existiert, erstelle ihn
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // speichere bild im richtigen ordner
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = "/weben-prj/frontend/assets/img/products/" . $subfolder . $imageName;
        }
    }

    try {
        // je nach aktion wird das passende gemacht
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
        // fehlerausgabe wenn etwas schiefgeht
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
