
<?php
// signup-process.php
require_once("config.php"); // Datenbankverbindung (PHP, wird vorausgesetzt in config.php)
header('Content-Type: application/json'); // Antwort als JSON zurückgeben (PHP-Header)

// Wenn die Anfrage vom Typ POST ist (also: Formular wurde per POST geschickt)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Pflichtfelder aus dem Formular holen
    $salutation = $_POST['salutation'];
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
   // Adresse zusammensetzen (Straße + Hausnummer + evtl. Zusatz)
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

    // Datenbankabfrage vorbereiten: Gibt es schon einen Benutzer mit dieser E-Mail oder Username?
    $check = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $check->bind_param("ss", $email, $username);  // Parameter einfügen (SQL-Injection-sicher)
    $check->execute(); // Abfrage ausführen
    $check->store_result(); // Ergebnisse zwischenspeichern

    // Wenn bereits ein Benutzer gefunden wurde → Fehler zurückgeben
    if ($check->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email or username already exists.']);
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);

    
    $role = 'customer'; // Neue User bekommen standardmäßig Rolle "customer"
    $active = 1;

    // SQL-Befehl zum Einfügen eines neuen Benutzers vorbereiten
    $stmt = $conn->prepare("INSERT INTO users (role, salutation, first_name, last_name, address, postal_code, city, country, email, username, password_hash, payment_info, active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
     // Platzhalter mit Variablen ersetzen (Bindings)
    $stmt->bind_param("ssssssssssssi", $role, $salutation, $first_name, $last_name, $address, $postal_code, $city, $country, $email, $username, $hashedPassword, $payment_info, $active);

    // wenn einfügen erfolgreich war
    if ($stmt->execute()) {
        echo json_encode(['success' => true]); // Erfolg an AJAX zurückmelden
    } else {
        http_response_code(500); // Fehlercode an Browser senden (Serverfehler)
        echo json_encode(['success' => false, 'message' => 'SQL Error: ' . $stmt->error]);
        
    }
}
?>