<?php
session_start();
require_once 'config.php';

$userId = $_SESSION['user']['id'] ?? null;
if (!$userId) {
    header("Location: ../pages/login.php");
    exit;
}

$salutation = $_POST['salutation'] ?? '';
$firstName = $_POST['first_name'] ?? '';
$lastName = $_POST['last_name'] ?? '';
$street = $_POST['street'] ?? '';
$no = $_POST['no'] ?? '';
$addressAddition = $_POST['addressaddition'] ?? '';
$postalCode = $_POST['postal_code'] ?? '';
$city = $_POST['city'] ?? '';
$country = $_POST['country'] ?? '';
$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$paymentInfo = $_POST['payment_info'] ?? '';
$currentPw = $_POST['current_password'] ?? '';
$pw1 = $_POST['password1'] ?? '';
$pw2 = $_POST['password2'] ?? '';

// Adresse zusammensetzen
$address = trim($street . ' ' . $no);
if (!empty($addressAddition)) {
    $address .= ', ' . trim($addressAddition);
}

$errors = [];

// E-Mail validieren
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email address.";
}

// Prüfen ob E-Mail oder Username schon existieren (außer beim eigenen Datensatz)
$checkStmt = $conn->prepare("SELECT id FROM users WHERE (email = ? OR username = ?) AND id != ?");
$checkStmt->bind_param("ssi", $email, $username, $userId);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    $errors[] = "Email or username already in use.";
}

// Passwort-Änderung gewünscht?
$changePassword = $pw1 || $pw2 || $currentPw;

if ($changePassword) {
    if (!$pw1 || !$pw2 || !$currentPw) {
        $errors[] = "Please fill in all password fields.";
    } elseif ($pw1 !== $pw2) {
        $errors[] = "New passwords do not match.";
    } elseif (strlen($pw1) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    } else {
        // Altes Passwort prüfen
        $stmt = $conn->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!password_verify($currentPw, $row['password_hash'])) {
            $errors[] = "Current password is incorrect.";
        }
    }
}

// Fehler? Dann zurück mit Session-Fehlermeldung
if ($errors) {
    $_SESSION['errors'] = $errors;
    header("Location: ../pages/edit-profile.php");
    exit;
}

// Daten speichern
if ($changePassword) {
    $hash = password_hash($pw1, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET salutation=?, first_name=?, last_name=?, address=?, postal_code=?, city=?, country=?, email=?, username=?, payment_info=?, password_hash=? WHERE id=?");
    $stmt->bind_param("sssssssssssi", $salutation, $firstName, $lastName, $address, $postalCode, $city, $country, $email, $username, $paymentInfo, $hash, $userId);
} else {
    $stmt = $conn->prepare("UPDATE users SET salutation=?, first_name=?, last_name=?, address=?, postal_code=?, city=?, country=?, email=?, username=?, payment_info=? WHERE id=?");
    $stmt->bind_param("ssssssssssi", $salutation, $firstName, $lastName, $address, $postalCode, $city, $country, $email, $username, $paymentInfo, $userId);
}

$stmt->execute();

// Session aktualisieren
$_SESSION['user']['first_name'] = $firstName;
$_SESSION['user']['last_name'] = $lastName;
$_SESSION['user']['email'] = $email;
$_SESSION['user']['username'] = $username;

header("Location: ../pages/user-account.php");
exit;
