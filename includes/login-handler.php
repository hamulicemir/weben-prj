<?php
session_start();
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember_me']);

    // User aus DB holen
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Wenn gehashtes password dann stattdessen:
        if ($user && password_verify($password, $user['password'])) {

        // Session starten
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['vorname'],
            'role' => $user['rolle']
        ];

        // Login merken (Cookie setzen)
        if ($remember) {
            setcookie("remember_me", $user['id'], time() + (86400 * 30), "/"); // 30 Tage gültig
        }

        // Fehler-Flag entfernen, falls vorher gesetzt
        unset($_SESSION['loginError']);

        // Weiterleitung zur Startseite
        header("Location: ../pages/index.php");
        exit();
    } else {
        // Fehler merken für das Formular
        $_SESSION['loginError'] = true;

        // Zurück zum Login-Formular
        header("Location: ../pages/login.php");
        exit();
    }
}
?>