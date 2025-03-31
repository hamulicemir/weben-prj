<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => '',
    'errors' => []
];

// Input-Daten empfangen
$email = $conn->real_escape_string($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$rememberMe = isset($_POST['remember_me']);

// Validierung
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['errors']['email'] = 'Bitte gültige E-Mail eingeben';
}

if (empty($password)) {
    $response['errors']['password'] = 'Bitte Passwort eingeben';
}

if (!empty($response['errors'])) {
    echo json_encode($response);
    exit;
}

// Benutzer abfragen
$stmt = $conn->prepare("SELECT id, password, rolle, vorname FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Passwort überprüfen
if (!$user || !password_verify($password, $user['password'])) {
    $response['message'] = 'Falsche E-Mail oder Passwort';
    $_SESSION['loginError'] = $response['message'];
    echo json_encode($response);
    exit;
}

// Login erfolgreich
$_SESSION['user'] = [
    'id' => $user['id'],
    'role' => $user['rolle'],
    'username' => $user['vorname']
];

// Remember-Me Cookie setzen
if ($rememberMe) {
    setcookie(
        'remember_me', 
        $user['id'], 
        time() + 30 * 24 * 60 * 60, // 30 Tage
        '/',
        '',
        false,  // Secure sollte in Produktion true sein
        true    // HttpOnly
    );
}

$response['success'] = true;
$response['redirect'] = '/index.php';

echo json_encode($response);