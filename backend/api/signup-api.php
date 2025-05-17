<?php
// Verbindet die Datei mit der Datenbankkonfiguration (PHP + MySQL)
require_once("config.php");

// Startet eine Session, falls noch keine besteht (PHP)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Gibt an, dass die Antwort als JSON zurückkommt (Header setzen)
header('Content-Type: application/json');

// Nur bei POST-Request ausführen (AJAX-Formular)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Holt alle Formulardaten aus dem POST-Request
    $salutation = $_POST['salutation'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $address = trim($_POST['street'] . ' ' . $_POST['no'] . ' ' . ($_POST['addressaddition'] ?? ''));
    $postal_code = $_POST['zip'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $payment_info = $_POST['payment_info'];

    // Prüft, ob die beiden Passwörter übereinstimmen
    if ($password1 !== $password2) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    // Mindestlänge für Passwort prüfen
    if (strlen($password1) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters.']);
        exit;
    }

     // Prüft, ob E-Mail oder Username bereits existieren
    $check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email or username already exists.']);
        exit;
    }

    // Passwort wird sicher gehasht
    $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
    $role = 'customer';  // Standardrolle
    $active = 1; // Konto ist aktiv

    // Erstellt neuen Benutzer in der Datenbank
    $stmt = $conn->prepare("INSERT INTO users (role, salutation, first_name, last_name, address, postal_code, city, country, email, username, password_hash, payment_info, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssi", $role, $salutation, $first_name, $last_name, $address, $postal_code, $city, $country, $email, $username, $hashedPassword, $payment_info, $active);

    // Führt das INSERT aus
    if ($stmt->execute()) {
        $newUserId = $stmt->insert_id; // Neue Benutzer-ID

        // Holt alle Daten des neu erstellten Users
        $userQuery = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $userQuery->bind_param("i", $newUserId);
        $userQuery->execute();
        $result = $userQuery->get_result();
        $user = $result->fetch_assoc();

         // Speichert Benutzer in der Session (automatisches Login)
        $_SESSION['user'] = $user;

        // Gibt Erfolg als JSON zurück
        echo json_encode(['success' => true]);
        exit;
    } else {
        // Fehlerbehandlung bei SQL-Fehlern
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'SQL Error: ' . $stmt->error]);
    }
}
?>
