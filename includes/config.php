<?php
include 'functions.php';
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
    $userById = getUserById($conn, $userId);
    if ($user = $userById) {
        setUserSession($user);
        $_SESSION['user']['remember_me'] = true;
    } else {
        // Cookie ist ungültig, also löschen
        setcookie('remember_me', '', time() - 3600, '/');
    }
}
?>