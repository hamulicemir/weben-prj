<?php
require_once("../config/config.php"); // Stellt Verbindung zur Datenbank her

// Gibt an, dass die Antwort im JSON-Format kommt
header('Content-Type: application/json');

// SQL-Abfrage: Alle Kategorien mit ID und Name, sortiert nach ID
$sql = "SELECT id, name FROM categories ORDER BY id ASC";

// Führt die Abfrage aus
$result = $conn->query($sql);

$categories = []; // Array für die Kategorien
$categories[] = ['id' => 0, 'name' => 'All Categories'];

// Wenn Kategorien vorhanden sind, durchläuft jede Zeile
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
    }
}

// Antwort als JSON: enthält die Default-ID und alle Kategorien
echo json_encode([ "categories" => $categories ]);
?>
