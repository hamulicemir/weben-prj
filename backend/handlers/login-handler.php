<?php
session_start();
require_once("../config/config.php");
include "../helpers/functions.php";
// Debugging aktivieren
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// gibt an, dass antwort im json-format kommt
header('Content-Type: application/json');

// vorbereitung einer antwortstruktur
$response = ["success" => false, "errors" => []];

// Überprüfen, ob der Benutzer bereits eingeloggt ist
if (isset($_SESSION['user'])) {
    echo json_encode(["success" => true, "message" => "Already logged in."]);
    exit();
}

// Überprüfen, ob der remember_me-Cookie gesetzt ist -> automatisch einloggen
if (isset($_COOKIE['remember_me'])) {
    $userId = $_COOKIE['remember_me'];

    if (!$conn) {
        echo json_encode(["success" => false, "errors" => ["general" => "Database connection failed."]]);
        exit();
    }

     // benutzer anhand der id holen
    $user = getUserById($conn, $userId);

     // wenn gültig -> session setzen und einloggen
    if ($user) {
        setUserSession($user);
        echo json_encode(["success" => true, "message" => "Automatically logged in."]);
        exit();
    } else {
        // Ungültiger Cookie, löschen
        setcookie("remember_me", "", time() - 3600, "/");
    }
}

// prüft: ob nur login-status gecheckt werden soll (per javascript-api)
if ($_SERVER["CONTENT_TYPE"] === "application/json") {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (isset($data["action"]) && $data["action"] === "check") {
        echo json_encode(["success" => isset($_SESSION['user']['id'])]);
        exit();
    }
}

// wenn formular abgeschickt wurde (per POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $loginInput = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember_me']);

    if (!$conn) {
        $response["errors"]["general"] = "Database connection failed.";
        echo json_encode($response);
        exit();
    }

    // Nutzer anhand E-Mail oder Username suchen
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $loginInput, $loginInput);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // benutzer nicht gefunden
    if (!$user) {
        $response["errors"]["email"] = "No user with this e-mail or username found.";
        echo json_encode($response);
        exit();
    }

    // passwort falsch
    if (!password_verify($password, $user['password_hash'])) {
        $response["errors"]["password"] = "Password does not match.";
        echo json_encode($response);
        exit();
    }

    // account ist deaktiviert
    if ((int)$user['active'] !== 1) {
        $response["errors"]["general"] = "Your account is deactivated. Please contact support.";
        echo json_encode($response);
        exit();
    }    

    // benutzer session setzen
    setUserSession($user);

    // wenn remember me gewählt wurde -> cookie setzen für 30 tage
    if ($remember) {
        setcookie("remember_me", $user['id'], time() + (86400 * 30), "/", "", true, true);
    }

    // login erfolgreich
    $response["success"] = true;
    echo json_encode($response);
    exit();
} else {
    // wenn kein post-request -> fehlermeldung
    $response["errors"]["general"] = "Invalid request.";
    echo json_encode($response);
//löschen dann
file_put_contents("login-debug.log", print_r([
    'POST' => $_POST,
    'SESSION' => $_SESSION,
    'COOKIES' => $_COOKIE,
    'RESPONSE' => $response
], true), FILE_APPEND);


    exit();
}