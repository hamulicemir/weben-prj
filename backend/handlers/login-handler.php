<?php
session_start();
require_once("../config/config.php");
include "../helpers/functions.php";
// Debugging aktivieren
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$response = ["success" => false, "errors" => []];

// Funktion: Benutzer anhand der ID abrufen

// Überprüfen, ob der Benutzer bereits eingeloggt ist
if (isset($_SESSION['user'])) {
    echo json_encode(["success" => true, "message" => "Bereits eingeloggt."]);
    exit();
}

// Überprüfen, ob der remember_me-Cookie gesetzt ist
if (isset($_COOKIE['remember_me'])) {
    $userId = $_COOKIE['remember_me'];

    if (!$conn) {
        echo json_encode(["success" => false, "errors" => ["general" => "Datenbankverbindung fehlgeschlagen."]]);
        exit();
    }

    $user = getUserById($conn, $userId);

    if ($user) {
        setUserSession($user);
        echo json_encode(["success" => true, "message" => "Automatisch eingeloggt."]);
        exit();
    } else {
        // Ungültiger Cookie, löschen
        setcookie("remember_me", "", time() - 3600, "/");
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $loginInput = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember_me']);

    if (!$conn) {
        $response["errors"]["general"] = "Datenbankverbindung fehlgeschlagen.";
        echo json_encode($response);
        exit();
    }

    // Nutzer anhand E-Mail oder Username suchen
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $loginInput, $loginInput);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        $response["errors"]["email"] = "Kein Benutzer mit dieser E-Mail oder diesem Username gefunden.";
        echo json_encode($response);
        exit();
    }

    if (!password_verify($password, $user['password_hash'])) {
        $response["errors"]["password"] = "Passwort stimmt nicht überein.";
        echo json_encode($response);
        exit();
    }

    setUserSession($user);

    if ($remember) {
        setcookie("remember_me", $user['id'], time() + (86400 * 30), "/", "", true, true);
    }

    $response["success"] = true;
    echo json_encode($response);
    exit();
} else {
    $response["errors"]["general"] = "Ungültige Anfrage.";
    echo json_encode($response);
    exit();
}