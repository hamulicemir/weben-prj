<?php
session_start();
require_once("config.php");

header('Content-Type: application/json');

$response = ["success" => false, "errors" => []];

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

    // Benutzer anhand der ID aus der Datenbank abrufen
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Benutzer in der Session speichern
        $_SESSION['user'] = [
            'id' => $user['id'],
            'role' => $user['role'],
            'salutation' => $user['salutation'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'address' => $user['address'],
            'postal_code' => $user['postal_code'],
            'city' => $user['city'],
            'email' => $user['email'],
            'username' => $user['username'],
            'created_at' => $user['created_at'],
            'updated_at' => $user['updated_at'],
            'payment_info' => $user['payment_info']
        ];

        echo json_encode(["success" => true, "message" => "Automatisch eingeloggt."]);
        exit();
    } else {
        // Ungültiger Cookie, löschen
        setcookie("remember_me", "", time() - 3600, "/");
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember_me']);

    if (!$conn) {
        $response["errors"]["general"] = "Datenbankverbindung fehlgeschlagen.";
        echo json_encode($response);
        exit();
    }

    // User aus DB holen
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        $response["errors"]["email"] = "Kein Benutzer mit dieser E-Mail-Adresse gefunden.";
        echo json_encode($response);
        exit();
    }

    if (!password_verify($password, $user['password_hash'])) {
        $response["errors"]["password"] = "Passwort stimmt nicht überein.";
        echo json_encode($response);
        exit();
    }

    // Session starten
    $_SESSION['user'] = [
        'id' => $user['id'],
        'role' => $user['role'],
        'salutation' => $user['salutation'],
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'address' => $user['address'],
        'postal_code' => $user['postal_code'],
        'city' => $user['city'],
        'email' => $user['email'],
        'username' => $user['username'],
        'created_at' => $user['created_at'],
        'updated_at' => $user['updated_at'],
        'payment_info' => $user['payment_info']
    ];

    if ($remember) {
        // Sicherstellen, dass der Cookie sicher gesetzt wird
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