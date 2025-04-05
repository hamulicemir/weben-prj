<?php
require_once("config.php"); // Stellt Verbindung zur Datenbank her

// Gibt an, dass die Antwort im JSON-Format kommt
header('Content-Type: application/json');

// SQL-Abfrage: Alle Kategorien mit ID und Name, sortiert nach ID
$sql = "SELECT id, name FROM categories ORDER BY id ASC";

// Führt die Abfrage aus
$result = $conn->query($sql);

$categories = []; // Array für die Kategorien
$defaultCategoryId = null; // Platzhalter für die erste Kategorie-ID (Default)

// Wenn Kategorien vorhanden sind, durchläuft jede Zeile
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (!$defaultCategoryId) {
            $defaultCategoryId = $row['id']; // Speichert die erste ID als Standard-Kategorie
        }
        $categories[] = $row; // Fügt die Kategorie dem Array hinzu
    }
}

// Antwort als JSON: enthält die Default-ID und alle Kategorien
echo json_encode([
    "default" => $defaultCategoryId,
    "categories" => $categories
]);
?>
