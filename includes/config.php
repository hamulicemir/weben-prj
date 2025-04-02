<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "weben-prj";
$password = "weben-prj";
$dbname = "weben-prj";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// auto-login via cookie
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_me'])) {
    $userId = $_COOKIE['remember_me'];
    $userbyId = 
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        $_SESSION['user'] = [
            'id' => $user['id'],

            //muss an die datenbank angepasst werden, die wir im endeffekt verwenden werden + im signup formular auch benutzernamen feld einbauen
            'role' => $user['rolle'],
            'username' => $user['vorname']
        ];
    }
}
?>