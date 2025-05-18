<?php
// Lädt die Datenbankverbindung und startet ggf. Session (PHP)
require_once("../config/config.php");

// Prüft, ob das Formular per POST abgesendet wurde (PHP)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Liest die E-Mail und das Passwort aus dem POST-Request (PHP)
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prüft, ob das "Remember Me"-Häkchen gesetzt wurde (PHP)
    $remember = isset($_POST['remember_me']);

     // Bereitet SQL-Statement vor, um User mit dieser E-Mail zu suchen (PHP + MySQLi)
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // "s" = string (für E-Mail)
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc(); // Holt User-Daten aus Ergebnis

     // Prüft, ob User existiert und Passwort korrekt ist (PHP + Passwort-Hash)
    if ($user && password_verify($password, $user['password'])) {
        
        // Speichert User-Daten in der Session (PHP + Session)
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role']
        ];

        // Setzt ein Cookie für Auto-Login, falls aktiviert (PHP + Cookie)
        if ($remember) {
            setcookie("remember_me", $user['id'], time() + (86400 * 30), "/"); // 30 tage
        }

         // Weiterleitung zur Startseite nach erfolgreichem Login (PHP)
        header("Location: ../../frontend/pages/index.php");
        exit(); // Beendet das Skript
    } else {
        // Falls Login fehlgeschlagen ist (Benutzer nicht gefunden oder Passwort falsch)
        echo "Login fehlgeschlagen";
    }
}
?>
