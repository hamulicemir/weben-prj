<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember_me']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];

        if ($remember) {
            setcookie("remember_me", $user['id'], time() + (86400 * 30), "/"); // 30 tage
        }

        header("Location: ../pages/index.php");
        exit();
    } else {
        echo "Login fehlgeschlagen";
    }
}
?>
