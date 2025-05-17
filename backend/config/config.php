<?php
// Startet eine Session, falls noch keine existiert (PHP)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verbindungsdaten zur MySQL-Datenbank definieren (PHP + MySQL)
$servername = "34.155.121.89";
$username = "weben-prj";
$password = "weben-prj";
$dbname = "weben-prj";

// Verbindet sich mit der MySQL-Datenbank (PHP + MySQL)
$conn = new mysqli($servername, $username, $password, $dbname);

// Prüft, ob die Verbindung zur Datenbank fehlgeschlagen ist (PHP)
if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Auto-Login mit Cookie, falls Benutzer noch nicht eingeloggt ist (PHP + Session + Cookie)
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_me'])) {
    $userId = $_COOKIE['remember_me'];
    $userbyId = 

    // Bereitet SQL-Statement vor, um User anhand der ID zu laden (PHP + Prepared Statement)
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);  // Übergibt ID als Integer-Parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Falls Benutzer gefunden, speichert User-Daten in Session (PHP + Session)
    if ($user = $result->fetch_assoc()) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            
            // Hinweis: Datenbankfelder und Formular müssen angepasst werden
            //muss an die datenbank angepasst werden, die wir im endeffekt verwenden werden + im signup formular auch benutzernamen feld einbauen
            'role' => $user['rolle'], // Benutzerrolle speichern
            'username' => $user['vorname'] // Vorname als Username verwenden
        ];
    }
}
?>