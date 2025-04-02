
<?php
// signup-process.php (Serververarbeitung)
require_once("config.php");
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $salutation = $_POST['title'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $address = $_POST['street'] . ' ' . $_POST['no'];
    if (!empty($_POST['addressaddition'])) {
        $address .= ', ' . $_POST['addressaddition'];
    }
    $postal_code = $_POST['zip'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $payment_info = $_POST['payment_info'] ?? null;
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    // Simple validation
    if ($password1 !== $password2) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    // Check if email or username already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email or username already exists.']);
        exit;
    }

    $password_hash = password_hash($password1, PASSWORD_DEFAULT);
    $role = 'customer';

    $stmt = $conn->prepare("INSERT INTO users (role, salutation, first_name, last_name, address, postal_code, city, email, username, password_hash, payment_info) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $role, $salutation, $first_name, $last_name, $address, $postal_code, $city, $email, $username, $password_hash, $payment_info);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['email'] = $email;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed. Please try again.']);
    }
}
?>