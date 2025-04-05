<?php
// gibt alle Produkte als JSON, bereit für AJAX oder fetch() im Frontend
require_once("config.php");
header('Content-Type: application/json');

// Sicherheitscheck: Verbindung vorhanden?
if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Datenbankverbindung fehlgeschlagen']);
    exit;
}

// Alle Produkte holen
$sql = "SELECT * FROM products ORDER BY created_at DESC";
$result = $conn->query($sql);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

// JSON zurückgeben
echo json_encode($products);
?>
