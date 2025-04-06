<?php
require_once("config.php"); // Stellt die DB-Verbindung her
header('Content-Type: application/json'); // Gibt JSON als Antwortformat an

// Holt den Suchbegriff (falls vorhanden) und fügt Wildcards für LIKE hinzu
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : null;

// Holt die Kategorie-ID (falls angegeben) und wandelt sie in eine Ganzzahl um
$categoryId = isset($_GET['category']) ? intval($_GET['category']) : null;

// Basiskonstrukt der SQL-Abfrage mit 1=1 als Platzhalter (vereinfacht dynamisches Anhängen)
$query = "SELECT * FROM products WHERE 1=1";
$params = []; // Array für Parameterwerte
$types = ""; // Typen-String für bind_param (z. B. "ssi")

// Wenn eine Sucheingabe vorhanden ist, erweitere die Abfrage um LIKE-Filter
if ($search) {
    $query .= " AND (name LIKE ? OR description LIKE ?)";
    $params[] = $search; // Für name
    $params[] = $search; // Für description
    $types .= "ss"; // Zwei Strings
}

// Wenn eine Kategorie-ID vorhanden ist, erweitere die Abfrage
if ($categoryId) {
    $query .= " AND category_id = ?";
    $params[] = $categoryId;
    $types .= "i"; // Ein Integer
}

// Bereitet die Abfrage vor
$stmt = $conn->prepare($query);
// Bindet Parameter nur, wenn welche vorhanden sind
if ($types) {
    $stmt->bind_param($types, ...$params); // Übergibt Typen und Werte
}
$stmt->execute(); // Führt die Abfrage aus
$result = $stmt->get_result(); // Holt das Ergebnis
$products = $result->fetch_all(MYSQLI_ASSOC); // Holt alle Produkte als assoziatives Array

// Gibt die Produkte als JSON aus
echo json_encode($products);
?>
