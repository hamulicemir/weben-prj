
<?php
// signup-process.php (Serververarbeitung)
require_once("config.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anrede = $_POST['anrede'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $email = $_POST['email'];
    $passwort1 = $_POST['passwort1'];

    // Prüfung: E-Mail schon registriert?
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'E-Mail ist bereits registriert.']);
        exit;
    }

    $hashedPassword = password_hash($passwort1, PASSWORD_DEFAULT);
    $rolle = 'user';

    $stmt = $conn->prepare("INSERT INTO users (anrede, vorname, nachname, email, password, rolle) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $anrede, $vorname, $nachname, $email, $hashedPassword, $rolle);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['email'] = $email;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Fehler beim Speichern.']);
    }
}
?>