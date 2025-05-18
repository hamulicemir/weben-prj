<?php
session_start();
session_unset();
session_destroy();

// Cookie löschen
if (isset($_COOKIE['remember_me'])) {
    setcookie("remember_me", "", time() - 3600, "/");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logged Out</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="shortcut icon" href="../assets/fonts/favicon.ico" type="image/x-icon"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = new bootstrap.Modal(document.getElementById("logoutModal"));
            modal.show();
            setTimeout(() => window.location.href = "../pages/index.php", 2500);
        });
    </script>
</head>
<body>
<?php include './navbar.php'; ?>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h5 class="modal-title w-100" id="logoutLabel">Goodbye!</h5>
      </div>
      <div class="modal-body">
        You’ve been logged out. Redirecting to homepage...
      </div>
    </div>
  </div>
</div>

<?php include './footer.php'; ?>
</body>
</html>
