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
    echo json_encode(["success" => true, "message" => "Already logged in."]);
    exit();
}

// Überprüfen, ob der remember_me-Cookie gesetzt ist
if (isset($_COOKIE['remember_me'])) {
    $userId = $_COOKIE['remember_me'];

    if (!$conn) {
        echo json_encode(["success" => false, "errors" => ["general" => "Database connection failed."]]);
        exit();
    }

    $user = getUserById($conn, $userId);

    if ($user) {
        setUserSession($user);
        echo json_encode(["success" => true, "message" => "Automatically logged in."]);
        exit();
    } else {
        // Ungültiger Cookie, löschen
        setcookie("remember_me", "", time() - 3600, "/");
    }
}

// JSON-API für Login-Check
if ($_SERVER["CONTENT_TYPE"] === "application/json") {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (isset($data["action"]) && $data["action"] === "check") {
        echo json_encode(["success" => isset($_SESSION['user']['id'])]);
        exit();
    }
}


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

    if (!$user) {
        $response["errors"]["email"] = "No user with this e-mail or username found.";
        echo json_encode($response);
        exit();
    }

    if (!password_verify($password, $user['password_hash'])) {
        $response["errors"]["password"] = "Password does not match.";
        echo json_encode($response);
        exit();
    }

    if ((int)$user['active'] !== 1) {
        $response["errors"]["general"] = "Your account is deactivated. Please contact support.";
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