<?php
require_once("config.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    if ($password1 !== $password2) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    if (strlen($password1) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters.']);
        exit;
    }

    $check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email or username already exists.']);
        exit;
    }

    $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
    $role = 'customer';
    $active = 1;

    $stmt = $conn->prepare("INSERT INTO users (role, salutation, first_name, last_name, address, postal_code, city, country, email, username, password_hash, payment_info, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssi", $role, $salutation, $first_name, $last_name, $address, $postal_code, $city, $country, $email, $username, $hashedPassword, $payment_info, $active);

    if ($stmt->execute()) {
        $newUserId = $stmt->insert_id;
        $userQuery = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $userQuery->bind_param("i", $newUserId);
        $userQuery->execute();
        $result = $userQuery->get_result();
        $user = $result->fetch_assoc();

        $_SESSION['user'] = $user;

        echo json_encode(['success' => true]);
        exit;
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'SQL Error: ' . $stmt->error]);
    }
}
?>
