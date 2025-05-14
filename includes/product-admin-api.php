<?php
require_once("../includes/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    // Datei-Upload verarbeiten
    $uploadDir = "../assets/img/products/";
    $imagePath = null;

    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $imageName;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = "assets/img/products/" . $imageName;
        }
    }

    switch ($action) {
        case 'create':
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, rating, image, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->bind_param("ssdss", $_POST['name'], $_POST['description'], $_POST['price'], $_POST['rating'], $imagePath);
            $stmt->execute();
            echo json_encode(["status" => "ok"]);
            break;

        case 'update':
            $id = $_POST['id'];

            // Falls kein neues Bild hochgeladen wurde → altes Bild beibehalten
            if (!$imagePath) {
                $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $imagePath = $row['image'];
            }

            $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, rating=?, image=?, updated_at=NOW() WHERE id=?");
            $stmt->bind_param("ssdssi", $_POST['name'], $_POST['description'], $_POST['price'], $_POST['rating'], $imagePath, $id);
            $stmt->execute();
            echo json_encode(["status" => "ok"]);
            break;

        case 'delete':
            $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            echo json_encode(["status" => "ok"]);
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Unknown action"]);
    }
    exit;
}
?>