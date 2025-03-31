<?php
session_start();
session_unset();
session_destroy();
setcookie("remember_me", "", time() - 3600, "/");
?>

<?php
session_start();
session_unset();
session_destroy();

// Cookie löschen, damit Auto-Login deaktiviert ist
if (isset($_COOKIE['remember_me'])) {
    setcookie("remember_me", "", time() - 3600, "/");
}

// Weiterleitung zur Bestätigungsseite
header("Location: ../pages/logout-success.php");
exit();
