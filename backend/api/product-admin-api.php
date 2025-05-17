<?php
require_once("../config/config.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    $subfolder = ""; // fallback
    if (isset($_POST['gender'])) {
        if ($_POST['gender'] === 'men') {
            $subfolder = "Men/";
        } elseif ($_POST['gender'] === 'women') {
            $subfolder = "Women/";
        }
    }

    // Datei-Upload verarbeiten
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . "/weben-prj/weben-prj/frontend/assets/img/products/" . $subfolder;
    $imagePath = null;

    if (!$imagePath) {
        // Fallback auf ein Platzhalterbild
        $imagePath = "../../frontend/assets/img/products/no-image-available.jpg";
    }


    // Datei-Upload verarbeiten
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $imageName;

        // Stelle sicher, dass das Unterverzeichnis existiert!
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = "../../frontend/assets/img/products/" . $subfolder . $imageName;
        }
    }


    switch ($action) {
        case 'create':
            if (!$imagePath) {
                $imagePath = "../../frontendassets/img/products/no-image-available.jpg";
            }
            $categoryId = (int)$_POST['category_id'];
            $stock = (int)$_POST['stock']; 

            $stmt = $conn->prepare("INSERT INTO products (name, description, price, rating, gender, colour, image, stock, category_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->bind_param("sssdsssii", $_POST['name'], $_POST['description'], $_POST['price'], $_POST['rating'], $_POST['gender'], $_POST['colour'], $imagePath, $stock, $categoryId);


            if (!$stmt->execute()) {
                echo json_encode(["status" => "error", "error" => "Execute failed: " . $stmt->error]);
                exit;
            }
        
            echo json_encode(["status" => "ok"]);
            break;


            case 'update':
                $id = $_POST['id'];
                $categoryId = (int)$_POST['category_id'];
                $stock = (int)$_POST['stock']; 
            
                // Falls kein neues Bild hochgeladen wurde → altes Bild beibehalten
                if (!$imagePath || $imagePath === "../../frontend/assets/img/products/no-image-available.jpg") {
                    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $imagePath = $row['image'] ?? "../../frontend/assets/img/products/no-image-available.jpg";
                }
            
                $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, rating=?, gender=?, colour=?, image=?, stock=?, category_id=?, updated_at=NOW() WHERE id=?");
                $stmt->bind_param("sssdsssii", $_POST['name'], $_POST['description'], $_POST['price'], $_POST['rating'], $_POST['gender'], $_POST['colour'], $imagePath, $_POST['stock'], $categoryId, $id);
                if (!$stmt->execute()) {
                    echo json_encode(["status" => "error", "error" => "Execute failed: " . $stmt->error]);
                    exit;
                }
            
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
