
<?php
// signup-process.php
require_once("config.php");
header('Content-Type: application/json');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Required fields from form
    $salutation = $_POST['title'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $phone = $_POST['phone'] ?? '';
    $address = trim($_POST['street'] . ' ' . $_POST['no'] . ' ' . ($_POST['addressaddition'] ?? ''));
    $postal_code = $_POST['zip'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $payment_info = $_POST['payment_info'];
    
    
    // Password check
    if ($password1 !== $password2) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    if (strlen($password1) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters.']);
        exit;
    }

    // Check if email or username already exist
    $check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $check->bind_param("ss", $email, $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email or username already exists.']);
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);

    // Set default role and active flag
    $role = 'customer';
    $active = 1;

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (role, salutation, first_name, last_name, address, postal_code, city, email, username, password_hash, payment_info, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssi", $role, $salutation, $first_name, $last_name, $address, $postal_code, $city, $email, $username, $hashedPassword, $payment_info, $active);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error saving user: ' . $stmt->error]);
    }
}
?>