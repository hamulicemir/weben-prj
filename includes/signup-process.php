<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Formulardaten abholen
    $anrede = $_POST['anrede'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $strasse = $_POST['strasse'];
    $nr = $_POST['nr'];
    $adresszusatz = $_POST['adresszusatz'] ?? '';
    $plz = $_POST['plz'];
    $ort = $_POST['ort'];
    $land = $_POST['land'];
    $geburtstag = $_POST['geburtstag_jahr'] . '-' . $_POST['geburtstag_monat'] . '-' . $_POST['geburtstag_tag'];
    $telefon = $_POST['telefon'] ?? '';
    $email = $_POST['email'];
    $passwort1 = $_POST['passwort1'];
    $passwort2 = $_POST['passwort2'];

    // Validierung (vereinfachte Variante)
    if ($passwort1 !== $passwort2) {
        die("Passwörter stimmen nicht überein.");
    }

    // Passwort hashen
    $hashedPassword = password_hash($passwort1, PASSWORD_DEFAULT);

    // Optional: Rolle setzen (z. B. 'user')
    $rolle = 'user';

    // User in DB speichern
    $stmt = $conn->prepare("INSERT INTO users (anrede, vorname, nachname, strasse, nr, adresszusatz, plz, ort, land, geburtstag, telefon, email, password, rolle) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssss", $anrede, $vorname, $nachname, $strasse, $nr, $adresszusatz, $plz, $ort, $land, $geburtstag, $telefon, $email, $hashedPassword, $rolle);
    
    if ($stmt->execute()) {
        header("Location: ../pages/login.php");
        exit();
    } else {
        echo "Fehler beim Registrieren: " . $stmt->error;
    }
}
?>
