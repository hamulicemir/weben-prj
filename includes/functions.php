<?php
function getUserById($conn, $userId) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Funktion: Benutzer anhand der E-Mail abrufen
function getUserByEmail($conn, $email) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Funktion: Benutzer in der Session speichern
function setUserSession($user) {
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
}
?>